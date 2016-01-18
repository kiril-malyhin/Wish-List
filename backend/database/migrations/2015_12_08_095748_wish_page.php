<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WishPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wish', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name', 255);
            $table->string('description',1000);
            $table->string('link',255);
            $table->integer('media_id');
            $table->integer('category_id');
            $table->boolean('publish_state');
            $table->boolean('present_state');
            $table->tinyInteger('is_deleted')->unsigned()->default(1);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wish');
    }
}