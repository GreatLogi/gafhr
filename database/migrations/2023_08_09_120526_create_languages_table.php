<?php

declare(strict_types=1);

use App\Models\Language;
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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('language');
            $table->timestamps();
        });

        foreach ($this->languages() as $language) {
            Language::updateOrCreate([
                'language' => $language,
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
        Schema::dropIfExists('languages');
    }

    private function languages()
    {
        return [
            'Chinese',
            'Italian',
            'DUTCH',
            'GENMAN',
            'SPANISH',
            'FRENCH',
            'WASA',
            'ARABIC',
            'WALI',
            'VAGLA',
            'TWI',
            'TUWULI',
            'TUMULUNG',
            'TEM',
            'TAMPULMA',
            'TAFI',
            'SIWU',
            'SISAALA',
            'SELEE',
            'SEKPELE',
            'SEHWI',
            'SAFALIBA',
            'PAASAAL',
            'NZEMA',
            'NYANGBO',
            'NTCHAM',
            'NKONYA',
            'NKAMI',
            'NCHUMBULU',
            'NAWURI',
            'NAWDM',
            'NAFAANRA',
            'MAMPRULI',
            'MAASINA',
            'LOGBA',
            'LIGBI',
            'LELEMI',
            'LARTEH',
            'LAMA',
            'KUSUNTU',
            'KUSAAL',
            'KULANGO',
            'KRACHE',
            'KPLANG',
            'KONNI',
            'KONKOMBA',
            'KASEM',
            'KANTOSI',
            'KAMARA',
            'JWIRA-PEPESA',
            'HAUSA',
            'HANGA',
            'GUA',
            'GONJA',
            'GIKYODE',
            'GA',
            'FULFULDE',
            'FRENCH',
            'FAREFARE',
            'FANTE',
            'EWE',
            'ENGLISH',
            'DWANG',
            'DOMPO',
            'DELO',
            'DEG',
            'DANGME',
            'DANGBE',
            'DAGBANI',
            'DAGAARE',
            'CHUMBURUNG',
            'CHEREPON',
            'CHALA',
            'CHAKALI',
            'BULI',
            'BOUNA',
            'BONDOUKOU',
            'BISA',
            'BIRIFOR',
            'BIMOBA',
            'AVATIME',
            'ANYIN',
            'ANUFO',
            'ANIMERE',
            'AKPOSO',
            'AKAN',
            'AHANTA',
            'ADELE',
            'ABRON',
        ];
    }
};
