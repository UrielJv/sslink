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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Informacion personal
            $table->string('calle');
            $table->string('numero_exterior');
            $table->string('numero_interior')->nullable();
            $table->string('colonia');
            $table->string('codigo_postal');
            $table->string('municipio');
            $table->string('sexo');
            $table->string('telefono_tutor');

            // Informacion escolar
            $table->string('matricula');
            $table->string('carrera');
            $table->string('escuela');
            $table->string('cct');
            $table->integer('horas_requeridas');
            $table->integer('horas_actuales')->default(0);
            $table->string('area');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->boolean('estatus')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
