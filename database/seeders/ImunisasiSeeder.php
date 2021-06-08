<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Imunisasi;

class ImunisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imunisasis = [
            [
                'nama'=>'Imunisasi Meningitis',
                'manfaat'=>'Imunisasi yang diberikan untuk mencegah penyakit meningitis (radang selaput otak) yang disebabkan oleh bakteri Neisseria meningitidis. Diberikan jika bepergian ke daerah endemis penyakit. Tingkat kematian meningokokus mencapai 50% apabila tidak ditangani dengan tepat. Indonesia memiliki risiko importasi kasus Meningokokus yang cukup tinggi mengingat jumlah jamaah haji dan umroh serta tenaga kerja Indonesia (TKI) sangat besar.',
                'indikasi'=>'Kelompok usia 11–12 tahun yang diulang kembali dengan booster pada usia 16 tahun, pria atau wanita berusia 56 tahun atau lebih, orang-orang yang hendak bepergian ke wilayah endemis meningitis, orang dengan sistem kekebalan tubuh rendah, misalnya penderita HIV, petugas medis, khususnya yang sering berurusan dengan pasien meningitis.',
                'kontraindikasi'=>'Orang-orang yang mengalami reaksi alergi parah dan mengacam keselamatan jiwa, khususnya setelah diberikan vaksin meningitis atau jenis vaksin lainnya, orang yang sedang sakit, orang-orang dengan sindrom Guillain-Barre.',
                'dosis'=>'1 kali pemberian',
                'harga'=>'Berkisar di harga Rp800.000 untuk vaksin Meningitis Konjugat, Berkisar di harga Rp300.000 untuk vaksin Meningitis Polisakarida',
            ],
            [
                'nama'=>'Imunisasi Yellow Fever',
                'manfaat'=>'Imunisasi Yellow Fever memberikan kekebalan efektif bagi semua orang yang berasal dari negara atau akan melakukan perjalanan ke negara\/daerah endemis demam kuning. Penyakit ini merupakan salah satu penyakit menular yang berbahaya. Tingkat kematian penyakit ini berkisar 20-50%, namun pada kasus berat dapat melebihi 50%. Belum ditemukan pengobatan spesifik untuk penyakit ini.',
                'indikasi'=>'Imunisasi diindikasikan untuk mereka yang bepergian ke atau hidup di daerah infeksi endemik dan untuk staf laboratorium yang menangani virus atau yang menangani bahan klinis dari kasus yang dicurigai. Bayi di bawah usia 9 bulan hanya diimunisasi bila risiko demam kuning tak terelakkan.',
                'kontraindikasi'=>'Tidak boleh diberikan kepada mereka dengan gangguan respons kekebalan, atau mereka yang pernah mengalami reaksi anafilaksis terhadap telur; tidak boleh diberikan selama kehamilan (tetapi bila ada risiko paparan yang nyata, perlunya imunisasi melebihi risiko apapun pada janin).',
                'dosis'=>'1 kali pemberian jika pergi ke daerah endemis penyakit.',
                'harga'=>'Berkisar di Rp650.000',
            ],
            [
                'nama'=>'Imunisasi Rabies',
                'manfaat'=>'Imunisasi yang diberikan untuk mencegah penyakit anjing gila atau dikenal dengan nama rabies, yaitu suatu penyakit infeksi akut pada susunan saraf pusat yang disebabkan oleh virus rabies. Angka kematian akibat Rabies di Indonesia masih cukup tinggi yaitu 100-156 kematian per tahun, dengan Case Fatality Rate (Tingkat Kematian) hampir 100 persen. Hal ini menggambarkan bahwa rabies masih jadi ancaman bagi kesehatan masyarakat.',
                'indikasi'=>'Luka gigitan atau cakaran tunggal atau multipel oleh hewan yang dicurigai menderita rabies (hewan tidak pernah divaksin, tampak sakit, gigitan terjadi tanpa provokasi),terkena paparan air liur pada luka atau membran mukosa oleh hewan tersangka rabies atau kontak langsung dengan kelelawar.',
                'kontraindikasi'=>'Tidak ada kontraindikasi pemberian serum anti rabies pada pasien dengan luka gigitan berisiko, karena rabies lebih mengancam jiwa. Bila ada kontraindikasi penyuntikkan secara intramuskular, SAR boleh disuntikkan secara subkutan.',
                'dosis'=>'1 kali pemberian.',
                'harga'=>'Berkisar di Rp310.000',
            ],
            [
                'nama'=>'Imunisasi Pneumokokus (PCV) 1',
                'manfaat'=>'Imunisasi yang diberikan untuk mencegah penyakit meningitis, pneumonia, dan infeksi darah atau sepsis. Berdasarkan UNICEF, pada 2015 terdapat kurang lebih 14 persen dari 147.000 anak di bawah usia 5 tahun di Indonesia meninggal karena pneumonia. Dari statistik tersebut, dapat diartikan sebanyak 2-3 anak di bawah usia 5 tahun meninggal karena pneumonia setiap jamnya. Hal tersebut menempatkan pneumonia sebagai penyebab kematian utama bagi anak di bawah usia 5 tahun di Indonesia.',
                'indikasi'=>'Kelompok berisiko yaitu bayi yang tidak mendapat ASI, tinggal bersama perokok aktif, memiliki saudara yang dititipkan di TPA, memiliki gangguan imunitas (HIV, defisiensi immunoglobulin, keganasan), menderita penyakit jantung dan paru kronik, gagal ginjal kronik, gangguan hati, dan pasien transplantasi organ. Direkomendasikan untuk diberikan pada anak dan dewasa saat pandemi Covid-19.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi PCV sebelumnya.',
                'dosis'=>'2 dosis untuk usia 2 bulan & > 1 tahun, 3 dosis untuk usia 7-11 bulan',
                'harga'=>'Rp800.000 - Rp900.000',
            ],
            [
                'nama'=>'Imunisasi Pneumokokus (PCV) 2',
                'manfaat'=>'Imunisasi yang diberikan untuk mencegah penyakit meningitis, pneumonia, dan infeksi darah atau sepsis. Berdasarkan UNICEF, pada 2015 terdapat kurang lebih 14 persen dari 147.000 anak di bawah usia 5 tahun di Indonesia meninggal karena pneumonia. Dari statistik tersebut, dapat diartikan sebanyak 2-3 anak di bawah usia 5 tahun meninggal karena pneumonia setiap jamnya. Hal tersebut menempatkan pneumonia sebagai penyebab kematian utama bagi anak di bawah usia 5 tahun di Indonesia.',
                'indikasi'=>'Kelompok berisiko yaitu bayi yang tidak mendapat ASI, tinggal bersama perokok aktif, memiliki saudara yang dititipkan di TPA, memiliki gangguan imunitas (HIV, defisiensi immunoglobulin, keganasan), menderita penyakit jantung dan paru kronik, gagal ginjal kronik, gangguan hati, dan pasien transplantasi organ. Direkomendasikan untuk diberikan pada anak dan dewasa saat pandemi Covid-19.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi PCV sebelumnya.',
                'dosis'=>'2 dosis untuk usia 2 bulan & > 1 tahun, 3 dosis untuk usia 7-11 bulan',
                'harga'=>'Rp800.000 - Rp900.000',
            ],
            [
                'nama'=>'Imunisasi Pneumokokus (PCV) 3',
                'manfaat'=>'Imunisasi yang diberikan untuk mencegah penyakit meningitis, pneumonia, dan infeksi darah atau sepsis. Berdasarkan UNICEF, pada 2015 terdapat kurang lebih 14 persen dari 147.000 anak di bawah usia 5 tahun di Indonesia meninggal karena pneumonia. Dari statistik tersebut, dapat diartikan sebanyak 2-3 anak di bawah usia 5 tahun meninggal karena pneumonia setiap jamnya. Hal tersebut menempatkan pneumonia sebagai penyebab kematian utama bagi anak di bawah usia 5 tahun di Indonesia.',
                'indikasi'=>'Kelompok berisiko yaitu bayi yang tidak mendapat ASI, tinggal bersama perokok aktif, memiliki saudara yang dititipkan di TPA, memiliki gangguan imunitas (HIV, defisiensi immunoglobulin, keganasan), menderita penyakit jantung dan paru kronik, gagal ginjal kronik, gangguan hati, dan pasien transplantasi organ. Direkomendasikan untuk diberikan pada anak dan dewasa saat pandemi Covid-19.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi PCV sebelumnya.',
                'dosis'=>'2 dosis untuk usia 2 bulan & > 1 tahun, 3 dosis untuk usia 7-11 bulan',
                'harga'=>'Rp800.000 - Rp900.000',
            ],
            [
                'nama'=>'Imunisasi Varisela 1',
                'manfaat'=>'Imunisasi yang diberikan untuk mencegah penyakit cacar air. Penyakit yang sangat menular dengan angka serangan mendekati >85% setelah paparan, biasanya ringan pada anak-anak umur 1-12 tahun yang imunokompeten tetapi dapatmenjadi berat pada orang dewasa dan dapat mengancam jiwa pada pasien immunocompromised.',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi varisela dengan usia minimal 6 bulan, terpapar dengan penderita cacar dalam 72 jam dan belum pernah mendapat imunisasi cacar, penderita keganasan/kanker.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi varisela, demam tinggi, sedang sakit berat, kondisi dengan gangguan imunitas (HIV, imunodefisiensi, pengguna obat steroid jangka panjang/imunosupresif, mendapatkan kemoterapi atau radiasi), alergi terhadap obat neomisin atau obat yang mengandung gelatin.',
                'dosis'=>'2 dosis, interval minimal 1 bulan.',
                'harga'=>'Rp600.000 - Rp700.000',
            ],
            [
                'nama'=>'Imunisasi Varisela 2',
                'manfaat'=>'Imunisasi yang diberikan untuk mencegah penyakit cacar air. Penyakit yang sangat menular dengan angka serangan mendekati >85% setelah paparan, biasanya ringan pada anak-anak umur 1-12 tahun yang imunokompeten tetapi dapatmenjadi berat pada orang dewasa dan dapat mengancam jiwa pada pasien immunocompromised.',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi varisela dengan usia minimal 6 bulan, terpapar dengan penderita cacar dalam 72 jam dan belum pernah mendapat imunisasi cacar, penderita keganasan/kanker.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi varisela, demam tinggi, sedang sakit berat, kondisi dengan gangguan imunitas (HIV, imunodefisiensi, pengguna obat steroid jangka panjang/imunosupresif, mendapatkan kemoterapi atau radiasi), alergi terhadap obat neomisin atau obat yang mengandung gelatin.',
                'dosis'=>'2 dosis, interval minimal 1 bulan.',
                'harga'=>'Rp600.000 - Rp700.000',
            ],
            [
                'nama'=>'Imunisasi Tifoid Polisakarida',
                'manfaat'=>'Imunisasi yang diberikan untuk mencegah penyakit tifus. WHO memperkirakan 11–20 juta orang terserang tifus atau demam tifoid tiap tahunnya. Dari jumlah tersebut, 128.000 hingga 161.000 meninggal akibat penyakit ini.',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi tifoid dengan usia minimal 24 bulan.',
                'kontraindikasi'=>'Demam, penyakit akut dan kronik progresif, riwayat alergi pada pemberian imunisasi tifoid sebelumnya.',
                'dosis'=>'2 dosis',
                'harga'=>'Rp300.000 - Rp900.000',
            ],
            [
                'nama'=>'Imunisasi Tifoid Lanjutan',
                'manfaat'=>'Imunisasi yang diberikan untuk mencegah penyakit tifus. WHO memperkirakan 11–20 juta orang terserang tifus atau demam tifoid tiap tahunnya. Dari jumlah tersebut, 128.000 hingga 161.000 meninggal akibat penyakit ini.',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi tifoid dengan usia minimal 24 bulan.',
                'kontraindikasi'=>'Demam, penyakit akut dan kronik progresif, riwayat alergi pada pemberian imunisasi tifoid sebelumnya.',
                'dosis'=>'2 dosis',
                'harga'=>'Rp300.000 - Rp900.000',
            ],
            [
                'nama'=>'Imunisasi Hepatitis A 1',
                'manfaat'=>'Imunisasi yang diberikan untuk mengurangi risiko seseorang terinfeksi virus penyebab kerusakan hati. WHO memperkirakan sekitar 1,4 juta orang terinfeksi virus hepatitis A setiap tahun. Penyakit Hepatitis A terutama menyebar di negara-negara berkembang dengan kebersihan yang buruk.',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi hepatitis A atau yang tinggal di daerah endemis dengan usia minimal 2 tahun, penderita penyakit hati kronis, pasca paparan dengan penderita hepatitis A.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi hepatitis A, alergi terhadap neomisin atau obat yang mengandung gelatin (Avaxim).',
                'dosis'=>'2 dosis',
                'harga'=>'Rp500.000 - Rp600.000',
            ],
            [
                'nama'=>'Imunisasi Hepatitis A 2',
                'manfaat'=>'Imunisasi yang diberikan untuk mengurangi risiko seseorang terinfeksi virus penyebab kerusakan hati. WHO memperkirakan sekitar 1,4 juta orang terinfeksi virus hepatitis A setiap tahun. Penyakit Hepatitis A terutama menyebar di negara-negara berkembang dengan kebersihan yang buruk.',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi hepatitis A atau yang tinggal di daerah endemis dengan usia minimal 2 tahun, penderita penyakit hati kronis, pasca paparan dengan penderita hepatitis A.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi hepatitis A, alergi terhadap neomisin atau obat yang mengandung gelatin (Avaxim).',
                'dosis'=>'2 dosis',
                'harga'=>'Rp500.000 - Rp600.000',
            ],
            [
                'nama'=>'Imunisasi HPV 1',
                'manfaat'=>'Imunisasi yang diberikan untuk menghindari infeksi terhadap HPV yang memicu penyakit kanker serviks, kanker anus, kanker tenggorokan, dan kutil kelamin. Setidaknya telah tercatat adanya 200.000 kematian akibat kanker serviks di negara-negara berkembang. Sebanyak 46.000 kasus di antaranya, terjadi pada wanita berusia produktif, yaitu 15-49 tahun. Di Indonesia sendiri, ada 52 juta wanita yang berisiko mengalami kanker serviks.\r\nImunisasi HPV yang terbukti efektif memberikan perlindungan 70% terhadap virus HPV tipe 16 dan tipe 18.',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi HPV mulai usia 9 tahun dan belum/tidak terinfeksi HPV.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi HPV, ibu hamil (perhatian khusus).',
                'dosis'=>'2 dosis untuk anak usia 9-14 tahun, 3 dosis untuk anak usia > 15 tahun',
                'harga'=>'Rp900.000 - Rp1.200.000',
            ],
            [
                'nama'=>'Imunisasi HPV 2',
                'manfaat'=>'Imunisasi yang diberikan untuk menghindari infeksi terhadap HPV yang memicu penyakit kanker serviks, kanker anus, kanker tenggorokan, dan kutil kelamin. Setidaknya telah tercatat adanya 200.000 kematian akibat kanker serviks di negara-negara berkembang. Sebanyak 46.000 kasus di antaranya, terjadi pada wanita berusia produktif, yaitu 15-49 tahun. Di Indonesia sendiri, ada 52 juta wanita yang berisiko mengalami kanker serviks.\r\nImunisasi HPV yang terbukti efektif memberikan perlindungan 70% terhadap virus HPV tipe 16 dan tipe 18.',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi HPV mulai usia 9 tahun dan belum/tidak terinfeksi HPV.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi HPV, ibu hamil (perhatian khusus).',
                'dosis'=>'2 dosis untuk anak usia 9-14 tahun, 3 dosis untuk anak usia > 15 tahun',
                'harga'=>'Rp900.000 - Rp1.200.000',
            ],
            [
                'nama'=>'Imunisasi HPV 1 Bivalen',
                'manfaat'=>'Imunisasi yang diberikan untuk menghindari infeksi terhadap HPV yang memicu penyakit kanker serviks, kanker anus, kanker tenggorokan, dan kutil kelamin. Setidaknya telah tercatat adanya 200.000 kematian akibat kanker serviks di negara-negara berkembang. Sebanyak 46.000 kasus di antaranya, terjadi pada wanita berusia produktif, yaitu 15-49 tahun. Di Indonesia sendiri, ada 52 juta wanita yang berisiko mengalami kanker serviks.\r\nImunisasi HPV yang terbukti efektif memberikan perlindungan 70% terhadap virus HPV tipe 16 dan tipe 18.',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi HPV mulai usia 9 tahun dan belum/tidak terinfeksi HPV.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi HPV, ibu hamil (perhatian khusus).',
                'dosis'=>'2 dosis untuk anak usia 9-14 tahun, 3 dosis untuk anak usia > 15 tahun',
                'harga'=>'Rp900.000 - Rp1.200.000',
            ],
            [
                'nama'=>'Imunisasi HPV 2 Bivalen',
                'manfaat'=>'Imunisasi yang diberikan untuk menghindari infeksi terhadap HPV yang memicu penyakit kanker serviks, kanker anus, kanker tenggorokan, dan kutil kelamin. Setidaknya telah tercatat adanya 200.000 kematian akibat kanker serviks di negara-negara berkembang. Sebanyak 46.000 kasus di antaranya, terjadi pada wanita berusia produktif, yaitu 15-49 tahun. Di Indonesia sendiri, ada 52 juta wanita yang berisiko mengalami kanker serviks.\r\nImunisasi HPV yang terbukti efektif memberikan perlindungan 70% terhadap virus HPV tipe 16 dan tipe 18.',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi HPV mulai usia 9 tahun dan belum/tidak terinfeksi HPV.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi HPV, ibu hamil (perhatian khusus).',
                'dosis'=>'2 dosis untuk anak usia 9-14 tahun, 3 dosis untuk anak usia > 15 tahun',
                'harga'=>'Rp900.000 - Rp1.200.000',
            ],
            [
                'nama'=>'Imunisasi HPV 3 Bivalen',
                'manfaat'=>'Imunisasi yang diberikan untuk menghindari infeksi terhadap HPV yang memicu penyakit kanker serviks, kanker anus, kanker tenggorokan, dan kutil kelamin. Setidaknya telah tercatat adanya 200.000 kematian akibat kanker serviks di negara-negara berkembang. Sebanyak 46.000 kasus di antaranya, terjadi pada wanita berusia produktif, yaitu 15-49 tahun. Di Indonesia sendiri, ada 52 juta wanita yang berisiko mengalami kanker serviks.\r\nImunisasi HPV yang terbukti efektif memberikan perlindungan 70% terhadap virus HPV tipe 16 dan tipe 18.',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi HPV mulai usia 9 tahun dan belum/tidak terinfeksi HPV.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi HPV, ibu hamil (perhatian khusus).',
                'dosis'=>'2 dosis untuk anak usia 9-14 tahun, 3 dosis untuk anak usia > 15 tahun',
                'harga'=>'Rp900.000 - Rp1.200.000',
            ],
            [
                'nama'=>'Imunisasi HPV 1 Quadrivalen',
                'manfaat'=>'Imunisasi yang diberikan untuk menghindari infeksi terhadap HPV yang memicu penyakit kanker serviks, kanker anus, kanker tenggorokan, dan kutil kelamin. Setidaknya telah tercatat adanya 200.000 kematian akibat kanker serviks di negara-negara berkembang. Sebanyak 46.000 kasus di antaranya, terjadi pada wanita berusia produktif, yaitu 15-49 tahun. Di Indonesia sendiri, ada 52 juta wanita yang berisiko mengalami kanker serviks.\r\nImunisasi HPV yang terbukti efektif memberikan perlindungan 70% terhadap virus HPV tipe 16 dan tipe 18.',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi HPV mulai usia 9 tahun dan belum/tidak terinfeksi HPV.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi HPV, ibu hamil (perhatian khusus).',
                'dosis'=>'2 dosis untuk anak usia 9-14 tahun, 3 dosis untuk anak usia > 15 tahun',
                'harga'=>'Rp900.000 - Rp1.200.000',
            ],
            [
                'nama'=>'Imunisasi HPV 2 Quadrivalen',
                'manfaat'=>'Imunisasi yang diberikan untuk menghindari infeksi terhadap HPV yang memicu penyakit kanker serviks, kanker anus, kanker tenggorokan, dan kutil kelamin. Setidaknya telah tercatat adanya 200.000 kematian akibat kanker serviks di negara-negara berkembang. Sebanyak 46.000 kasus di antaranya, terjadi pada wanita berusia produktif, yaitu 15-49 tahun. Di Indonesia sendiri, ada 52 juta wanita yang berisiko mengalami kanker serviks.\r\nImunisasi HPV yang terbukti efektif memberikan perlindungan 70% terhadap virus HPV tipe 16 dan tipe 18.',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi HPV mulai usia 9 tahun dan belum/tidak terinfeksi HPV.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi HPV, ibu hamil (perhatian khusus).',
                'dosis'=>'2 dosis untuk anak usia 9-14 tahun, 3 dosis untuk anak usia > 15 tahun',
                'harga'=>'Rp900.000 - Rp1.200.000',
            ],
            [
                'nama'=>'Imunisasi HPV 3 Quadrivalen',
                'manfaat'=>'Imunisasi yang diberikan untuk menghindari infeksi terhadap HPV yang memicu penyakit kanker serviks, kanker anus, kanker tenggorokan, dan kutil kelamin. Setidaknya telah tercatat adanya 200.000 kematian akibat kanker serviks di negara-negara berkembang. Sebanyak 46.000 kasus di antaranya, terjadi pada wanita berusia produktif, yaitu 15-49 tahun. Di Indonesia sendiri, ada 52 juta wanita yang berisiko mengalami kanker serviks.\r\nImunisasi HPV yang terbukti efektif memberikan perlindungan 70% terhadap virus HPV tipe 16 dan tipe 18.',
                'indikasi'=>'Semua anak yang belum mendapat imunisasi HPV mulai usia 9 tahun dan belum/tidak terinfeksi HPV.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi HPV, ibu hamil (perhatian khusus).',
                'dosis'=>'2 dosis untuk anak usia 9-14 tahun, 3 dosis untuk anak usia > 15 tahun',
                'harga'=>'Rp900.000 - Rp1.200.000',
            ],
            [
                'nama'=>'Imunisasi Japanese Ensephalitis',
                'manfaat'=>'Imunisasi untuk mencegah infeksi virus Japanese Encephalitis yang bisa menyebabkan penyakit radang otak. Didapatkan 67.900 kasus JE setiap tahunnya, dengan angka kematian  20-30% dan mengakibatkan gejala gangguan saraf sisa pada 30-50%. Angka kematian ini lebih tinggi pada anak, terutama anak berusia kurang dari 10 tahun. Hingga saat ini masih belum ditemukan obat untuk mengatasi infeksi Japanese Ensephalitis.',
                'indikasi'=>'Semua anak yang belum mendapatkan imunisasi JE dengan usia minimal 12 bulan yang tinggal atau bepergian ke daerah endemis > 1 bulan.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi JE sebelumnya, sedang sakit berat, kondisi dengan gangguan imunitas (HIV, imunodefisiensi, pengguna obat steroid jangka panjang/imunosupresif, mendapatkan kemoterapi atau radiasi).',
                'dosis'=>'2 dosis',
                'harga'=>'Berkisar di harga Rp600.000',
            ],
            [
                'nama'=>'Imunisasi Japanese Ensephalitis 2',
                'manfaat'=>'Imunisasi untuk mencegah infeksi virus Japanese Encephalitis yang bisa menyebabkan penyakit radang otak. Didapatkan 67.900 kasus JE setiap tahunnya, dengan angka kematian  20-30% dan mengakibatkan gejala gangguan saraf sisa pada 30-50%. Angka kematian ini lebih tinggi pada anak, terutama anak berusia kurang dari 10 tahun. Hingga saat ini masih belum ditemukan obat untuk mengatasi infeksi Japanese Ensephalitis.',
                'indikasi'=>'Semua anak yang belum mendapatkan imunisasi JE dengan usia minimal 12 bulan yang tinggal atau bepergian ke daerah endemis > 1 bulan.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi JE sebelumnya, sedang sakit berat, kondisi dengan gangguan imunitas (HIV, imunodefisiensi, pengguna obat steroid jangka panjang/imunosupresif, mendapatkan kemoterapi atau radiasi).',
                'dosis'=>'2 dosis',
                'harga'=>'Berkisar di harga Rp600.000',
            ],
            [
                'nama'=>'Imunisasi Hepatitis B 1',
                'manfaat'=>'Vaksin diberikan untuk mencegah infeksi hati serius yang disebabkan oleh virus hepatitis B pada orang dewasa.Dibandingkan virus HIV, virus hepatitis B (HBV) seratus kali lebih ganas dan sepuluh kali lebih menular (infectious). Kebanyakan gejala hepatitis B tidak jelas terlihat. ',
                'indikasi'=>'Diberikan pada kelompok yang memiliki risiko tinggi seperti tenaga kesehatan, individu yang rutin menerima produk darah, individu yang memiliki perilaku seksual tidak aman, pengguna narkotika jarum suntik, individu yang akan berpergian ke daerah endemis hepatitis B, maupun kontak erat dengan pasien Hepatitis B.',
                'kontraindikasi'=>'Tidak diberikan pada pasien yang memiliki reaksi alergi berat, seperti anafilaksis, terhadap dosis sebelumnya, atau terhadap komponen vaksin. Karena vaksin hepatitis B rekombinan mengandung sel ragi, alergi terhadap ragi juga menjadi kontraindikasi.',
                'dosis'=>'3 dosis, bulan ke 0, 1, dan 6.',
                'harga'=>'Rp300.000 - Rp400.000',
            ],
            [
                'nama'=>'Imunisasi Hepatitis B 2',
                'manfaat'=>'Vaksin diberikan untuk mencegah infeksi hati serius yang disebabkan oleh virus hepatitis B pada orang dewasa.Dibandingkan virus HIV, virus hepatitis B (HBV) seratus kali lebih ganas dan sepuluh kali lebih menular (infectious). Kebanyakan gejala hepatitis B tidak jelas terlihat. ',
                'indikasi'=>'Diberikan pada kelompok yang memiliki risiko tinggi seperti tenaga kesehatan, individu yang rutin menerima produk darah, individu yang memiliki perilaku seksual tidak aman, pengguna narkotika jarum suntik, individu yang akan berpergian ke daerah endemis hepatitis B, maupun kontak erat dengan pasien Hepatitis B.',
                'kontraindikasi'=>'Tidak diberikan pada pasien yang memiliki reaksi alergi berat, seperti anafilaksis, terhadap dosis sebelumnya, atau terhadap komponen vaksin. Karena vaksin hepatitis B rekombinan mengandung sel ragi, alergi terhadap ragi juga menjadi kontraindikasi.',
                'dosis'=>'3 dosis, bulan ke 0, 1, dan 6.',
                'harga'=>'Rp300.000 - Rp400.000',
            ],
            [
                'nama'=>'Imunisasi Hepatitis B 3',
                'manfaat'=>'Vaksin diberikan untuk mencegah infeksi hati serius yang disebabkan oleh virus hepatitis B pada orang dewasa.Dibandingkan virus HIV, virus hepatitis B (HBV) seratus kali lebih ganas dan sepuluh kali lebih menular (infectious). Kebanyakan gejala hepatitis B tidak jelas terlihat. ',
                'indikasi'=>'Diberikan pada kelompok yang memiliki risiko tinggi seperti tenaga kesehatan, individu yang rutin menerima produk darah, individu yang memiliki perilaku seksual tidak aman, pengguna narkotika jarum suntik, individu yang akan berpergian ke daerah endemis hepatitis B, maupun kontak erat dengan pasien Hepatitis B.',
                'kontraindikasi'=>'Tidak diberikan pada pasien yang memiliki reaksi alergi berat, seperti anafilaksis, terhadap dosis sebelumnya, atau terhadap komponen vaksin. Karena vaksin hepatitis B rekombinan mengandung sel ragi, alergi terhadap ragi juga menjadi kontraindikasi.',
                'dosis'=>'3 dosis, bulan ke 0, 1, dan 6.',
                'harga'=>'Rp300.000 - Rp400.000',
            ],
            [
                'nama'=>'Imunisasi Demam Berdarah 1',
                'manfaat'=>'Imunisasi diberikan untuk mencegah infeksi dengue sehingga mampu mengurangi risiko seorang anak terkena infeksi dengue yang berat. Demam berdarah kerap kali melanda daerah beriklim tropis, seperti Indonesia. Tingginya kasus demam berdarah membuat banyak peneliti berusaha mengembangkan vaksin yang paling efektif untuk mencegah penyakit ini. Organisasi Kesehatan Dunia (WHO) melaporkan bahwa sekitar 20.000 orang meninggal setiap tahunnya karena demam berdarah.',
                'indikasi'=>'Semua anak usia 9-16 tahun yang belum mendapat imunisasi dengue yang tinggal di daerah rawan demam berdarah.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi dengue sebelumnya, kondisi dengan gangguan imunitas (HIV, imunodefisiensi, pengguna obat steroid jangka panjang/imunosupresif, mendapatkan kemoterapi atau radiasi), ibu hamil (perhatian khusus).',
                'dosis'=>'3 dosis, jarak masing-masing 6 bulan.',
                'harga'=>'Berkisar di Rp1.500.000',
            ],
            [
                'nama'=>'Imunisasi Demam Berdarah 2',
                'manfaat'=>'Imunisasi diberikan untuk mencegah infeksi dengue sehingga mampu mengurangi risiko seorang anak terkena infeksi dengue yang berat. Demam berdarah kerap kali melanda daerah beriklim tropis, seperti Indonesia. Tingginya kasus demam berdarah membuat banyak peneliti berusaha mengembangkan vaksin yang paling efektif untuk mencegah penyakit ini. Organisasi Kesehatan Dunia (WHO) melaporkan bahwa sekitar 20.000 orang meninggal setiap tahunnya karena demam berdarah.',
                'indikasi'=>'Semua anak  usia 9-16 tahun yang belum mendapat imunisasi dengue yang tinggal di daerah rawan demam berdarah.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi dengue sebelumnya, kondisi dengan gangguan imunitas (HIV, imunodefisiensi, pengguna obat steroid jangka panjang/imunosupresif, mendapatkan kemoterapi atau radiasi), ibu hamil (perhatian khusus).',
                'dosis'=>'3 dosis, jarak masing-masing 6 bulan.',
                'harga'=>'Berkisar di Rp1.500.000',
            ],
            [
                'nama'=>'Imunisasi Demam Berdarah 3',
                'manfaat'=>'Imunisasi diberikan untuk mencegah infeksi dengue sehingga mampu mengurangi risiko seorang anak terkena infeksi dengue yang berat. Demam berdarah kerap kali melanda daerah beriklim tropis, seperti Indonesia. Tingginya kasus demam berdarah membuat banyak peneliti berusaha mengembangkan vaksin yang paling efektif untuk mencegah penyakit ini. Organisasi Kesehatan Dunia (WHO) melaporkan bahwa sekitar 20.000 orang meninggal setiap tahunnya karena demam berdarah.',
                'indikasi'=>'Semua anak  usia 9-16 tahun yang belum mendapat imunisasi dengue yang tinggal di daerah rawan demam berdarah.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi dengue sebelumnya, kondisi dengan gangguan imunitas (HIV, imunodefisiensi, pengguna obat steroid jangka panjang/imunosupresif, mendapatkan kemoterapi atau radiasi), ibu hamil (perhatian khusus).',
                'dosis'=>'3 dosis, jarak masing-masing 6 bulan.',
                'harga'=>'Berkisar di Rp1.500.000',
            ],
            [
                'nama'=>'Imunisasi Influenza 1',
                'manfaat'=>'Vaksin influenza merupakan vaksin yang mampu melindungi dari penyakit flu. Meski biasanya hanya menimbulkan gejala ringan, flu juga bisa menyebabkan komplikasi serius. Menurut Badan Kesehatan Dunia (WHO), angka kejadian influenza yang berkomplikasi mencapai 5 juta kasus per tahun, dan angka kematian akibat penyakit ini mencapai 650.000 kasus di seluruh dunia.',
                'indikasi'=>'Semua anak yang belum diberikan imunisasi influenza usia > 6 bulan, anak dengan penyakit jantung kronik, saluran napas kronis seperti asma, diabetes, penyakit ginjal kronis, gangguan imunitas (HIV atau pengguna obat imunisupresif jangka panjang), anak yang tinggal di asrama.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi influenza sebelumnya, berhati-hati pada individu yang alergi terhadap telur, riwayat sakit lumpuh layu (penderita Guillain Barre Syndrome), demam akut yang berat.',
                'dosis'=>'2 dosis untuk anak usia 6 bulan-8 tahun, 1 dosis untuk anak usia >=9 tahun. Diulang setiap tahun.',
                'harga'=>'Rp300.000 - Rp450.000',
            ],
            [
                'nama'=>'Imunisasi Influenza 2',
                'manfaat'=>'Vaksin influenza merupakan vaksin yang mampu melindungi dari penyakit flu. Meski biasanya hanya menimbulkan gejala ringan, flu juga bisa menyebabkan komplikasi serius. Menurut Badan Kesehatan Dunia (WHO), angka kejadian influenza yang berkomplikasi mencapai 5 juta kasus per tahun, dan angka kematian akibat penyakit ini mencapai 650.000 kasus di seluruh dunia.',
                'indikasi'=>'Semua anak yang belum diberikan imunisasi influenza usia > 6 bulan, anak dengan penyakit jantung kronik, saluran napas kronis seperti asma, diabetes, penyakit ginjal kronis, gangguan imunitas (HIV atau pengguna obat imunisupresif jangka panjang), anak yang tinggal di asrama.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi influenza sebelumnya, berhati-hati pada individu yang alergi terhadap telur, riwayat sakit lumpuh layu (penderita Guillain Barre Syndrome), demam akut yang berat.',
                'dosis'=>'2 dosis untuk anak usia 6 bulan-8 tahun, 1 dosis untuk anak usia >=9 tahun. Diulang setiap tahun.',
                'harga'=>'Rp300.000 - Rp450.000',
            ],
            [
                'nama'=>'Imunisasi Rotavirus 1',
                'manfaat'=>'Vaksin rotavirus dapat melindungi anak dari diare akibat infeksi rotavirus. Penyakit tersebut bisa berbahaya karena berisiko tinggi menyebabkan anak terkena dehidrasi. Infeksi rotavius banyak ditemukan pada anak berusia 3–5 tahun dan merupakan penyebab utama diare dengan dehidrasi berat pada anak balita. WHO memperkirakan kematian akibat gastroenteritis rotavirus sejumlah 453.000 dengan laju mortalitas 86 kematian per 100.000 populasi pada anak di bawah 5 tahun. Angka ini menyumbang 5% dari seluruh penyebab kematian pada anak. ',
                'indikasi'=>'Semua bayi berusa 2-8 bulan yang belum diberikan imunisasi rotavirus.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi rotavirus.',
                'dosis'=>'3 dosis untuk bayi usia 2,4,6 bulan.',
                'harga'=>'Berkisar di harga Rp500.000',
            ],
            [
                'nama'=>'Imunisasi Rotavirus 2',
                'manfaat'=>'Vaksin rotavirus dapat melindungi anak dari diare akibat infeksi rotavirus. Penyakit tersebut bisa berbahaya karena berisiko tinggi menyebabkan anak terkena dehidrasi. Infeksi rotavius banyak ditemukan pada anak berusia 3–5 tahun dan merupakan penyebab utama diare dengan dehidrasi berat pada anak balita. WHO memperkirakan kematian akibat gastroenteritis rotavirus sejumlah 453.000 dengan laju mortalitas 86 kematian per 100.000 populasi pada anak di bawah 5 tahun. Angka ini menyumbang 5% dari seluruh penyebab kematian pada anak. ',
                'indikasi'=>'Semua bayi berusa 2-8 bulan yang belum diberikan imunisasi rotavirus.',
                'kontraindikasi'=>'Riwayat alergi berat pada pemberian imunisasi rotavirus.',
                'dosis'=>'3 dosis untuk bayi usia 2,4,6 bulan.',
                'harga'=>'Berkisar di harga Rp500.000',
            ],
        ];

        foreach ($imunisasis as $key => $value) {
            Imunisasi::create($value);
        }
    }
}