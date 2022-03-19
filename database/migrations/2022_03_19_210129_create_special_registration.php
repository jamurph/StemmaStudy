<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('route')->unique();
            $table->integer('extend_months');
            $table->date('expires');
            $table->timestamps();
        });

        /* Add reference to user to see attribute a source */
        Schema::table('users', function(Blueprint $table){
            $table->foreignId('special_registration_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('special_registrations');
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('special_registration_id');
        });
    }
}
