<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('service_no')->unique()->nullable();
            $table->string('surname')->nullable();
            $table->string('other_names')->nullable();

            $table->string('arm_of_service')->nullable();
            $table->string('category')->nullable();

            $table->string('email')->nullable();
            $table->string('appointment_id')->nullable();
            $table->string('appointment_email')->nullable();
            $table->string('phone')->nullable();

            $table->timestamp('email_verified_at')->nullable();

            $table->datetime('account_blocked_at')->nullable();
            $table->datetime('password_updated_at')->nullable();
            $table->string('theme')->default('light');
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('personnel', function (Blueprint $table) {
            $table->dropColumn('email_appt');
            $table->dropColumn('password');
            $table->dropColumn('remember_token');
        });

        // $data = Admin::orderBy('id')->get()
        //     ->map(function ($data, $key) {
        //         $user = User::create([
        //             'surname' => $data->surname,
        //             'other_names' => $data->other_names,
        //             'service_no' => $data->service_no,
        //             'email' => $data->email,
        //             'phone' => $data->phone,
        //             'category' => $data->category,
        //             'arm_of_service' => $data->arm_of_service,
        //             'password' => $data->password,
        //         ]);
        //     });

        Schema::dropIfExists('admins');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
