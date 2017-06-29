<?php

namespace SehrGut\Laravel5_Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as IlluminateController;
use Illuminate\Support\Collection;
use SehrGut\Laravel5_Api\Exceptions\Http\NotFound;
use SehrGut\Laravel5_Api\Hooks\AdaptCollectionQuery;
use SehrGut\Laravel5_Api\Hooks\AdaptResourceQuery;
use SehrGut\Laravel5_Api\Hooks\AuthorizeAction;
use SehrGut\Laravel5_Api\Hooks\AuthorizeResource;
use SehrGut\Laravel5_Api\Hooks\FormatCollection;
use SehrGut\Laravel5_Api\Hooks\FormatResource;
use SehrGut\Laravel5_Api\Hooks\ResponseHeaders;
use SehrGut\Laravel5_Api\Plugins\Plugin;

/**
 * The main Controler to inherit from.
 */
class Controller extends IlluminateController
{
    /**
     * Maps request parameters to database columns.
     *
     * For each pair, an additional where clause is added to
     * the query in case the key is present in the request.
     *
     * Example:
     * The following example maps the `post_id` database column to the
     * `{post}` parameter in the url `/posts/{post}/comments/{comment}`:
     * ```
     *     protected $key_mapping = [
     *         'post' => 'post_id'
     *     ]
     * ```
     *
     * You can also map url parameters to columns on related models. To do so,
     * just specify an object instead of a `key => value` pair.
     *
     * Example:
     * Get all answers to a comment on a post where the post
     * is indirectly related to the answer via the comment:
     * `/posts/{post_id}/comments/{comment_id}/answers/{answer_id}`
     *
     * ```
     *     protected $key_mapping = [
     *         'answer_id' => 'id',
     *         [
     *             'relation' => 'comment',
     *             'mapping' => [
     *                 'comment_id' => 'id'
     *                 'post_id' => 'post_id'
     *             ]
     *         ]
     *     ];
     * ```
     *
     * @var array
     */
    protected $key_mapping = [
        'id' => 'id',
    ];

    /**
     * The relations to load with the model from the DB.
     *
     * @var array
     */
    protected $relations = [];

    /**
     * The relations to fetch counts for.
     *
     * @var array
     */
    protected $counts = [];

    /**
     * Use these plugins. List all Plugin classes here.
     *
     * @var array
     */
    protected $plugins = [];

    /**
     * Use this to simply override the ModelMapping.
     *
     * @var ModelMapping
     */
    protected $model_mapping_class = ModelMapping::class;

    /**
     * Use this to simply override the RequestAdapter.
     *
     * @var RequestAdapter
     */
    protected $request_adapter_class = RequestAdapter::class;

    public $request_adapter;
    public $request;
    public $model_mapping;
    public $resource;

    protected $model;
    protected $input;
    protected $collection;

