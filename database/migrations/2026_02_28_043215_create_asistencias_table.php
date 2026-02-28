<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('encargado_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('estudiante_id')
                ->constrained()
                ->onDelete('cascade');
            $table->date('fecha');
            $table->string('estado');
            $table->integer('horas_cumplidas');
            $table->string('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
