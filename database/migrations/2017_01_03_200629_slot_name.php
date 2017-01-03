<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SlotName extends Migration
{
    public function up()
    {
        Schema::table('slots', function (Blueprint $table) {
            $table->string('name');
        });
    }

    public function down()
    {
        Schema::table('slots', function(Blueprint $table)
        {
            $table->dropColumn(['name']);
        });
    }
}
