<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('addressable_type');
            $table->integer('addressable_id');
            $table->string('adress')->nullable();
            $table->string('city')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states');
            $table->decimal('latitude')->nullable();
            $table->decimal('longitude')->nullable();
            $table->string('background_color')->nullable();
            $table->string('main_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('text_one_color')->nullable();
            $table->string('text_two_color')->nullable();
            $table->string('logo_white')->nullable();
            $table->boolean('active')->default(true);           
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
