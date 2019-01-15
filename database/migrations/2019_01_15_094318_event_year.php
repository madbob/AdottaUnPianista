<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventYear extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('year')->unsigned()->default(0);
            $table->integer('cover')->unsigned()->default(1);
            $table->integer('icon')->unsigned()->default(1);
        });
    }

    public function down()
    {
        Schema::table('events', function(Blueprint $table) {
            $table->dropColumn(['year']);
            $table->dropColumn(['cover']);
            $table->dropColumn(['icon']);
        });
    }
}
