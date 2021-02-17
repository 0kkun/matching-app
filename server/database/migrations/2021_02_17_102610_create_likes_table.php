<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('request_user_id')->unsigned()->comment('likeをリクエストしたuser_id');
            $table->bigInteger('receive_user_id')->unsigned()->comment('likeリクエストを受けたuser_id');
            $table->boolean('is_matched')->default(false)->comment('マッチしたかどうか');
            $table->timestamps();

            $table->foreign('request_user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('receive_user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // 複合ユニークにして、リクエストは一回までに制限
            $table->unique(['request_user_id', 'receive_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
