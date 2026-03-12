<?php

declare(strict_types=1);

use App\Models\CourseType;
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
        Schema::create('course_types', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('course');
            $table->integer('order_of_appearance')->default(0);
            $table->timestamps();
        });

        $courses = [
            'YOC',
            'JSC',
            'CTCC',
            'SSC',
            'PSC',
            'PSC+',
            'IDC',
        ];

        foreach ($courses as $key => $course) {
            CourseType::create([
                'course' => $course,
                'order_of_appearance' => $key + 1,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_types');
    }
};
