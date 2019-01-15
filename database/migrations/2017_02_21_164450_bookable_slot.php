<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BookableSlot extends Migration
{
    public function up()
    {
        Schema::table('slots', function (Blueprint $table) {
            $table->boolean('bookable')->default(true);
        });
    }

    public function down()
    {
        Schema::table('slots', function(Blueprint $table) {
            $table->dropColumn(['bookable']);
        });
    }
}
