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
        Schema::create('table_rencana_belanja', function (Blueprint $table) {
            $table->id();
            $table->integer('group');
            $table->integer('kode');
            $table->integer('qty');
            $table->string('email');
            $table->integer('status');
            $table->tinyInteger('checked');
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
        Schema::dropIfExists('table_rencana_belanja');
    }
};
