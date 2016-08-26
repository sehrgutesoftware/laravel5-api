# laravel5-api

A modular controller for exposing your Laravel 5 Eloquent models as a REST API. All you need to do is to create one subclass of the controller per model and set up the routes.

**Disclaimer: This is an early release! Do not use in production without extensive testing!**

**Please use Github Issues for bug reports and feature requests.**

## Getting Started
Subclass `SehrGut\Laravel5_Api\Controller` and set the eloquent model your controller should expose. Example:

```php
use SehrGut\Laravel5_Api\Controller as ApiController;
use App\Models\Post;

class PostsController extends ApiController
{
    protected $model = Post::class;
}
```

You now have a controller with the same handlers as a [Laravel Resource Controller](https://laravel.com/docs/5.2/controllers#restful-resource-controllers). Those methods can now be used to handle the following routes:

```php
Route::get('/posts', 'PostsController@index');
Route::post('/posts', 'PostsController@store');
Route::get('/posts/{post_id}', 'PostsController@show');
Route::put('/posts/{post_id}', 'PostsController@update');
Route::delete('/posts/{post_id}', 'PostsController@destroy');
```

You might want to also create a *Validator* and a *Transformer* and assign them to your Model in your *ModelMapping*. More on this under [Components](#components).

### Structure
In a larger Project with several endpoints, it is reasonable to have a common BaseController where the [ModelMapping](#modelmapping) is defined for all endpoints.

#### Example Directory Structure:

```
app/
|---- PublicApi
|		+---- V1
|			  |---- Controllers
|			  |		|---- BaseController.php
|			  |		|---- PostsController.php
|			  |		+---- PostCommentsController.php
|			  |---- Transformers
|			  |		|---- PostTransformer.php
|			  |		+---- CommentTransformer.php
|			  |---- Validators
|			  |		|---- PostValidator.php
|			  |		+---- CommentValidator.php
|			  |---- Formatter.php
|			  |---- ModelMapping.php
|			  +---- RequestAdapter.php
+---- …
```


## Components<a href="#Components"></a>
The logic is divided up into smaller components, each with their own responsibility:

- **Controller** – controls the entire request/response flow
- **Validator** – ensures the request payload is valid
- **Transformer** – applies transformations to the output data
- **ModelMapping** – knows which Validator/Transformer to use for each Model
- **RequestAdapter** – obtains the parameters from the request
- **Formatter** – defines the response format and structure

### Controller
#### Available Handlers
- `index()` - Fetch all resources
- `store()` - Create a new resource
- `show()` - Fetch a single resource
- `update()` - Update a single resource
- `destroy()` - Delete a single resource

### Validator
In order to create a custom Validator for a model, you can subclass the `Validator` class and set the `$rules` array. After that, the Validator needs to be registered in the `ModelMapping` which is assigned to your Controller. Please refer to the [ModelMapping](#modelmapping) section on how to do this. A Validator could look like this:

```php
use SehrGut\Laravel5_Api\Validator;

class PostValidator extends Validator
{
    protected static $rules = [
        'title' => 'required|min:3|max:100',
        'body' => 'max:65536'
    ];
}
```

### Transformer
To shape how your models are represented at the api, you can do some transformatios on the model while generating the response. This works the same way as with Validators. Just subclass `Transformer` and assign them to your models via the `ModelMapping`.

In your Transformer subclass, you can define the following attributes to customize the output:

```php
use SehrGut\Laravel5_Api\Transformer;

class PostTransformer extends Transformer
{
	// Rename Attributes:
	protected $aliases = [
		'original_attribute_name' => 'new_attribute_name',
		'id' => 'post_id'
	];

	// Remove Attributes:
	protected $drop_attributes = [
		'private_email'
	];

	// Remove Relations:
	protected $drop_relations = [
		'comments'
	];
}
```

Further, you can change the values of individual attributes of your models by defining a `formatAttribute` method on the Transformer where `Attribute` is the camel-case name of the attribute you want to transform. The method should accept a single argument (the original value) and return the transformed attribute. Example:

```php
use SehrGut\Laravel5_Api\Transformer;

class PostTransformer extends Transformer
{
	/**
	 * Correct the date format of the member_since attribute
	 */
	formatMemberSince($value)
	{
		return $value->toDateString();
	}
}
```

### ModelMapping<a href="#ModelMapping"></a>
The Controller asks the ModelMapping which Validator and Transformer it should use for each Model and their respective relations. If no Transformer/Validator is assigned to a model, the respctive defaults are returned (No validation, no transformation).

In order to apply custom Transformers or Validators to your models, you have to create a custom model mapping and assign it to your Controllers (preferrably via a common BaseController).

```php
use SehrGut\Laravel5_Api\ModelMapping as BaseModelMapping;

use App\Models\Post;
use App\PublicApi\V1\Transformers\PostTransformer;
use App\PublicApi\V1\Validators\PostValidator;

class ModelMapping extends BaseModelMapping
{
	protected $transformers = [
		Post::class =>	PostTransformer::class
	]

	protected $validators = [
		Post::class =>	PostValidator::class
	]
}
```

```php
use SehrGut\Laravel5_Api\Controller;

class BaseController extends Controller
{
	protected $model_mapping_class = ModelMapping::class;
}
```

### RequestAdapter
TBD

### Formatter
TBD


## Customization
There are serveral hooks in the Controller which help you customizing its behaviour. All you need to do is implement the desired method in your controller. For details on the hooks please browse the code and refer to the [API Documentation](https://sehrgutesoftware.github.io/laravel5-api/api/).

### Hooks
#### `makeModelMapping()`
Dynamically customize the ModelMapping, for example based on Auth/Roles

#### `makeFormatter(ModelMapping $mapping)`
Dynamically customize the Formatter.

#### `makeRequestAdapter(Request $request)`
Dynamically customize the RequestAdapter.

#### `authorizeAction(String $action)`
Hook in here to perform authorization on action level (`$action = index|store|show|update|destroy`). Calling this hook is the first act of every handler method. You could use the Laravel built-in [Authorization](https://laravel.com/docs/5.2/authorization) and throw an exception here if the user is not authorized to perform this action.

#### `authorizeResource(String $action)`
Hook in here to perform authorization on resource. This method is called from the `show`, `update` and `destroy` handler right after the resource was fetched from DB and stored into `$this->resource`.

#### `adaptResourceQuery(Builder $query)`
Customize the query for fetching a single resource (`show`, `update` and `destroy` actions). Return the adapted query.

#### `adaptCollectionQuery(Builder $query)`
Customize the query for fetching a resource collection (`index` action). Return the adapted query.

#### `adaptRules(Array $rules)`
Adapt the validation rules after fetching them from the validator. Return the adapted rules.

#### `beforeSave()`
Is called on every `create` and `update` action after the model has been filled from `$this->input` right before the call to `$this->resource->save()`.

#### `afterSave()`
On every `create` and `update` action after the call to `$this->resource->save()`.

#### `beforeCreate()`
Same as `beforeSave()` but only in the `store` action.

#### `beforeUpdate()`
Same as `beforeSave()` but only in the `update` action.

#### `afterConstruct()`
Last call in the controller's `__construct()` method.


## Compatibility

* Tested with Laravel 5.2
* Works with PHP 5.4 upwards


## License

This software is licensed under the [MIT License](https://opensource.org/licenses/MIT). See [LICENSE.txt](LICENSE.txt) for details.
