<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->string('shift_name', 50);
            $table->string('check_in', 10);
            $table->string('check_out', 10);
            $table->string('work_time')->default('08:00');
            $table->integer('lunch_break')->default('60');
            $table->date('duration_start')->nullable();
            $table->date('duration_end')->nullable()->default(null);
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shifts');
    }
}
