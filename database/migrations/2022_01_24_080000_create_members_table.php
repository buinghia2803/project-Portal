<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);
            $table->string('member_code', 10)->nullable();
            $table->string('full_name', 100);
            $table->string('email', 80)->unique();
            $table->string('password', 80);
            $table->string('other_email', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->integer('gender')->nullable()->comment('0: female; 1:male');
            $table->integer('marital_status');
            $table->string('avatar', 255)->nullable();
            $table->string('avatar_official', 255)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('permanent_address', 255)->nullable();
            $table->string('temporary_address', 255)->nullable();
            $table->string('identity_number', 12)->nullable();
            $table->date('identity_card_date')->nullable();
            $table->string('identity_card_place', 50)->nullable();
            $table->string('nationality', 50)->nullable();
            $table->string('emergency_contact_name', 70)->nullable();
            $table->string('emergency_contact_relationship', 50)->nullable();
            $table->string('emergency_contact_number', 20)->nullable();
            $table->string('bank_name', 30)->nullable();
            $table->string('bank_account', 20)->nullable();
            $table->string('academic_level', 20)->nullable();
            $table->date('start_date_official')->nullable();
            $table->tinyInteger('status')->nullable()->comment('-1: Da nghi; 1: Chinh thuc; 2: Thu viec; 3 Cọng tac vien/ partime; 4: Lao dong thoi vu; 5: Dao tao/ Fresher');
            $table->text('note')->nullable();
            $table->bigInteger('created_by');
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
        Schema::dropIfExists('members');
    }
}
