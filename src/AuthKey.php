<?php

namespace Zoomyboy\KeyAuth;

use Illuminate\Database\Eloquent\Model;

class AuthKey extends Model {
    public $timestamps = false;

    public $fillable = ['key', 'guard'];

    public function model() {
        return $this->morphTo();
    }
}
