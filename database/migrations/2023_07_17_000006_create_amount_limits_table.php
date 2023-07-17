<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmountLimitsTable extends Migration
{
    public function up()
    {
        Schema::create('amount_limits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('royalties', 15, 2);
            $table->float('advance_limit', 15, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
