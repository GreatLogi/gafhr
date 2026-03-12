<?php

use App\Models\Personnel;
use App\Models\User;
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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('surname')->nullable();
        });

        $users = User::whereIn('service_no', Personnel::pluck('service_no'))->get();
        foreach ($users as  $user) {
            $user->update([
                'surname' => $user->personnel->surname,
                'first_name' => $user->personnel->first_name,
                'other_names' => $user->personnel->other_names,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
        });
    }
};
