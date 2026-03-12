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
        Schema::create('book_categories', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('category');
            $table->string('description')->nullable();
            $table->json('allowed')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        BookCategory::create([
            'category' => 'Training',
            'description' => 'Training books',
            'allowed' => null,
        ]);
        BookCategory::create([
            'category' => 'Operations',
            'description' => 'Operations books',
            'allowed' => null,
        ]);
        BookCategory::create([
            'category' => 'Security',
            'description' => 'Security books',
            'allowed' => null,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_categories');
    }
};
