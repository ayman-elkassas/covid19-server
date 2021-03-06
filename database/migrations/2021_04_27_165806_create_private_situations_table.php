<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivateSituationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_situations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->longText('desc');
            //todo:type (text 1,image 2, video 3, audio 4)
            $table->integer('user_id')->unsigned()->nullable();//fk
            $table->integer('doctor_id')->unsigned()->nullable();//fk

            //Relationships
            $table->foreign('doctor_id')
                ->references('id')->on('doctors')
                ->onDelete('cascade');

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
        Schema::dropIfExists('private_situations');
    }
}
