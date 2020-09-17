<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserToGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_to_group', function (Blueprint $table) {
           
            $table->unsignedBigInteger('group_id')->index('group_id');
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->timestamps();
            $table->softDeletes();

            //$table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            //$table->foreign('group_id')->references('id')->on('groups')->onDelete('CASCADE')->onUpdate('CASCADE');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_to_group');
    }
}
