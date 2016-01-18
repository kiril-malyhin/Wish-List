<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned()->default(1);
            $table->integer('media_id')->unsigned()->default(1);
            $table->integer('contact_id')->unsigned();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email', 255)->unique();
            $table->string('password', 60);
            $table->tinyInteger('is_deleted')->unsigned()->default(0);
            $table->tinyInteger('is_enable')->unsigned()->default(1);
            $table->timestamps('reg_date');
            $table->string('remember_token', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user');
    }
}
