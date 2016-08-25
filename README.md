# laravel5-api

A modular controller for exposing your Laravel 5 Eloquent models as a REST API. All you need to do is to create one subclass of the controller per model and set up the routes.

## Usage

Subclass `SehrGut\Laravel5_Api\Controller` and set the eloquent model your controller should expose. Example:

```php
use SehrGut\Laravel5_Api\Controller as ApiController;
use App\Models\Post;

class PostsController extends ApiController
{
    protected $model = Post::class;
}
```

You now have a controller with the same handlers as a [Laravel Resource Controller](https://laravel.com/docs/5.2/controllers#restful-resource-controllers):

Those methods can now be used to create the following routes:

```php
Route::get('/posts', 'PostsController@index');
Route::post('/posts', 'PostsController@store');
Route::get('/posts/{post_id}', 'PostsController@show');
Route::put('/posts/{post_id}', 'PostsController@update');
Route::delete('/posts/{post_id}', 'PostsController@destroy');
```

## Components

### Controller

#### Handlers

- `index()` - Fetch all resources
- `store()` - Create a new resource
- `show()` - Fetch a single resource
- `update()` - Update a single resource
- `destroy()` - Delete a single resource

### RequestAdapter
### Formatter
### Validator
### Transformer
### ModelMapping

## Customization

### Authorization

## Compatibility

* Tested with Laravel 5.2
* Works with PHP 5.4 upwards

## License

This software is licensed under the [MIT License](https://opensource.org/licenses/MIT). See [LICENSE.txt](LICENSE.txt) for details.
