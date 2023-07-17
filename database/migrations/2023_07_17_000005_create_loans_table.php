<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('amount', 15, 2);
            $table->string('code')->nullable();
            $table->integer('duration');
            $table->boolean('processed')->default(0)->nullable();
            $table->boolean('repaid')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
