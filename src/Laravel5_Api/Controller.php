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
 * The main Controller to inherit from.
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
     * Order of listing = order of execution.
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
    protected $loader;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->model_mapping = $this->makeModelMapping();
        $this->request_adapter = $this->makeRequestAdapter($request);
        $this->loader = new PluginLoader($this, $this->plugins);
        $this->afterConstruct();
    }

    /***
    |--------------------------------------------------------------------------
    | Plugins
    |--------------------------------------------------------------------------
    ***/

    /**
     * Proxy: Pass configuration options to a plugin on the loader.
     *
     * @param  String $class   Plugin type
     * @param  array  $options Config parameters (individual per plugin)
     * @return mixed
     */
    public function configurePlugin(String $class, array $options)
    {
        return $this->loader->configurePlugin($class, $options);
    }

    /**
     * Proxy: Run `$argument` through all plugins registered for `$hook` and return their result.
     *
     * @param  String $hook    Hook Interface
     * @param  mixed $argument Whatever the hook requires
     * @return mixed           Whatever the last plugin on that hook returns
     */
    protected function applyHooks(String $hook, $argument)
    {
        return $this->loader->applyHooks($hook, $argument);
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
        array_walk_recursive($this->payload, function (&$leaf) {
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
            'Content-Type' => 'application/json',
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

    /**
     * This is used to receive the model's FQN.
     *
     * Some plugins might need to know which model they are dealing with.
     *
     * @return string
     */
    public function getModelNameWithNamespace()
    {
        return $this->model;
    }
}
