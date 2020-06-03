<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_properties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('department_id');
            $table->char('work_time_start',4 )->nullable();
            $table->char('work_time_end', 4)->nullable();
            $table->char('break_time_start',4)->nullable();
            $table->char('break_time_end', 4)->nullable();
            $table->integer('create_user_id');
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->integer('update_user_id');
            $table->timestamp('updated_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_properties');
    }
}