    /**
     * Maps hooks to plugin instances. Don't add anything here manually!
     *
     * @var array
     */
    private $hooks = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->model_mapping = $this->makeModelMapping();
        $this->request_adapter = $this->makeRequestAdapter($request);
        $this->loadPlugins();
        $this->afterConstruct();
    }

    /***
    |--------------------------------------------------------------------------
    | Plugins / Hooks
    |--------------------------------------------------------------------------
    ***/

    /**
     * Load all plugins registered in `$plugins` and save their hooks to `$hooks`.
     *
     * @return void
     */
    protected function loadPlugins()
    {
        foreach (array_unique($this->plugins) as $class) {
            $instance = new $class($this);

            $hooks = class_implements($class);
            foreach ($hooks as $hook) {
                $this->registerHook($instance, $hook);
            }
        }
    }

    /**
     * Register a plugin to a single hook.
     *
     * @param Plugin $plugin The plugin instance
     * @param string $hook   FQN of the hook interface
     *
     * @return void
     */
    protected function registerHook(Plugin $plugin, String $hook)
    {
        if (!array_key_exists($hook, $this->hooks)) {
            $this->hooks[$hook] = [];
        }
        $this->hooks[$hook][] = $plugin;
    }

    /**
     * Pass the `$argument` to all plugins registered for `$hook`
     * consecutively and return the result of the last plugin.
     *
     * @param string $hook     FQN of the hook interface
     * @param mixed  $argument Argument passed to the first hook
     *
     * @return mixed Return value of the last hook
     */
    protected function applyHooks(String $hook, $argument)
    {
        $method_name = $this->getHookMethodName($hook);

        // Check if there are any plugins for this hook
        if (array_key_exists($hook, $this->hooks)) {

            // Call all plugins, passing the return value of the
            // previous hook as first argument to the next
            foreach ($this->hooks[$hook] as $plugin) {
                $argument = $plugin->$method_name($argument);
            }
        }

        return $argument;
    }

    /**
     * Turn the FQN of a hook Interface into its corresponding method name.
     *
     * @param string $fqn FQN of the hook
     *
     * @return string Name of the hook method
     */
    private function getHookMethodName(String $fqn)
    {
        $without_namespace = array_last(explode('\\', $fqn));

        return lcfirst($without_namespace);
    }

    /**
     * Pass configuration array to a plugin instance.
     *
     * @param string $name    FQN of the plugin
     * @param array  $options Array of options for the plugin
     *
     * @return void
     */
    protected function configurePlugin(String $name, array $options)
    {
        foreach ($this->hooks as $plugins) {
            foreach ($plugins as $plugin) {
                if ($plugin instanceof $name) {
                    $plugin->configure($options);
                }
            }
        }
    }

    /***
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    ***/

    /**
     * Request Handler: List all resources.
     *
     * @return Response
     */
    public function index()
    {
        $this->applyHooks(AuthorizeAction::class, 'index');
        $this->getCollection();
        $this->formatCollection();

        return $this->makeResponse();
    }

    /**
     * Request Handler: Create a new resource.
     *
     * @return Response
     */
    public function store()
    {
        $this->applyHooks(AuthorizeAction::class, 'store');
        $this->gatherInput();
        $this->validateInput();
        $this->createResource();
        $this->formatResource();

        return $this->makeResponse();
    }

    /**
     * Request Handler: Show a single resource.
     *
     * @return Response
     */
    public function show()
    {
        $this->applyHooks(AuthorizeAction::class, 'show');
        $this->getResource();
        $this->applyHooks(AuthorizeResource::class, 'show');
        $this->formatResource();

        return $this->makeResponse();
    }

    /**
     * Request Handler: Update a resource.
     *
     * @return Response
     */
    public function update()
    {
        $this->applyHooks(AuthorizeAction::class, 'update');
        $this->getResource();
        $this->applyHooks(AuthorizeResource::class, 'update');
        $this->gatherInput();
        $this->validateInput(true);
        $this->updateResource();
        $this->formatResource();

        return $this->makeResponse();
    }

    /**
     * Request Handler: Delete a resource.
     *
     * @return Response
     */
    public function destroy()
    {
        $this->applyHooks(AuthorizeAction::class, 'destroy');
        $this->getResource();
        $this->applyHooks(AuthorizeResource::class, 'destroy');
        $this->destroyResource();

        return $this->makeResponse('', 204);
    }

    /***
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    ***/

    /**
     * Fetch a single record from the DB and store it to $this->resource.
     *
     * @throws NotFound In case no record matches the query
     *
     * @return void
     */
    protected function getResource()
    {
        $query = $this->model::with($this->relations)->withCount($this->counts);
        $query = $this->filterByRequest($query);
        $query = $this->applyHooks(AdaptResourceQuery::class, $query);
        try {
            $this->resource = $query->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new NotFound();
        }
    }

    /**
     * Fetch a Collection of Resources from the databse and store it to $this->collection.
     *
     * @return void
     */
    protected function getCollection()
    {
        $query = $this->model::with($this->relations)->withCount($this->counts);
        $query = $this->filterByRequest($query);
        $query = $this->applyHooks(AdaptCollectionQuery::class, $query);
        $this->collection = $query->get();
    }

    /**
     * Populate payload, applying hooks before transforming.
     *
     * @return void
     */
    protected function formatResource()
    {
        $this->payload = $this->applyHooks(FormatResource::class, $this->resource);
        $this->transformPayload();
    }

    /**
     * Populate payload, applying hooks before transforming.
     *
     * @return void
     */
    protected function formatCollection()
    {
        $this->payload = $this->applyHooks(FormatCollection::class, $this->collection->all());
        $this->transformPayload();
    }

    /**
     * Apply transformers recusively to the payload.
     *
     * @return $this
     */
    protected function transformPayload()
    {
        array_walk_recursive($this->payload, function(&$leaf) {
            if ($leaf instanceof Model) {
                $transformer = $this->model_mapping->getTransformerFor(get_class($leaf));
                $leaf = $transformer->transform($leaf);
            }
        });
    }

    /**
     * Apply filters based on the $key_mapping. If a key is present in the
     * request, an appropriate where clause will be added to the query.
     *
     * @param Builder $query   The query to apply the filters to
     * @param array   $mapping (optional) A mapping to use instead of $this->key_mapping
     *
     * @return Builder
     */
    protected function filterByRequest($query, $mapping = null)
    {
        $mapping = $mapping ?: $this->key_mapping;

        foreach ($mapping as $request_key => $db_key) {
            if (is_array($db_key)) {
                // Item is an array -> map to fields of related model
                $that = $this;
                $relation = $db_key['relation'];
                $mapping = $db_key['mapping'];
                $query->whereHas($relation, function ($subquery) use ($that, $mapping) {
                    return $that->filterByRequest($subquery, $mapping);
                });
            } else {
                // Item is `key => value` -> directly map to model
                if ($this->request_adapter->hasKey($request_key)) {
                    $query->where(
                        $db_key,
                        $this->request_adapter->getValueByKey($request_key)
                    );
                }
            }
        }

        return $query;
    }

    /**
     * Get the request data from the adapter and
     * store it to $this->input.
     *
     * @return void
     */
    protected function gatherInput()
    {
        $this->input = $this->request_adapter->getPayload();
    }

    /**
     * Validate the input data using the appropriate validator.
     *
     * @param bool $only_present Whether to only validate fields present in $this->input
     *
     * @return void
     */
    protected function validateInput($only_present = false)
    {
        $validator = $this->model_mapping->getValidatorFor($this->model);
        $rules = $this->adaptRules($validator::getRules());
        $this->input = $validator::validate($this->input, $rules, $only_present);
    }

    /**
     * Create a new instance of the current Model, fill it
     * with the input data, save it to the database and
     * load it anew to get all attributes populated.
     *
     * @return void
     */
    protected function createResource()
    {
        $this->resource = new $this->model($this->input);

        // Add values for parent records
        foreach ($this->key_mapping as $request_key => $db_key) {
            if (!is_array($db_key)) {  // Key mapping items can be `key => value` or `Array`
                if ($this->request_adapter->hasKey($request_key)) {
                    $this->resource->$db_key = $this->request_adapter->getValueByKey($request_key);
                }
            }
        }

        $this->beforeCreate();
        $this->beforeSave();
        $this->resource->save();
        $this->afterSave();
        $this->refreshResource();
    }

    /**
     * Update the resource with the input data.
     *
     * @return void
     */
    protected function updateResource()
    {
        $this->resource->fill($this->input);
        $this->beforeUpdate();
        $this->beforeSave();
        $this->resource->save();
        $this->afterSave();
        $this->refreshResource();
    }

    /**
     * Delete the resource.
     *
     * @return void
     */
    protected function destroyResource()
    {
        $this->resource->delete();
    }

    protected function makeResponse($payload = null, $status_code = 200)
    {
        $payload = is_null($payload) ? $this->payload : $payload;
        $headers = $this->applyHooks(ResponseHeaders::class, [
            'Content-Type' => 'application/json'
        ]);

        $response = new Response($payload, $status_code);
        $response->headers->add($headers);

        return $response;
    }

    /**
     * Load a fresh instance of the current resource from the database.
     *
     * @return void
     */
    protected function refreshResource()
    {
        $this->resource = $this->resource->fresh($this->relations);
    }

    /***
    |--------------------------------------------------------------------------
    | Hooks
    |--------------------------------------------------------------------------
    ***/

    /**
     * Return a ModelMapping instance.
     *
     * This can be used to dynamically customize the
     * mapping, for example based on Auth/Roles.
     *
     * @return ModelMapping
     */
    protected function makeModelMapping()
    {
        return new $this->model_mapping_class();
    }

    /**
     * Return a RequestAdapter instance.
     *
     * This can be used to dynamically customize the adapter.
     *
     * @param Request $request The current Request object
     *
     * @return RequestAdapter
     */
    protected function makeRequestAdapter(Request $request)
    {
        return new $this->request_adapter_class($request);
    }

    /**
     * This is the place to manipulate the validation rules at runtime.
     *
     * @param array $rules The original rules from the Validator
     *
     * @return array The adapted rules
     */
    protected function adaptRules(array $rules)
    {
        return $rules;
    }

    /**
     * Hook in here to customize the input before saving a resource.
     *
     * This happens in both the create and update actions.
     *
     * @return void
     */
    protected function beforeSave()
    {
    }

    /**
     * Hook in here to customize actions after saving a resource.
     *
     * This happens in both the create and update actions.
     *
     * @return void
     */
    protected function afterSave()
    {
    }

    /**
     * Hook in here to customize the input before creating a resource.
     *
     * @return void
     */
    protected function beforeCreate()
    {
    }

    /**
     * Hook in here to customize the input before updating a resource.
     *
     * @return void
     */
    protected function beforeUpdate()
    {
    }

    /**
     * Use this hook to apply custom logic after
     * the controller instance has been created.
     *
     * @return void
     */
    protected function afterConstruct()
    {
    }
}
