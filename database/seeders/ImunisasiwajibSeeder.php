<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Imunisasiwajib;

class ImunisasiwajibSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imunisasiwajib = [
            [
               'jenis'=>'HB0',
               'deskripsi'=>'Vaksin HB0 merupakan vaksin Hepatitis B yang diberikan pertama kali segera setelah lahir. Vaksin ini merupakan vaksin yang bertujuan untuk mencegah penularan peyakit infeksi atau 
                            kerusakan hati kronis yang disebabkan oleh virus Hepatitis B.',
                'cara_pemberian_dosis'=>'Diberikan sebanyak 3 dosis, yaitu pada usia 0, 1, dan 6 bulan dengan interval atau jarak antar imunisasi minimum 4 minggu',
                'indikasi'=>'Semua bayi yang baru lahir, anak yang belum pernah mendapat imunisasi hepatitis B, 
                            pasien hemodialisis, individu yang memiliki keluarga dengan riwayat hepatitis B',
                'indikasi_kontra'=>'Penderita infeksi berat yang disertai kejang',
                'efek_samping'=>'Rasa sakit, kemerahan dan pembengkakan di sekitar tempat penyuntikan. Reaksi yang terjadi bersifat ringan
                                dan biasanya hilang setelah 2 hari',
                'penanganan_efek_samping'=>'Orang tua dianjurkan untuk memberikan lebih banyak ASI, jika demam kenakan pakaian yang tipis 
                                            dan berikan paracetamol, bekas suntikan yang nyeri dapat dikompres air dingin, jika demam berikan 
                                            paracetamol, bayi boleh mandi atau cukup diseka dengan air hangat',
            ],
            [
                'jenis'=>'Polio 0',
                'deskripsi'=>'Vaksin Polio 0 merupakan vaksin polio yang diberikan saat bayi lahir. Vaksin ini merupakan vaksin yang dapat mencegah penyakit polio yang dapat menyebabkan lumpuh layu pada tungkai
                            dan atau lengan',
                'cara_pemberian_dosis'=>'Dapat diberikan secara oral (OPV) dan suntikan (IPV), dari sebanyak 5 kali (dosis) dengan interval
                                        tiap dosis minimal 4 minggu',
                'indikasi'=>'Anak yang belum pernah mendapatkan imunisasi polio',
                'indikasi_kontra'=>'Kondisi dengan gangguan imunitas, sedang menderita demam, penyakit akut atau penyakit kronis progresif,
                                    Hipersensitif pada saat pemberian vaksin ini sebelumnya, penyakit demam akibat infeksi akut: tunggu sampai sembuh,
                                    alergi terhadap Streptomycin',
                'efek_samping'=>'Nyeri, kemerahan, indurasi, dan bengkak bisa terjadi dalam waktu 48 jam setelah penyuntikan dan bisa bertahan selama satu atau dua hari',
                'penanganan_efek_samping'=>'Orang tua dianjurkan untuk memberikan lebih banyak ASI, jika demam kenakan pakaian yang tipis 
                                            dan berikan paracetamol, bekas suntikan yang nyeri dapat dikompres air dingin, jika demam berikan 
                                            paracetamol, bayi boleh mandi atau cukup diseka dengan air hangat',
            ],
            [
                'jenis'=>'BCG',
                'deskripsi'=>'Vaksin ini merupakan vaksin yang dapat mencegah penularan penyakit TBC atau Tuberkulosis yang berat. Vaksin BCG dibuat dari bakteri Mycobacterium bovis yang sudah dilemahkan.',
                'cara_pemberian_dosis'=>'Diberikan sebanyak 1 kali dengan disuntikkan di daerah lengan atas antara 0-2 bulan, paling optimal saat usia 2 bulan',
                'indikasi'=>'Bayi berusia kurang dari 3 bulan yang belum mendapatkan imunisasi BCG, bayi dengan hasil tes tuberkulin 
                            negatif, bayi yang memiliki kontak erat dengan penderita TB',
                'indikasi_kontra'=>'Kondisi dengan gangguan imunitas, demam tinggi, infeksi kulit luas, riwayat infeksi HB, hamil',
                'efek_samping'=>'2–6 minggu setelah imunisasi BCG daerah bekas suntikan timbul bisul kecil (papula) yang semakin membesar 
                                dan dapat terjadi ulserasi dalam waktu 2–4 bulan, kemudian menyembuh perlahan dengan menimbulkan jaringan 
                                parut dengan diameter 2–10 mm',
                'penanganan_efek_samping'=>'Apabila ulkus mengeluarkan cairan perlu dikompres dengan cairan antiseptik, Apabila cairan bertambah 
                                        banyak atau koreng semakin membesar anjurkan orangtua membawa bayi ke ke tenaga kesehatan',
            ],
            [
                'jenis'=>'Polio 1',
                'deskripsi'=>'Vaksin Polio 1 merupakan vaksin polio yang dapat mencegah penyakit polio yang dapat menyebabkan lumpuh layu pada tungkai
                            dan atau lengan',
                'cara_pemberian_dosis'=>'Dapat diberikan secara oral (OPV) dan suntikan (IPV), dari sebanyak 5 kali (dosis) dengan interval
                                        tiap dosis minimal 4 minggu',
                'indikasi'=>'Anak yang belum pernah mendapatkan imunisasi polio',
                'indikasi_kontra'=>'Kondisi dengan gangguan imunitas, sedang menderita demam, penyakit akut atau penyakit kronis progresif,
                                    Hipersensitif pada saat pemberian vaksin ini sebelumnya, penyakit demam akibat infeksi akut: tunggu sampai sembuh,
                                    alergi terhadap Streptomycin',
                'efek_samping'=>'Nyeri, kemerahan, indurasi, dan bengkak bisa terjadi dalam waktu 48 jam setelah penyuntikan dan bisa bertahan selama satu atau dua hari',
                'penanganan_efek_samping'=>'Orang tua dianjurkan untuk memberikan lebih banyak ASI, jika demam kenakan pakaian yang tipis 
                                            dan berikan paracetamol, bekas suntikan yang nyeri dapat dikompres air dingin, jika demam berikan 
                                            paracetamol, bayi boleh mandi atau cukup diseka dengan air hangat',
            ],
            [
                'jenis'=>'DPT-HB-Hib 1',
                'deskripsi'=>'Vaksin DPT-HB-Hib 1 merupakan vaksin yang diberikan pertama kali (dosis pertama). Vaksin DPT-HB-Hib 1 merupakan vaksin yang diberikan pertama kali (dosis pertama). Vaksin ini merupakan vaksin yang dapat mencegah terhadap penyakit difteri, tetanus, pertusis (batuk rejan), hepatitis B, dan infeksi Haemophilus influenzae tipe b secara simultan',
                'cara_pemberian_dosis'=>'Diberikan sebanyak 3 kali sebagai imunisasi wajib (usia 2,4,6 bulan) serta 1 kali sebagai lanjutan atau booster (usia 18-24 bulan). Disuntikkan pada paha atas',
                'indikasi'=>'Semua anak yang belum diberi vaksin DPT-HB-Hib minimal usia 6 minggu, terpapar dengan individu terinfeksi difteri dan 
                            pertusis, terdapat luka terbuka yang kotor',
                'indikasi_kontra'=>'Kejang atau gejala kelainan otak pada bayi baru lahir atau kelainan saraf serius, riwayat alergi berat pada pemberian vaksin DPT',
                'efek_samping'=>'Reaksi lokal sementara, seperti bengkak, nyeri, dan kemerahan pada lokasi suntikan, disertai demam dapat timbul dalam sejumlah besar kasus. Kadang-kadang reaksi berat, seperti demam tinggi, 
                                irritabilitas (rewel), dan menangis dengan nada tinggi dapat terjadi dalam 24 jam setelah pemberian',
                'penanganan_efek_samping'=>'Orang tua dianjurkan untuk memberikan lebih banyak ASI, jika demam kenakan pakaian yang tipis 
                                            dan berikan paracetamol, bekas suntikan yang nyeri dapat dikompres air dingin, jika demam berikan 
                                            paracetamol, bayi boleh mandi atau cukup diseka dengan air hangat, jika reaksi memberat dan menetap bawa bayi ke dokter',
            ],
            [
                'jenis'=>'Polio 2',
                'deskripsi'=>'Vaksin Polio 2 merupakan vaksin polio yang dapat mencegah penyakit polio yang dapat menyebabkan lumpuh layu pada tungkai
                                dan atau lengan',
                'cara_pemberian_dosis'=>'Dapat diberikan secara oral (OPV) dan suntikan (IPV), dari sebanyak 5 kali (dosis) dengan interval tiap dosis minimal 4 minggu',
                'indikasi'=>'Anak yang belum pernah mendapatkan imunisasi polio',
                'indikasi_kontra'=>'Kondisi dengan gangguan imunitas, sedang menderita demam, penyakit akut atau penyakit kronis progresif,
                                    Hipersensitif pada saat pemberian vaksin ini sebelumnya, penyakit demam akibat infeksi akut: tunggu sampai sembuh,
                                    alergi terhadap Streptomycin',
                'efek_samping'=>'Nyeri, kemerahan, indurasi, dan bengkak bisa terjadi dalam waktu 48 jam setelah penyuntikan dan bisa bertahan selama satu atau dua hari',
                'penanganan_efek_samping'=>'Orang tua dianjurkan untuk memberikan lebih banyak ASI, jika demam kenakan pakaian yang tipis 
                                            dan berikan paracetamol, bekas suntikan yang nyeri dapat dikompres air dingin, jika demam berikan 
                                            paracetamol, bayi boleh mandi atau cukup diseka dengan air hangat',
            ],
            [
                'jenis'=>'DPT-HB-Hib 2',
                'deskripsi'=>'Vaksin DPT-HB-Hib 2 merupakan vaksin yang diberikan kedua kali setelah vaksin DPT-HB-Hib 1. Vaksin ini merupakan vaksin yang dapat mencegah terhadap penyakit difteri, tetanus, pertusis (batuk rejan), hepatitis B, dan infeksi Haemophilus influenzae tipe b secara simultan',
                'cara_pemberian_dosis'=>'Diberikan sebanyak 3 kali sebagai imunisasi wajib (usia 2,4,6 bulan) serta 1 kali sebagai lanjutan atau booster (usia 18-24 bulan). Disuntikkan pada paha atas',
                'indikasi'=>'Semua anak yang belum diberi vaksin DPT-HB-Hib minimal usia 6 minggu, terpapar dengan individu terinfeksi difteri dan 
                            pertusis, terdapat luka terbuka yang kotor',
                'indikasi_kontra'=>'Kejang atau gejala kelainan otak pada bayi baru lahir atau kelainan saraf serius, riwayat alergi berat pada pemberian vaksin DPT',
                'efek_samping'=>'Reaksi lokal sementara, seperti bengkak, nyeri, dan kemerahan pada lokasi suntikan, disertai demam dapat timbul dalam sejumlah besar kasus. Kadang-kadang reaksi berat, seperti demam tinggi, 
                                irritabilitas (rewel), dan menangis dengan nada tinggi dapat terjadi dalam 24 jam setelah pemberian',
                'penanganan_efek_samping'=>'Orang tua dianjurkan untuk memberikan lebih banyak ASI, jika demam kenakan pakaian yang tipis 
                                            dan berikan paracetamol, bekas suntikan yang nyeri dapat dikompres air dingin, jika demam berikan 
                                            paracetamol, bayi boleh mandi atau cukup diseka dengan air hangat, jika reaksi memberat dan menetap bawa bayi ke dokter',
            ],
            [
                'jenis'=>'Polio 3',
                'deskripsi'=>'Vaksin Polio 3 merupakan vaksin polio yang dapat mencegah penyakit polio yang dapat menyebabkan lumpuh layu pada tungkai
                dan atau lengan',
                'cara_pemberian_dosis'=>'Dapat diberikan secara oral (OPV) dan suntikan (IPV), dari sebanyak 5 kali (dosis) dengan interval tiap dosis minimal 4 minggu',
                'indikasi'=>'Anak yang belum pernah mendapatkan imunisasi polio',
                'indikasi_kontra'=>'Kondisi dengan gangguan imunitas, sedang menderita demam, penyakit akut atau penyakit kronis progresif,
                                    Hipersensitif pada saat pemberian vaksin ini sebelumnya, penyakit demam akibat infeksi akut: tunggu sampai sembuh,
                                    alergi terhadap Streptomycin',
                'efek_samping'=>'Nyeri, kemerahan, indurasi, dan bengkak bisa terjadi dalam waktu 48 jam setelah penyuntikan dan bisa bertahan selama satu atau dua hari',
                'penanganan_efek_samping'=>'Orang tua dianjurkan untuk memberikan lebih banyak ASI, jika demam kenakan pakaian yang tipis 
                                            dan berikan paracetamol, bekas suntikan yang nyeri dapat dikompres air dingin, jika demam berikan 
                                            paracetamol, bayi boleh mandi atau cukup diseka dengan air hangat',
            ],
            [
                'jenis'=>'DPT-HB-Hib 3',
                'deskripsi'=>'Vaksin DPT-HB-Hib 3 merupakan vaksin yang diberikan ketiga kali setelah vaksin DPT-HB-Hib 1 dan 2. Vaksin ini merupakan vaksin yang dapat mencegah terhadap penyakit difteri, tetanus, pertusis (batuk rejan), hepatitis B, dan infeksi Haemophilus influenzae tipe b secara simultan',
                'cara_pemberian_dosis'=>'Diberikan sebanyak 3 kali sebagai imunisasi wajib (usia 2,4,6 bulan) serta 1 kali sebagai lanjutan atau booster (usia 18-24 bulan). Disuntikkan pada paha atas',
                'indikasi'=>'Semua anak yang belum diberi vaksin DPT-HB-Hib minimal usia 6 minggu, terpapar dengan individu terinfeksi difteri dan 
                            pertusis, terdapat luka terbuka yang kotor',
                'indikasi_kontra'=>'Kejang atau gejala kelainan otak pada bayi baru lahir atau kelainan saraf serius, riwayat alergi berat pada pemberian vaksin DPT',
                'efek_samping'=>'Reaksi lokal sementara, seperti bengkak, nyeri, dan kemerahan pada lokasi suntikan, disertai demam dapat timbul dalam sejumlah besar kasus. Kadang-kadang reaksi berat, seperti demam tinggi, 
                                irritabilitas (rewel), dan menangis dengan nada tinggi dapat terjadi dalam 24 jam setelah pemberian',
                'penanganan_efek_samping'=>'Orang tua dianjurkan untuk memberikan lebih banyak ASI, jika demam kenakan pakaian yang tipis 
                                            dan berikan paracetamol, bekas suntikan yang nyeri dapat dikompres air dingin, jika demam berikan 
                                            paracetamol, bayi boleh mandi atau cukup diseka dengan air hangat, jika reaksi memberat dan menetap bawa bayi ke dokter',
            ],
            [
                'jenis'=>'Polio 4',
                'deskripsi'=>'Vaksin Polio 4 merupakan vaksin polio yang dapat mencegah penyakit polio yang dapat menyebabkan lumpuh layu pada tungkai
                dan atau lengan',
                'cara_pemberian_dosis'=>'Dapat diberikan secara oral (OPV) dan suntikan (IPV), dari sebanyak 5 kali (dosis) dengan interval tiap dosis minimal 4 minggu',
                'indikasi'=>'Anak yang belum pernah mendapatkan imunisasi polio',
                'indikasi_kontra'=>'Kondisi dengan gangguan imunitas, sedang menderita demam, penyakit akut atau penyakit kronis progresif,
                                    Hipersensitif pada saat pemberian vaksin ini sebelumnya, penyakit demam akibat infeksi akut: tunggu sampai sembuh,
                                    alergi terhadap Streptomycin',
                'efek_samping'=>'Nyeri, kemerahan, indurasi, dan bengkak bisa terjadi dalam waktu 48 jam setelah penyuntikan dan bisa bertahan selama satu atau dua hari',
                'penanganan_efek_samping'=>'Orang tua dianjurkan untuk memberikan lebih banyak ASI, jika demam kenakan pakaian yang tipis 
                                            dan berikan paracetamol, bekas suntikan yang nyeri dapat dikompres air dingin, jika demam berikan 
                                            paracetamol, bayi boleh mandi atau cukup diseka dengan air hangat',
            ],
            [
                'jenis'=>'MR',
                'deskripsi'=>'Vaksin ini merupakan vaksin yang diberikan untuk mencegah terjadinya penyakit yang disebabkan oleh virus campak
                            dan rubela',
                'cara_pemberian_dosis'=>'Diberikan pada sebanyak 1 kali dan 1 kali sebagai vaksin lanjutan (booster) dengan disuntik',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi MR dengan usia minimal 6 bulan, terpapar dengan penderita campak dalam 72 jam dan belum pernah mendapatkan imunisasi campak',
                'indikasi_kontra'=>'Riwayat alergi berat terhadap pemberian imunisasi MR, kondisi gangguan imunitas, alergi terhadap obat neomisin, individu yang diduga menderita gangguan respon imun karena leukemia, limfoma',
                'efek_samping'=>'Mengalami demam ringan dan kemerahan selama 3 hari yang dapat terjadi 8–12 hari setelah vaksinasi',
                'penanganan_efek_samping'=>'Orang tua dianjurkan untuk memberikan lebih banyak ASI, jika demam kenakan pakaian yang tipis 
                                            dan berikan paracetamol, bekas suntikan yang nyeri dapat dikompres air dingin, jika demam berikan 
                                            paracetamol, bayi boleh mandi atau cukup diseka dengan air hangat, jika reaksi memberat dan menetap bawa bayi ke dokter',
            ],
            [
                'jenis'=>'DPT-HB-Hib Lanjutan',
                'deskripsi'=>'Vaksin DPT-HB-Hib Lanjutan merupakan vaksin yang diberikan keempat kali setelah vaksin DPT-HB-Hib 1, 2, dan 3. Vaksin ini merupakan vaksin yang dapat mencegah terhadap penyakit difteri, tetanus, pertusis (batuk rejan), hepatitis B, dan infeksi Haemophilus influenzae tipe b secara simultan',
                'cara_pemberian_dosis'=>'Diberikan sebanyak 3 kali sebagai imunisasi wajib (usia 2,4,6 bulan) serta 1 kali sebagai lanjutan atau booster (usia 18-24 bulan). Disuntikkan pada paha atas',
                'indikasi'=>'Semua anak yang belum diberi vaksin DPT-HB-Hib minimal usia 6 minggu, terpapar dengan individu terinfeksi difteri dan 
                            pertusis, terdapat luka terbuka yang kotor',
                'indikasi_kontra'=>'Kejang atau gejala kelainan otak pada bayi baru lahir atau kelainan saraf serius, riwayat alergi berat pada pemberian vaksin DPT',
                'efek_samping'=>'Reaksi lokal sementara, seperti bengkak, nyeri, dan kemerahan pada lokasi suntikan, disertai demam dapat timbul dalam sejumlah besar kasus. Kadang-kadang reaksi berat, seperti demam tinggi, 
                                irritabilitas (rewel), dan menangis dengan nada tinggi dapat terjadi dalam 24 jam setelah pemberian',
                'penanganan_efek_samping'=>'Orang tua dianjurkan untuk memberikan lebih banyak ASI, jika demam kenakan pakaian yang tipis 
                                            dan berikan paracetamol, bekas suntikan yang nyeri dapat dikompres air dingin, jika demam berikan 
                                            paracetamol, bayi boleh mandi atau cukup diseka dengan air hangat, jika reaksi memberat dan menetap bawa bayi ke dokter',
            ],
            [
                'jenis'=>'MR Lanjutan',
                'deskripsi'=>'Vaksin ini merupakan vaksin yang diberikan untuk mencegah terjadinya penyakit yang disebabkan oleh virus campak
                            dan rubela',
                'cara_pemberian_dosis'=>'Diberikan pada sebanyak 1 kali dan 1 kali sebagai vaksin lanjutan (booster) dengan disuntik',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi MR dengan usia minimal 6 bulan, terpapar dengan penderita campak dalam 72 jam dan belum pernah mendapatkan imunisasi campak',
                'indikasi_kontra'=>'Riwayat alergi berat terhadap pemberian imunisasi MR, kondisi gangguan imunitas, alergi terhadap obat neomisin, individu yang diduga menderita gangguan respon imun karena leukemia, limfoma',
                'efek_samping'=>'Mengalami demam ringan dan kemerahan selama 3 hari yang dapat terjadi 8–12 hari setelah vaksinasi',
                'penanganan_efek_samping'=>'Orang tua dianjurkan untuk memberikan lebih banyak ASI, jika demam kenakan pakaian yang tipis 
                                            dan berikan paracetamol, bekas suntikan yang nyeri dapat dikompres air dingin, jika demam berikan 
                                            paracetamol, bayi boleh mandi atau cukup diseka dengan air hangat, jika reaksi memberat dan menetap bawa bayi ke dokter',
            ],
        ];

        foreach ($imunisasiwajib as $key => $value) {
            Imunisasiwajib::create($value);
        }
    }
}