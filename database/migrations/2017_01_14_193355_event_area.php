<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventArea extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('area')->default('');
        });
    }

    public function down()
    {
        Schema::table('events', function(Blueprint $table)
        {
            $table->dropColumn(['area']);
        });
    }
}
