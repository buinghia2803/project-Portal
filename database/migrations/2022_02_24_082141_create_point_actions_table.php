<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_actions', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id', 'point_actions_member_id_fk')->references('id')->on('members')->onDelete('cascade');
            $table->date('date');
            $table->char('month', 7);
            $table->char('year', 4);
            $table->string('action', 100);
            $table->integer('point');
            $table->tinyInteger('status')->default('0')->comment('0: new; 1: approved');
            $table->bigInteger('created_by');
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
        Schema::dropIfExists('point_actions');
    }
}
