<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->text('text')->default(NULL);
            $table->string('user');
            $table->date('fulldate');
            $table->boolean('theday');
            $table->boolean('bookmated');
            $table->timestamps();
            $table->unique(['user', 'fulldate']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
