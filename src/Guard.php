<?php

namespace Zoomyboy\KeyAuth;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use \Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Route;

class Guard {
    public $user;
    public $session;
    protected $guard;

    public function __construct(Session $session, $guard = null) {
        $this->session = $session;
        $this->guard = $guard ?: config('auth.defaults.key');
    }

    public function check() {
        return $this->user() != null;
    }   

    public function guest() {
        
    }

    public function user() {
        $key = $this->fetchKeyFromSession();

        return $key ? $key->model : null;
    }

    public function id() {
        
    }

    public function validate(array $validate = []) {
        
    }

    public function setUser(Authenticatable $user) {
           
    }

    public function logout() {
        $this->fetchKeyFromSession()->delete();

        $this->session->forget('auth.'.$this->guard.'.key');
    }

    public function login($key) {
        $key = AuthKey::where('key', $key)->where('guard', $this->guard)->first();

        if (is_null($key)) {
            throw new UnauthorizedHttpException('Basic', 'Invalid credentials.');
        }

        $this->session->put('auth.'.$this->guard.'.key', $key->key);
    }


    /**
     * Fetches the auth key of the curent user from the Key stored in the session
     *
     * @return AuthKey
     * @return null If no userf logged in
     */
    private function fetchKeyFromSession() {
        $key = $this->session->get('auth.'.$this->guard.'.key');

        return AuthKey::where('key', $key)->where('guard', $this->guard)->first();
    }

    public static function routes() {
        Route::get('/auth/key/{key}', function($key) {
            $guard = request()->get('guard') ?: config('auth.defaults.key');
            auth()->guard($guard)->login($key);
            return redirect()->to(rawurldecode(request()->get('url')));
        })->middleware('web');
    }
}
