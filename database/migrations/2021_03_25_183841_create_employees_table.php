<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->unsignedBigInteger('position_id');
            $table->foreign('position_id')->nullable()->references('id')->on('positions');
            $table->unsignedBigInteger('higher_up_id');
            $table->foreign('higher_up_id')->nullable()->references('id')->on('employees');
            $table->dateTime('recruitment_date')->useCurrent();
            $table->text('email');
            $table->text('phone');
            $table->text('photo');
            $table->decimal('salary',10,2);
            $table->unsignedBigInteger('admin_created_id');
            $table->foreign('admin_created_id')->references('id')->on('users');
            $table->unsignedBigInteger('admin_updated_id');
            $table->foreign('admin_updated_id')->references('id')->on('users');
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
        Schema::dropIfExists('employees');
    }
}
