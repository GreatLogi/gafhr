<?php

declare(strict_types=1);

use App\Models\BookCategory;
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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('serial_number')->nullable();
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->foreignIdFor(BookCategory::class)->constrained();
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
            $table->string('type')->default('free');
            $table->float('price')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('books');
    }
};
