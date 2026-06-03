<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ghqs', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('name');
            $table->string('location')->nullable();
            $table->timestamps();
        });

        Schema::create('directorates', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->foreignId('ghq_id')->constrained('ghqs')->cascadeOnDelete();
            $table->string('directorate_name');
            $table->string('directorate_code')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('service_hqs', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->foreignId('ghq_id')->constrained('ghqs')->cascadeOnDelete();
            $table->string('service_name');
            $table->string('service_code')->nullable();
            $table->timestamps();
        });

        Schema::create('command_hqs', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->foreignId('service_hq_id')->constrained('service_hqs')->cascadeOnDelete();
            $table->string('command_name');
            $table->string('command_code')->nullable();
            $table->string('command_type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('command_hqs');
        Schema::dropIfExists('service_hqs');
        Schema::dropIfExists('directorates');
        Schema::dropIfExists('ghqs');
    }
};
