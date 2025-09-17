<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');                       // Company name
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('location')->nullable();
            $table->string('pincode')->nullable();
            $table->text('about')->nullable();
            $table->string('slogan')->nullable();
            $table->string('company_image')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
