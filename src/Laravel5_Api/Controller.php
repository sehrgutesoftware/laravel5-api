<?php

namespace SehrGut\Laravel5_Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as IlluminateController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use SehrGut\Laravel5_Api\Exceptions\Http\NotFound;
use SehrGut\Laravel5_Api\Hooks\AdaptCollectionQuery;
use SehrGut\Laravel5_Api\Hooks\AdaptRelations;
use SehrGut\Laravel5_Api\Hooks\AdaptResourceQuery;
use SehrGut\Laravel5_Api\Hooks\AfterSave;
use SehrGut\Laravel5_Api\Hooks\AuthorizeAction;
use SehrGut\Laravel5_Api\Hooks\AuthorizeResource;
use SehrGut\Laravel5_Api\Hooks\BeforeCreate;
use SehrGut\Laravel5_Api\Hooks\BeforeSave;
use SehrGut\Laravel5_Api\Hooks\BeforeUpdate;
use SehrGut\Laravel5_Api\Hooks\BeginAction;
use SehrGut\Laravel5_Api\Hooks\FormatCollection;
use SehrGut\Laravel5_Api\Hooks\FormatResource;
use SehrGut\Laravel5_Api\Plugins\Plugin;
use SehrGut\Laravel5_Api\Transformers\Transformer;

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

    /**
     * The Eloquent Model that is exposed/accessed through this controller.
     *
     * @var Model
     */
    protected $model;

    public $request_adapter;
    public $model_mapping;

    protected $loader;
    protected $context;

    public function __construct(Request $request)
    {
        $this->model_mapping = $this->makeModelMapping();
        $this->request_adapter = $this->makeRequestAdapter($request);

        $this->context = new Context([
            'controller' => $this,
            'request' => $request,
            'model' => $this->model,
        ]);

        $this->loader = new PluginLoader($this, $this->context, $this->plugins);

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
     * @param string $class   Plugin type
     * @param array  $options Config parameters (individual per plugin)
     *
     * @return mixed
     */
    public function configurePlugin(String $class, array $options)
    {
        return $this->loader->configurePlugin($class, $options);
    }

    /**
     * Proxy: Run the `context` through all plugins registered for `$hook` and return their result.
     *
     * @param string $hook     Hook Interface
     * @param mixed  $argument Whatever the hook requires
     *
     * @return mixed Whatever the last plugin on that hook returns
     */
    protected function applyHooks(String $hook)
    {
        $this->loader->applyHooks($hook);
    }

    /**
     * Proxy: Run `$argument` through all plugins registered for `$hook` and return their result.
     *
     * @param string $hook     Hook Interface
     * @param mixed  $argument Whatever the hook requires
     *
     * @return mixed Whatever the last plugin on that hook returns
     */
    protected function applyHooksWithArgument(String $hook, $argument)
    {
        return $this->loader->applyHooksWithArgument($hook, $argument);
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
        $this->beginAction('index');
        $this->applyHooks(AuthorizeAction::class);
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
        $this->beginAction('store');
        $this->applyHooks(AuthorizeAction::class);
        $this->gatherInput();
        $this->validateInput();
        $this->createResource();
        $this->formatResource();

        return $this->makeResponse();
    }

    /**
     * Request Handler: Create multiple new new resources at a time.
     *
     * @return Response
     */
    public function storeMany()
    {
        $this->beginAction('storeMany');
        $this->applyHooks(AuthorizeAction::class);
        $this->gatherInput();
        $this->validateInput($only_present = false, $many = true);
        $this->createMany();
        $this->formatCollection();

        return $this->makeResponse();
    }

    /**
     * Request Handler: Show a single resource.
     *
     * @return Response
     */
    public function show()
    {
        $this->beginAction('show');
        $this->getResource();
        $this->applyHooks(AuthorizeResource::class);
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
        $this->beginAction('update');
        $this->getResource();
        $this->applyHooks(AuthorizeResource::class);
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
        $this->beginAction('destroy');
        $this->getResource();
        $this->applyHooks(AuthorizeResource::class);
        $this->destroyResource();

        return $this->makeResponse('', 204);
    }

    /***
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    ***/

    /**
     * Set the `action` property on the context and call the first hook.
     *
     * @param string $action
     *
     * @return void
     */
    protected function beginAction(string $action)
    {
        $this->context->action = $action;
        $this->applyHooks(BeginAction::class);
    }

    /**
     * Fetch a single record from the DB and store it to $this->context->resource.
     *
     * @throws NotFound In case no record matches the query
     *
     * @return void
     */
    protected function getResource()
    {
        $this->context->query = $this->model::with($this->getRelations())
            ->withCount($this->getDirectCounts());

        $this->filterByRequest($this->context->query);

        $this->applyHooks(AdaptResourceQuery::class);

        try {
            $this->context->resource = $this->context->query->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new NotFound();
        }
    }

    /**
     * Fetch a Collection of Resources from the databse and store it to $this->context->collection.
     *
     * @return void
     */
    protected function getCollection()
    {
        $this->context->query = $this->model::with($this->getRelations())
            ->withCount($this->getDirectCounts());

        $this->filterByRequest($this->context->query);

        $this->applyHooks(AdaptCollectionQuery::class);

        $this->context->collection = $this->context->query->get();
    }

    /**
     * Populate payload, applying hooks before transforming.
     *
     * @return void
     */
    protected function formatResource()
    {
        $this->applyHooks(FormatResource::class);
        $this->payload = $this->transform($this->context->resource);
    }

    /**
     * Populate payload, applying hooks before transforming.
     *
     * @return void
     */
    protected function formatCollection()
    {
        $this->applyHooks(FormatCollection::class);
        $this->payload = $this->transform($this->context->collection);
    }

    /**
     * Apply transformers recusively to the payload.
     *
     * @param  Model|Collection $subject
     * @return $this
     */
    protected function transform($subject)
    {
        return (new Transformer($this->model_mapping))->transformAny($subject);
    }

    /**
     * Apply filters based on the $key_mapping. If a key is present in the
     * request, an appropriate where clause will be added to the query.
     *
     * @param Builder $query   The query to apply the filters to
     * @param array   $mapping (optional) A mapping to use instead of $this->key_mapping
     *
     * @return void
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
                    $that->filterByRequest($subquery, $mapping);
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
    }

    /**
     * Get the request data from the adapter and store it to $this->context->input.
     *
     * @return void
     */
    protected function gatherInput()
    {
        $this->context->input = $this->request_adapter->getPayload();
    }

    /**
     * Validate the input data using the appropriate validator.
     *
     * @param bool $only_present Whether to only validate fields present in $this->context->input
     * @param bool $many Whether to validate an array of records
     *
     * @return void
     */
    protected function validateInput($only_present = false, $many = false)
    {
        $validator = $this->model_mapping->getValidatorFor($this->model);
        $raw_rules = $many ? $validator::getRulesMany() : $validator::getRules();
        $rules = $this->adaptRules($raw_rules);

        // Drop attributes from the input that have no rules
        if (!empty($rules)) {
            $input_whitelist = array_keys($rules);
            if ($many) {
                foreach ($this->context->input as &$item) {
                    $item = array_only($item, $input_whitelist);
                }
            } else {
                $this->context->input = array_only($this->context->input, $input_whitelist);
            }
        }

        $validator::validate($this->context->input, $rules, $only_present);
    }

    /**
     * Create a new instance of the current Model, fill it with the input data,
     * save it to the database and refresh it to get all attributes populated.
     *
     * @param array $attributes (optional) Override attributes to set on creation
     *
     * @return void
     */
    protected function createResource(array $attributes = null)
    {
        $input = is_null($attributes) ? $this->context->input : $attributes;
        $this->context->resource = new $this->model($input);

        // Add values for parent records
        foreach ($this->key_mapping as $request_key => $db_key) {
            if (!is_array($db_key)) {  // Key mapping items can be `key => value` or `numeric_key => Array`
                if ($this->request_adapter->hasKey($request_key)) {
                    $this->context->resource->$db_key = $this->request_adapter->getValueByKey($request_key);
                }
            }
        }

        $this->applyHooks(BeforeCreate::class);
        $this->applyHooks(BeforeSave::class);
        $this->context->resource->save();
        $this->applyHooks(AfterSave::class);
        $this->refreshResource();
    }

    /**
     * Store many models to the database.
     *
     * @return void
     */
    protected function createMany()
    {
        $this->context->collection = new Collection();

        DB::transaction(function () {
            foreach ($this->context->input as $attributes) {
                $this->createResource($attributes);
                $this->context->collection->push($this->context->resource);
            }
            $this->context->resource = null;
        });
    }

    /**
     * Update the resource with the input data.
     *
     * @return void
     */
    protected function updateResource()
    {
        $this->context->resource->fill($this->context->input);
        $this->applyHooks(BeforeUpdate::class);
        $this->applyHooks(BeforeSave::class);
        $this->context->resource->save();
        $this->applyHooks(AfterSave::class);
        $this->refreshResource();
    }

    /**
     * Delete the resource.
     *
     * @return void
     */
    protected function destroyResource()
    {
        $this->context->resource->delete();
    }

    protected function makeResponse($payload = null, $status_code = 200)
    {
        $payload = is_null($payload) ? $this->payload : $payload;
        $this->context->response = new Response($payload, $status_code);

        $this->context->response->headers->add(['Content-Type' => 'application/json']);

        $this->applyHooks(BeforeResponse::class);

        return $this->context->response;
    }

    /**
     * Load a fresh instance of the current resource from the database.
     *
     * @return void
     */
    protected function refreshResource()
    {
        $this->context->resource = $this->context->resource->fresh($this->getRelations());
    }

    /**
     * Get an array of counts on the queried model, eliminating nested counts.
     *
     * @return array
     */
    protected function getDirectCounts()
    {
        return array_filter($this->counts, function ($count) {
            return !str_contains($count, '.');
        });
    }

    /**
     * Get an array of relations to be side-loaded, taking care of nested counts.
     *
     * @return array
     */
    protected function getRelations()
    {
        $nested_counts = $this->getNestedCountsByRelation();

        $relations = $this->relationsWithCounts($nested_counts);

        return $this->applyHooksWithArgument(AdaptRelations::class, $relations);
    }

    /**
     * Return `$this->relations`, enriched with closures
     * querying for counts on the related models.
     *
     * @param array $nested_counts
     *
     * @return array
     */
    private function relationsWithCounts(array $nested_counts)
    {
        $relations = [];

        foreach ($this->relations as $name) {
            if (array_key_exists($name, $nested_counts)) {
                // There are counts to be performed on this relation
                $counts = $nested_counts[$name];
                $relations[$name] = function ($query) use ($counts) {
                    return $query->withCount($counts);
                };
                continue;
            }

            // Fallback: No counts defined for this relation
            $relations[] = $name;
        }

        return $relations;
    }

    /**
     * Get an array mapping relations to counts that should be included on the relation.
     *
     * @return array
     */
    private function getNestedCountsByRelation()
    {
        // Get all counts on related models (containing a dot)
        $nested_counts = array_filter($this->counts, function ($count) {
            return str_contains($count, '.');
        });

        return $this->groupCountsByRelation($nested_counts);
    }

    /**
     * Group the counts by the relation on which they should be performed.
     *
     * @param array $nested_counts
     *
     * @return array
     */
    private function groupCountsByRelation(array $nested_counts)
    {
        $result = [];

        foreach ($nested_counts as $value) {
            $fragments = explode('.', $value);
            $count = array_pop($fragments);
            $relation = implode('.', $fragments);

            if (!array_key_exists($relation, $result)) {
                $result[$relation] = [];
            }

            $result[$relation][] = $count;
        }

        return $result;
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
     * Use this hook to apply custom logic after the controller instance has been created.
     *
     * @return void
     */
    protected function afterConstruct()
    {
        //
    }
}
