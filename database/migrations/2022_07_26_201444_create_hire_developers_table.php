<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hire_developers', function (Blueprint $table) {
//            $table->bigIncrements('id');
            $table->id();
//            $table->string('id', 36)->primary();
//            $table->foreignId('developer_id')->constrained('developers')->cascadeOnDelete();
//            $table->integer('developer_id')->unsigned();
//            $table->foreign('developer_id')->references('id')->on('developers');
            $table->bigInteger('developer_id')->unsigned()->index(); // this is working
            $table->foreign('developer_id')->references('id')->on('developers')->onDelete('cascade');
            $table->text('names');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
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
        Schema::dropIfExists('hire_developers');
    }
};
