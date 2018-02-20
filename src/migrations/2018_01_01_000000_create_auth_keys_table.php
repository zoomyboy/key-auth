<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateAuthKeysTable extends Migration {
    public function up() {
        Schema::create('auth_keys', function(Blueprint $table) {
            $table->increments('id');
            $table->string('key', 255);
            $table->integer('model_id');
            $table->string('model_type');
        });       
    }

    public function down() {
        Schema::dropIfExists('auth_keys');
    }
}
