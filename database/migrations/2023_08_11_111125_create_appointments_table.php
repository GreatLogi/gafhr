<?php

declare(strict_types=1);

use App\Models\Department;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('appointment')->nullable();
            $table->string('intercom')->default('000')->nullable();
            $table->boolean('info_addressee')->default(0)->nullable();
            $table->boolean('origino')->default(0)->nullable();
            $table->integer('order_of_appearance')->default(0);
            $table->foreignIdFor(Department::class)->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
