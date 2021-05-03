<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Endemis;

class EndemisSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $endemis = [
            [
                'imunisasi_id'=>1,
                'daerah'=>'Amerika Serikat, Afrika Selatan, Arab Saudi, Selandia Baru',
            ],
            [
                'imunisasi_id'=>2,
                'daerah'=>'Angola, argentina, Benin, Bolivia, Brazil, Burkina Faso, Burundi, Cameroon, Central African Republic, Chad, Colombia, Congo, Cote D Ivoire , Equador, Equatorial Guinea, French Guiana, Gabon, Gambia, Ghana, Guinea-Bissau, Guyana, Kenya, Liberia, Mali, Mauritania, Niger, Nigeria, Rwanda, Senegal, Sierra Leone, Sudan, South Sudan, Togo dan Uganda, Suriname, Trinidad, Panama, Paraguay, Peru dan Venezuela',
            ],
            [
                'imunisasi_id'=>11,
                'daerah'=>'Sub-Saharan Afrika dan Asia Selatan, Amerika Selatan, Russia',
            ],
            [
                'imunisasi_id'=>21,
                'daerah'=>'Provinsi Bali, Kalimantan Barat, Sulawesi Utara, Nusa Tenggara Timur, DKI Jakarta, DI Yogyakarta, Jawa Tengah, Nusa Tenggara Barat, dan Kepulauan Riau',
            ],
        ];
        foreach ($endemis as $key => $value) {
            Endemis::create($value);
        }
    }
}
