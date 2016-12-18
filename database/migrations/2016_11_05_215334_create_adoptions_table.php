<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdoptionsTable extends Migration
{
    public function up()
    {
        Schema::create('adoptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->text('notes');
            $table->integer('capacity')->default(0);
            $table->enum('status', ['pending', 'contacted', 'voided', 'confirmed', 'archived']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('adoptions');
    }
}
