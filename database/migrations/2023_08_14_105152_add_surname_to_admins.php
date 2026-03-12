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
        Schema::table('admins', function (Blueprint $table) {
            $table->string('other_names')->after('name')->nullable();
            $table->renameColumn('name', 'surname');
            $table->string('phone')->after('other_names')->nullable();
            $table->string('service_number')->after('phone')->nullable();

            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->foreign('appointment_id')
                ->references('id')->on('appointments')->onDelete('cascade');

            $table->string('rank_code')->after('appointment_id')->nullable();

            $table->dateTime('password_changed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            //
        });
    }
};
