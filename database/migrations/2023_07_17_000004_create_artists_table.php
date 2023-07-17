<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistsTable extends Migration
{
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('pin')->nullable();
            $table->boolean('pin_reset')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
