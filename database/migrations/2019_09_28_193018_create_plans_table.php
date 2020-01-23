<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pelapak_id');
            $table->foreign('pelapak_id')->references('id')->on('pelapaks')->onDelete('cascade');
            $table->string('judul');
            $table->string('deskripsi');
            $table->string('foto');
            $table->integer('profit');
            $table->integer('dana_dibutuhkan');
            $table->integer('dana_terkumpul');
            $table->integer('days');
            $table->date('start_date');
            $table->integer('status')->default('0');
            $table->rememberToken();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
