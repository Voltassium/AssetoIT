<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('manufacturer');
            $table->text('specifications')->nullable(); // Add specs
        $table->integer('count')->default(1); // Add count
            $table->enum('status', ['available', 'in_use', 'damaged']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('devices');
    }
};
