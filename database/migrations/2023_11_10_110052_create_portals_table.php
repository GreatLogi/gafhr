<?php

declare(strict_types=1);

use App\Models\Permission;
use App\Models\Portal;
use App\Models\Role;
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
        Schema::create('portals', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('portal');
            $table->string('url')->nullable();
            $table->timestamps();
        });

        foreach (['CHR', 'GAMPS', 'MY GAF PORTAL'] as $portal) {
            Portal::create([
                'portal' => $portal,
            ]);
        }

        try {
            Schema::table('permissions', function (Blueprint $table) {
                $table->renameColumn('type', 'portal');
            });

            Schema::table('roles', function (Blueprint $table) {
                $table->renameColumn('base', 'portal');
            });
        } catch (\Throwable $th) {
            //throw $th;
        }

        Permission::where('guard_name', 'admin')->update([
            'guard_name' => 'web',
            'portal' => config('app.name'),
        ]);

        Role::where('guard_name', 'admin')->update([
            'guard_name' => 'web',
            'portal' => config('app.name'),
        ]);

        DB::table('model_has_roles')->where(function ($q) {
            return $q->where('role_id', '!=', 2)->where('model_id', '!=', 3);
        })->update([
            'model_type' => 'App\Models\User',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portals');
    }
};
