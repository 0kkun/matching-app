<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned()->unique();
            $table->string('tweet', 50)->nullable()->default(null)->comment('つぶやき');
            $table->string('introduction', 400)->nullable()->default(null)->comment('自己紹介');
            $table->string('hobby', 100)->nullable()->default(null)->comment('趣味');
            $table->string('blood_type', 10)->nullable()->default(null)->comment('血液型');
            $table->string('job', 100)->nullable()->default(null)->comment('仕事');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
