<?php

namespace Zoomyboy\KeyAuth;

trait HasAuthKeys {
    public function generateAuthKey() {
        $keyModel = $this->authKeys()->create(['key' => str_random(255)]);

        return $keyModel->key;
    }

    public function authKeys() {
        return $this->morphMany(AuthKey::class, 'model');
    }

    public function generateKeyAuthLink($url) {
        return url('/auth/key/'.$this->generateAuthKey().'?url='.rawurlencode($url));
    }
}
