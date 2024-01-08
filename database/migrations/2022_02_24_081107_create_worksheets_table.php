<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worksheets', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->unsignedBigInteger('member_id');
            // $table->foreign('member_id', 'worksheets_member_id_fk')->references('id')->on('members')->onDelete('cascade');
            $table->date('work_date');
            $table->tinyInteger('is_holiday')->default('0')->comment('1: Weekend, Holidays, Company day off; 0: workday');
            $table->dateTime('checkin')->nullable();
            $table->dateTime('checkin_original')->nullable();
            $table->dateTime('checkout')->nullable();
            $table->dateTime('checkout_original')->nullable();
            $table->string('late', 10)->nullable();
            $table->string('early', 10)->nullable();
            $table->string('in_office', 10)->nullable();
            $table->string('ot_time', 10)->nullable();
            $table->string('work_time', 10)->nullable();
            $table->string('lack', 10)->nullable();
            $table->string('compensation', 10)->nullable();
            $table->string('paid_leave', 10)->nullable();
            $table->string('unpaid_leave', 10)->nullable();
            $table->string('note', 70)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worksheets');
    }
}
