<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventDetails extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->text('description');
            $table->string('picture');
        });

        DB::statement("ALTER TABLE events MODIFY COLUMN status ENUM('closed', 'announced', 'published', 'archived')");
    }

    public function down()
    {
        Schema::table('events', function(Blueprint $table)
        {
            $table->dropColumn(['description']);
            $table->dropColumn(['picture']);
        });
    }
}
