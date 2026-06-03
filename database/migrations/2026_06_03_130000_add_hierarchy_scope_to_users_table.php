<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'ghq_id')) {
                $table->unsignedBigInteger('ghq_id')->nullable()->after('arm_of_service');
            }
            if (! Schema::hasColumn('users', 'department_id')) {
                $table->unsignedBigInteger('department_id')->nullable()->after('ghq_id');
            }
            if (! Schema::hasColumn('users', 'directorate_id')) {
                $table->unsignedBigInteger('directorate_id')->nullable()->after('department_id');
            }
            if (! Schema::hasColumn('users', 'service_hq_id')) {
                $table->unsignedBigInteger('service_hq_id')->nullable()->after('directorate_id');
            }
            if (! Schema::hasColumn('users', 'command_hq_id')) {
                $table->unsignedBigInteger('command_hq_id')->nullable()->after('service_hq_id');
            }
            if (! Schema::hasColumn('users', 'unit_id')) {
                $table->unsignedBigInteger('unit_id')->nullable()->after('command_hq_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['unit_id', 'command_hq_id', 'service_hq_id', 'directorate_id', 'department_id', 'ghq_id'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
