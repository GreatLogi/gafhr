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
        Schema::table('personnel', function (Blueprint $table) {
            $table->string('password')->after('email')->nullable();
            $table->rememberToken()->after('denomination_id')->nullable();
            $table->string('status_authority_remarks')->after('status')->nullable();
            $table->dateTime('status_changed_at')->after('status_authority_remarks')->nullable();

            $table->date('rod')->nullable()->after('enlistment_date');
            $table->string('pto')->nullable()->after('rod');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personnel', function (Blueprint $table) {
            $table->dropColumn('password');
            $table->dropColumn('remember_token');
            $table->dropColumn('status_authority_remarks');
            $table->dropColumn('status_changed_at');

            $table->dropColumn('rod');
            $table->dropColumn('pto');
        });
    }
};
