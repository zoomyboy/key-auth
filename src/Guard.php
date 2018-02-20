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

    public function __construct(Session $session) {
        $this->session = $session;
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

        $this->session->forget('auth.key');
    }

    public function login($key) {
        $key = AuthKey::where('key', $key)->first();

        if (is_null($key)) {
            throw new UnauthorizedHttpException('Basic', 'Invalid credentials.');
        }

        $this->session->put('auth.key', $key->key);
    }


    /**
     * Fetches the auth key of the curent user from the Key stored in the session
     *
     * @return AuthKey
     * @return null If no userf logged in
     */
    private function fetchKeyFromSession() {
        $key = $this->session->get('auth.key');

        return AuthKey::where('key', $key)->first();
    }

    public static function routes() {
        Route::get('/auth/key/{key}', function($key) {
            auth()->guard('key')->login($key);
            return redirect()->to(rawurldecode(request()->get('url')));
        })->middleware('web');
    }
}
