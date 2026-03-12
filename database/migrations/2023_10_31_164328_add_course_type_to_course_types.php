<?php

use App\Models\CourseType;
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
        Schema::table('course_types', function (Blueprint $table) {
            $table->string('type')->after('course')->nullable()->default('CAREER & STAFF (LOCAL)');
        });

        foreach (['PSC+ (NIGERIA)', 'PSC+ (UK)', 'WAR COLLEGE (USA)', 'WAR COLLEGE (UK)'] as $key => $course) {
            CourseType::create([
                'course' => $course,
                'type' => 'CAREER & STAFF (OVERSEAS)',
                'order_of_appearance' => 7 + ($key + 1),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_types', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
