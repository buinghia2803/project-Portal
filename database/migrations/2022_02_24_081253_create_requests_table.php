<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id', 'requests_member_id_fk')->references('id')->on('members')->onDelete('cascade');
            $table->tinyInteger('request_type')->default('1')->comment('1: forget check-in/check-out; 2: paid leave; 3: unpaid leave; 4: late/early; 5: ot');
            $table->date('request_for_date');
            $table->dateTime('check_in')->nullable();
            $table->dateTime('check_out')->nullable();
            $table->string('compensation_time', 10)->nullable();
            $table->date('compensation_date')->nullable();
            $table->tinyInteger('leave_all_day')->nullable()->default('0')->comment('1: leave all day; 0: leave by range');
            $table->string('leave_start', 10)->nullable();
            $table->string('leave_end', 10)->nullable();
            $table->string('leave_time', 10)->nullable();
            $table->string('request_ot_time', 10)->nullable();
            $table->bigInteger('manager_id')->nullable();
            $table->bigInteger('admin_id')->nullable();
            $table->string('reason', 100)->nullable();
            $table->tinyInteger('status')->default('0')->comment('-1: reject; 0: sent; 1: confirmed; 2: approved');
            $table->tinyInteger('manager_confirmed_status')->default('0')->comment('0: not confirmed; 1: confirmed');
            $table->dateTime('manager_confirmed_at')->nullable();
            $table->string('manager_confirmed_comment', 100)->nullable();
            $table->tinyInteger('admin_approved_status')->default('0')->comment('0: not approved; 1: approved');
            $table->dateTime('admin_approved_at')->nullable();
            $table->string('admin_approved_comment', 100)->nullable();
            $table->tinyInteger('error_count')->default('1')->comment('1: member error; 0: system error');
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
        Schema::dropIfExists('requests');
    }
}
