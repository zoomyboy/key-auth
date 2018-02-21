<?php

namespace Zoomyboy\KeyAuth;

trait HasAuthKeys {
    public function generateAuthKey($guard = null) {
        $guard = $guard ?: config('auth.defaults.key');
        $keyModel = $this->authKeys()->create(['key' => str_random(255), 'guard' => $guard]);

        return $keyModel->key;
    }

    public function authKeys() {
        return $this->morphMany(AuthKey::class, 'model');
    }

    public function generateKeyAuthLink($url, $guard = null) {
        $guard = $guard ?: config('auth.defaults.key');
        return url('/auth/key/'.$this->generateAuthKey($guard).'?url='.rawurlencode($url).'&guard='.$guard);
    }
}
