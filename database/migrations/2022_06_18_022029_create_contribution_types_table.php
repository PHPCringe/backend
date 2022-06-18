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
        Schema::create('contribution_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collective_id')->constrained('collectives');
            $table->text('name');
            $table->text('description');
            $table->float('cost')->default(0);
            $table->foreignId('currency_id')->constrained('currencies');
            $table->enum('type', ['monthly','annually','onetime']);
            $table->boolean('is_recurring');
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
        Schema::dropIfExists('contribution_types');
    }
};
