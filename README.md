# key-auth
Laravel Key authentication guard. This package provides authentication functionality via a simple key.

# Setup
Make sure to import the Service Provider:
```
...
\Zoomyboy\KeyAuth\ServiceProvider::class
...

```

You should register the Routes for key login in the AuthServiceProvider:
```
public function boot() {
    \Zoomyboy\KeyAuth\Guard::routes();
    ...
}


For every model that supports this functionality, you should include the HasAuthKeys Trait:

```
public function AuthUser extends Model {
  use \Zoomyboy\KeyAuth\HasAuthKeys;
}
```

Next, call the "generateKeyAuthLink" method on the model to create a Login URL for that model:

```
$model->generateKeyAuthLink('/redirect', 'guard');
```
The second parameter is optional. If left off, the default guard set in the application will be used for login.
The first parameter is the URL that the user will be redirected to after successful login.

