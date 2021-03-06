# laravel5-api

[![Gitter Chat](https://img.shields.io/gitter/room/sehrgutesoftware/laravel5-api.svg?style=flat-square)](https://gitter.im/sehrgutesoftware/laravel5-api) [![Travis Build Status](https://img.shields.io/travis/sehrgutesoftware/laravel5-api/master.svg?style=flat-square)](https://travis-ci.org/sehrgutesoftware/laravel5-api) [![StyleCI Status](https://styleci.io/repos/66555789/shield)](https://styleci.io/repos/66555789) [![Code Climate](https://img.shields.io/codeclimate/github/sehrgutesoftware/laravel5-api.svg?style=flat-square)](https://codeclimate.com/github/sehrgutesoftware/laravel5-api)

A modular controller for exposing your Laravel 5 Eloquent models as a REST API. All you need to do is create one subclass of the controller per model and set up the routes.

**Disclaimer: This is an early release! Do not use in production without extensive testing! The API is subject to change!**

**Please use Github Issues for bug reports and feature requests.**

## Table of Contents
* [Documentation](#documentation)
* [Getting Started](#getting-started)
* [Components](#components)
  * [Controller](#controller-1)
  * [Validator](#validator)
  * [Transformer](#transformer)
  * [ModelMapping](#modelmapping)
  * [RequestAdapter](#requestadapter)
* [Customization](#customization)
  * [Plugins](#plugins)
  * [Deprecated: Hook Methods](#deprecated-hook-methods)
* [Changelog](#changelog)
* [Compatibility](#compatibility)
* [Testing](#testing)
* [License](#license)

## Documentation
[API Reference v0.7.8](https://sehrgutesoftware.github.io/laravel5-api/api/v0.7.8) ([v0.6.5](https://sehrgutesoftware.github.io/laravel5-api/api/v0.6.5), [v0.5.3](https://sehrgutesoftware.github.io/laravel5-api/api/v0.5.3), [v0.4.2](https://sehrgutesoftware.github.io/laravel5-api/api/v0.4.2), [v0.3.0](https://sehrgutesoftware.github.io/laravel5-api/api/v0.3.0))

## Getting Started

### Install Package
```bash
composer require sehrgut/laravel5-api
```

### Create an Endpoint

#### Controller
Subclass `SehrGut\Laravel5_Api\Controller` and set the eloquent model your controller should expose. Example:

```php
use SehrGut\Laravel5_Api\Controller as ApiController;
use App\Models\Post;

class PostsController extends ApiController
{
    protected $model = Post::class;
}
```

#### Routes
You now have a controller with the same handlers as a [Laravel Resource Controller](https://laravel.com/docs/5.4/controllers#resource-controllers). Those methods can now be used to handle the following routes:

```php
Route::get('/posts', 'PostsController@index');
Route::post('/posts', 'PostsController@store');
Route::get('/posts/{id}', 'PostsController@show');
Route::put('/posts/{id}', 'PostsController@update');
Route::delete('/posts/{id}', 'PostsController@destroy');
```

#### Mapping route parameters to model attributes
By default, it is assumed that there is an `{id}` parameter in all urls pointing to a single resource (`show`, `update`, `destroy`). This parameter is then used to find the corresponding model by its `id` attribute.

If your model's primary key or your route parameter have a different name than `id`, you need to manually map these in your Controller's `$key_mapping`. Example:

```php
protected $key_mapping = [
	// Maps the `{post_id}` url parameter to the model's `primary_key` attribute/db column
	'post_id' => 'primary_key'
];
```

In the same manner, additional url parameters can be mapped to model attributes. This is especially useful when creating endpoints for nested resources like `/api/v1/posts/{post_id}/comments/{comment_id}`.

### Validators & Transformers
You might want to create a *Validator* and a *Transformer* and assign them to your Model in your *ModelMapping*. More on how this works under [Components](#components).

### Error Responses
In order to have Exceptions displayed correctly, make sure to handle `SehrGut\Laravel5_Api\Exceptions\Exception` in your `app/Exceptions/Handler.php`:

```php
use SehrGut\Laravel5_Api\Exceptions\Exception as SehrGutApiException;

class Handler extends ExceptionHandler
{
    public function render($request, Exception $exception)
    {
        if ($exception instanceof SehrGutApiException) {
            return $exception->errorResponse();
        }

        // Possibly other checks

        return parent::render($request, $exception);
    }
}
```


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
|			  |---- ModelMapping.php
|			  +---- RequestAdapter.php
+---- …
```


## Components
The logic is divided up into smaller components, each with their own responsibility:

- **Controller** – controls the entire request/response flow
- **Validator** – ensures the request payload is valid
- **Transformer** – applies transformations to the output data
- **ModelMapping** – knows which Validator/Transformer to use for each Model
- **RequestAdapter** – obtains the parameters from the request

### Controller
#### Available Handlers
- `index()` - Fetch all resources
- `store()` - Create a new resource
- `show()` - Fetch a single resource
- `update()` - Update a single resource
- `destroy()` - Delete a single resource

#### Side-loading and counting relations
Side-loads and relationship counts can be added to the response by enumerating the names of the relation in the `$relations` or `$counts` properties on the controller. Both work recursively, allowing to side-load/count nested relations using dot-syntax.

**Example:**

```php
use SehrGut\Laravel5_Api\Controller as ApiController;
use App\Models\Post;

class PostsController extends ApiController
{
    protected $model = Post::class;

    protected $relations = [
    	'comments',  // Side-load the 'comments' relation within posts
    	'comments.author'  // Side-load the 'author' relation in nested comments
    ];

    protected $counts = [
    	'comments',	 // Add 'comments_count' to posts
    	'comments.responses'  // Add `responses_count` to nested comments
    ];
}
```

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
use SehrGut\Laravel5_Api\Transformers\Transformer;

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
use SehrGut\Laravel5_Api\Transformers\Transformer;

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

### ModelMapping
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
	];

	protected $validators = [
		Post::class =>	PostValidator::class
	];
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


## Customization

### Plugins

Plugins are a way of "hooking into" and manipulating the behaviour of controller actions. They replace the old "hooks", used in versions ≤0.3

#### Usage

Plugins can be registered inside the **Controller** by specifying them in the `$plugins` property. The order of execution will be the order in which they are listed here.

**Example:**

```php
use SehrGut\Laravel5_Api\Plugins\Paginator;
use SehrGut\Laravel5_Api\Plugins\SearchFilter;

class PostsController extends BaseController
{
	protected $plugins = [
		Paginator::class,
		SearchFilter::class,
	];
}
```

##### Declaring Hooks on the Controller

Instead of using Plugins, a controller can also implement any of the [Hooks](#plugin-hooks) itself, in order to influence the request/response lifecycle. In this case, it behaves the same as a Plugin:

1. Declare that the controller `implements` the appropriate Hook Interface
2. Declare the method required by the Interface

If a controller subscribes to a Hook this way, the Hook will first be called on the controller, before it gets handed through the Plugins.

#### Configuration

Some plugins have configurable options, that can be set through the controller. This can be done from inside the `afterConstruct()` method like so:

```php
use SehrGut\Laravel5_Api\Plugins\SearchFilter;

class PostsController extends BaseController
{
	protected $plugins = [SearchFilter::class];

	protected function afterConstruct()
	{
	    $this->configurePlugin(SearchFilter::class, [
	        'searchable' => ['name', 'description'],  // compare to those fields on the model
	        'search_param' => 'query',                // `?query=some+search+query`
	    ]);
	}
}
```

*Please refer to the source code or API reference of the individual plugin to see the available configuration options.*

#### Available Plugins

Please [use the source](https://github.com/sehrgutesoftware/laravel5-api/tree/master/src/Laravel5_Api/Plugins) for definite answers. Still, here's a (probably outdated) list of plugins:

- **Authorizaton** runs Authorization checks using Laravel's built-in [Authorization](https://laravel.com/docs/5.2/authorization) on all five default controller actions.
- **Paginator** allows pagination of `index` result sets. By default, it uses the `limit` and `page` query parameters to determine the requested subset.
- **RelationSplitter** is a pretty successful divorce lawyer from Southern… kidding aside, it makes related objects appear under a separate key in the response, instead of nested inside their relatives.
- **SearchFilter** adds text search to `index` queries. You can configure which model attributes to compare the search term with.

**For help on using the individual plugins, check their respective [source files](https://github.com/sehrgutesoftware/laravel5-api/tree/master/src/Laravel5_Api/Plugins) or the [API reference](#documentation)!**

#### Writing Plugins

A plugin is just a class that extends `SehrGut\Laravel5_Api\Plugins\Plugin`. It can implement one or more *Hooks* in order to influence the controller's behaviour.

##### Plugin Configuration

The base `Plugin` class provides a `protected $config` attribute, to store configuation options, which are settable through the controller's `configurePlugin($name, $options)` method. Use this feature to expose parameters of your plugin to the user (the person writing the controller). Retrieve config options inside the plugin with `$this->config['option_name']`. Default values should be set via the `protected $default_config` property.

##### Example:

```php
<?php
namespace App\Api\V1\Plugins;

use SehrGut\Laravel5_Api\Plugins\Plugin;
use SehrGut\Laravel5_Api\Hooks\AdaptCollectionQuery;
use SehrGut\Laravel5_Api\Hooks\AdaptResourceQuery;

/**
 * Just an example: `dd()` all queries instead of executing them.
 */
class DieAndDumpQuery extends Plugin implements AdaptCollectionQuery, AdaptResourceQuery
{
	$default_config = [
		'option' => 'Reasonable default',
	];

	protected function adaptCollectionQuery()
	{
		dd($this->context->query);
	}

	protected function adaptResourceQuery()
	{
		dd($this->context->query);
	}
}
```

##### Plugin Hooks

The available hooks are listed in the ["Hooks" directory](https://github.com/sehrgutesoftware/laravel5-api/tree/master/src/Laravel5_Api/Hooks).

In order to use a hook, you simply have to declare that your plugin class `implements` the corresponding interface and then actually implement the appropriate method of that interface. Take a look at source code of the [existing plugins](https://github.com/sehrgutesoftware/laravel5-api/tree/master/src/Laravel5_Api/Plugins) to see how this is done.

Each hook interface declares exactly one method. The name of this method is the same as the interface, just with a lowercase first letter. Example: The Hook Interface `AdaptResourceQuery` declares a method named `adaptResourceQuery`.

###### Available Hooks

**`AdaptCollectionQuery::adaptCollectionQuery()`**
Customize the query for fetching a resource collection (`index` action).

**`AdaptResourceQuery::adaptResourceQuery()`**
Customize the query for fetching a single resource (`show`, `update` and `destroy` actions).

**`AdaptRelations::adaptRelations(array $relations)`**
This hook receives an array of relations to be side-loaded with the queried model. Return the adapted array.

**`BeginAction::beginAction()`**
This is the first hook in any action, right after `$context->action` was set.

**`AuthorizeAction::authorizeAction()`**
Hook in here to perform authorization on action level. This hook is only called on the `index` and `store` actions.

**`AuthorizeResource::authorizeResource()`**
Hook in here to perform authorization on a single resource. This hook is called from the `show`, `update` and `destroy` handler right after the resource was fetched from DB and stored into `$this->resource`.

**`FormatCollection::formatCollection()`**
This hook receives a Collection of resources before they are transformed.

**`FormatResource::formatResource()`**
This hook receives a single resource before it is transformed.

**`ResponseHeaders::responseHeaders()`**
Hook in here to manipulate the response headers.

**`BeforeSave::beforeSave()`**
Is called on every `create` and `update` action after the model has been filled from `$context->input` right before the call to `$context->resource->save()`.

**`AfterSave::afterSave()`**
On every `create` and `update` action after the call to `$context->resource->save()`.

**`BeforeCreate::beforeCreate()`**
Hook just before `beforeSave()` but only in the `store` action.

**`BeforeUpdate::beforeUpdate()`**
Hook just before `beforeSave()` but only in the `update` action.

###### Controller / Plugin Context

Each plugin has a reference to the controller's [Context](https://github.com/sehrgutesoftware/laravel5-api/blob/master/src/Laravel5_Api/Context.php) object stored in `Plugin::$context`. The `Context` contains all relevant pieces of data, that a Plugin might need to read or write:

```php
// Read-only:
$context->model;
$context->request;

// Read-write:
$context->input;
$context->action;
$context->query;
$context->resource;
$context->collection;
$context->response;
```

### Deprecated: Hook Methods

**Warning: Hooks are deprecated in favour of Plugins (see above), so be aware when using them: The methods listed below will soon be removed from the controller and substituted with appropriate plugin hooks.** "Hook" in the context of a "Plugin" refers to an interface, rather than a controller method like in the old sense.

There are serveral hooks in the Controller which help you customizing its behaviour. All you need to do is implement the desired method in your controller. For details on the hooks please browse the code and refer to the [API Reference](#documentation).

#### `makeModelMapping()`
Dynamically customize the ModelMapping, for example based on Auth/Roles

#### `makeRequestAdapter(Request $request)`
Dynamically customize the RequestAdapter.

#### `adaptRules(Array $rules)`
Adapt the validation rules after fetching them from the validator. Return the adapted rules.

#### `afterConstruct()`
Last call in the controller's `__construct()` method.


## Changelog

Please refer to [CHANGELOG.md](CHANGELOG.md).

## Compatibility

* Tested with Laravel 5.3 - 5.6
* Tested with PHP 7.1 - 7.2


## Testing

Tests are based on phpunit and use an in-memory sqlite database. As the tests rely on the laravel framework, composer (dev-) dependencies need to be installed first:

```bash
composer install
vendor/bin/phpunit
```


## License

This software is licensed under the [MIT License](https://opensource.org/licenses/MIT). See [LICENSE.txt](LICENSE.txt) for details.
