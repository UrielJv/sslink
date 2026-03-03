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
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->string('asunto');
            $table->text('descripcion');
            $table->date('fecha');

            // Usuario que emite el reporte
            $table->foreignId('emisor_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Usuario que recibe el reporte
            $table->foreignId('receptor_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};