<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLoansTable extends Migration
{
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->unsignedBigInteger('artist_id')->nullable();
            $table->foreign('artist_id', 'artist_fk_8758990')->references('id')->on('artists');
        });
    }
}
