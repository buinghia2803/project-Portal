<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->date('published_date');
            $table->string('subject');
            $table->text('message')->nullable();
            $table->tinyInteger('status')->comment('0: draft; 1: published; 2: scheduled');
            $table->string('attachment', 255)->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('published_to')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
