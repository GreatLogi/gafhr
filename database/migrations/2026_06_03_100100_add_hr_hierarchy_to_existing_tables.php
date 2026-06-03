<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            if (!Schema::hasColumn('departments', 'ghq_id')) {
                $table->foreignId('ghq_id')->nullable()->after('id')->constrained('ghqs')->nullOnDelete();
            }
            if (!Schema::hasColumn('departments', 'dept_code')) {
                $table->string('dept_code')->nullable()->after('department');
            }
            if (!Schema::hasColumn('departments', 'description')) {
                $table->string('description')->nullable()->after('dept_code');
            }
        });

        Schema::table('units', function (Blueprint $table) {
            if (!Schema::hasColumn('units', 'command_hq_id')) {
                $table->foreignId('command_hq_id')->nullable()->after('id')->constrained('command_hqs')->nullOnDelete();
            }
            if (!Schema::hasColumn('units', 'unit_code')) {
                $afterColumn = Schema::hasColumn('units', 'unit_name') ? 'unit_name' : 'unit';
                $table->string('unit_code')->nullable()->after($afterColumn);
            }
            if (!Schema::hasColumn('units', 'unit_type')) {
                $table->string('unit_type')->nullable()->after('unit_code');
            }
        });

        Schema::table('personnel', function (Blueprint $table) {
            if (!Schema::hasColumn('personnel', 'ghq_id')) {
                $table->unsignedBigInteger('ghq_id')->nullable()->after('present_rank');
            }
            if (!Schema::hasColumn('personnel', 'department_id')) {
                $table->unsignedBigInteger('department_id')->nullable()->after('ghq_id');
            }
            if (!Schema::hasColumn('personnel', 'directorate_id')) {
                $table->unsignedBigInteger('directorate_id')->nullable()->after('department_id');
            }
            if (!Schema::hasColumn('personnel', 'service_hq_id')) {
                $table->unsignedBigInteger('service_hq_id')->nullable()->after('directorate_id');
            }
            if (!Schema::hasColumn('personnel', 'command_hq_id')) {
                $table->unsignedBigInteger('command_hq_id')->nullable()->after('service_hq_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('personnel', function (Blueprint $table) {
            foreach (['command_hq_id', 'service_hq_id', 'directorate_id', 'department_id', 'ghq_id'] as $column) {
                if (Schema::hasColumn('personnel', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('units', function (Blueprint $table) {
            if (Schema::hasColumn('units', 'command_hq_id')) {
                $table->dropConstrainedForeignId('command_hq_id');
            }
            foreach (['unit_type', 'unit_code'] as $column) {
                if (Schema::hasColumn('units', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('departments', function (Blueprint $table) {
            if (Schema::hasColumn('departments', 'ghq_id')) {
                $table->dropConstrainedForeignId('ghq_id');
            }
            foreach (['description', 'dept_code'] as $column) {
                if (Schema::hasColumn('departments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
