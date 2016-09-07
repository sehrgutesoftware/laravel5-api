<?php
/**
 * Veggies es bonus vobis, proinde vos postulo essum magis kohlrabi welsh onion daikon amaranth tatsoi tomatillo melon azuki bean garlic.
 */

namespace SehrGut\Laravel5_Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as IlluminateController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use SehrGut\Laravel5_Api\Formatters\Formatter;
use SehrGut\Laravel5_Api\Exceptions\Http\NotFound;

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
        'id' => 'id'
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
     * Use this to simply override the Formatter.
     *
     * @var Formatter
     */
    protected $formatter_class = Formatter::class;

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

    protected $model;
    protected $model_mapping;
    protected $formatter;
    protected $input;
    protected $resource;
    protected $collection;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->model_mapping = $this->makeModelMapping();
        $this->request_adapter = $this->makeRequestAdapter($request);
        $this->formatter = $this->makeFormatter($this->model_mapping);
        $this->afterConstruct();
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
        $this->authorizeAction('index');
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
        $this->authorizeAction('store');
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
        $this->authorizeAction('show');
        $this->getResource();
        $this->authorizeResource('show');
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
        $this->authorizeAction('update');
        $this->getResource();
        $this->authorizeResource('update');
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
        $this->authorizeAction('destroy');
        $this->getResource();
        $this->authorizeResource('destroy');
        $this->destroyResource();
        return $this->makeResponse("", 204);
    }


    /***
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    ***/

    /**
     * Fetch a single record from the DB and store it to $this->resource.
     *
     * @return  void
     * @throws  NotFound  In case no record matches the query
     */
    protected function getResource()
    {
        $query = $this->model::with($this->relations)->withCount($this->counts);
        $query = $this->filterByRequest($query);
        $query = $this->adaptResourceQuery($query);
        try {
            $this->resource = $query->firstOrFail();
        }
        catch (ModelNotFoundException $e) {
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
        $query = $this->adaptCollectionQuery($query);
        $this->collection = $query->get();
    }

    /**
     * Generate the response data using our Formatter.
     *
     * @return void
     */
    protected function formatResource()
    {
        $this->response_data = $this->formatter->format($this->resource);
    }

    /**
     * Generate the response data using our Formatter.
     *
     * @return void
     */
    protected function formatCollection()
    {
        $this->response_data = $this->formatter->format($this->collection);
    }

    /**
     * Apply filters based on the $key_mapping. If a key is present in the
     * request, an appropriate where clause will be added to the query.
     *
     * @param   Builder  $query  The query to apply the filters to
     * @param   Array  $mapping  (optional) A mapping to use instead of $this->key_mapping
     * @return  Builder
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
                $query->whereHas($relation, function($subquery) use ($that, $mapping) {
                    return $that->filterByRequest($subquery, $mapping);
                });
            }
            else {
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
     * @param  bool  $only_present  Whether to only validate fields present in $this->input
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

    protected function makeResponse($response_data = null, $status_code = 200)
    {
        $response_data = is_null($response_data) ? $this->response_data : $response_data;

        $response = new Response($response_data, $status_code);
        $response->headers->set('Content-Type', $this->formatter->content_type);
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
     * Return a Formatter instance.
     *
     * This can be used to dynamically customize the formatter.
     *
     * @param  ModelMapping  $mapping  The ModelMapping instance to use
     * @return Formatter
     */
    protected function makeFormatter(ModelMapping $mapping)
    {
        return new $this->formatter_class($mapping, $this);
    }

    /**
     * Return a RequestAdapter instance.
     *
     * This can be used to dynamically customize the adapter.
     *
     * @param  Request  $request  The current Request object
     * @return RequestAdapter
     */
    protected function makeRequestAdapter(Request $request)
    {
        return new $this->request_adapter_class($request);
    }

    /**
     * Make sure the authenticated user is allowed to
     * perform this type of $action.
     *
     * @param   String  $action  The name of the action
     * @return  void
     */
    protected function authorizeAction(String $action) {}

    /**
     * Make sure the authenticated user is allowed to perform
     * this type of $action on $this->resource.
     *
     * @param   String  $action  The name of the action
     * @return  void
     */
    protected function authorizeResource(String $action) {}

    /**
     * A hook to customize the query for all single resource queries.
     *
     * @param  Builder  $query  The original query
     * @return Builder  The customized query
     */
    protected function adaptResourceQuery(Builder $query)
    {
        return $query;
    }

    /**
     * A hook to customize the query for all collection queries.
     *
     * @param  Builder  $query  The original query
     * @return Builder  The customized query
     */
    protected function adaptCollectionQuery(Builder $query)
    {
        return $query;
    }

    /**
     * This is the place to manipulate the validation rules at runtime.
     *
     * @param  Array  $rules The original rules from the Validator
     * @return Array  The adapted rules
     */
    protected function adaptRules(Array $rules)
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
    protected function beforeSave() {}

    /**
     * Hook in here to customize actions after saving a resource
     *
     * This happens in both the create and update actions.
     *
     * @return void
     */
    protected function afterSave() {}

    /**
     * Hook in here to customize the input before creating a resource.
     *
     * @return void
     */
    protected function beforeCreate() {}

    /**
     * Hook in here to customize the input before updating a resource.
     *
     * @return void
     */
    protected function beforeUpdate() {}

    /**
     * Use this hook to apply custom logic after
     * the controller instance has been created.
     *
     * @return void
     */
    protected function afterConstruct() {}
}