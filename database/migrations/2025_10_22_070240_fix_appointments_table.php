<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Удаляем старую таблицу
        Schema::dropIfExists('appointments');
        
        // Создаем новую с правильной структурой
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients', 'id_patient')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors', 'id_doctor')->onDelete('cascade');
            $table->dateTime('datetime');
            $table->string('office');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
        
        // Восстанавливаем старую структуру (если нужно откатить)
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('fio');
            $table->string('category');
            $table->date('birth_date');
            $table->timestamps();
        });
    }
};