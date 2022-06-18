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
        Schema::create('collective_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collective_id')->constrained('collectives');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('role', ['admin', 'member']);
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
        Schema::dropIfExists('collective_members');
    }
};
