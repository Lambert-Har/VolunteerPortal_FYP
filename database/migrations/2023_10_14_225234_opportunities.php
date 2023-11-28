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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id');;
            $table->string('title');
            $table->string('description');
            $table->string('category');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->string('province');
            $table->string('district');
            $table->string('skills');
            $table->string('vol_number');
            $table->string('age');
            $table->string('benefit');
            $table->string('logoImage')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
