<template>
    <div>
        <div class="p-7 sm:px-10 grid grid-cols-1 md:grid-cols-2">
            <!-- banner -->
            <div class="mx-auto">
                <img :src="landing"/>
            </div>
            <div class="items-center ml-4">
                <h1 class="text-5xl justify-left font-semibold text-grey-500">Pastikan <br />Jadwal Imunisasi Tidak Terlewat dengan <br /> I-Mun </h1>
                <p class="my-6 text-base text-gray-600">Imunisasi memberi perlindungan terhadap  serangan penyakit <br /> serius bagi anak maupun dewasa, serta dapat mencegah <br /> persebarannya. Berikan imunisasi tepat pada waktunya <br /> untuk perlindungan yang maksimal dari penyakit. <br /> Melalui web ini Anda dapat mengetahui jadwal yang tepat untuk <br /> imunisasi wajib serta pilihan anak Anda.</p>
                <jet-button @click="gotoDasar()">Atur Jadwal Imunisasi Wajib</jet-button>    
                <jet-button class="ml-2" @click="gotoPilihan()">Atur Jadwal Imunisasi Pilihan</jet-button>  
            </div>
        </div>
        <h1 class="mt-5 text-3xl text-center font-semibold text-grey-500">Tentang Imunisasi Wajib dan Pilihan</h1>
        <div class="p-5 sm:px-20 grid grid-cols-1 md:grid-cols-2">
            <div>
                <div class="bg-white text-center overflow-hidden shadow-xl rounded-lg ml-4 px-8 py-4">
                    <div class="font-semibold text-lg text-grey-500 leading-tight">
                        <div class="flex justify-center mb-3">
                            <img :src="vaksin" width="100" />
                        </div>
                        <h1>Imunisasi Wajib</h1>
                        <div class="mt-2 text-justify text-sm text-gray-500">Imunisasi wajib terdiri dari imunisasi dasar dan lanjutan. Imunisasi dasar adalah pemberian imunisasai awal pada bayi yang baru lahir hingga berusia satu tahun untuk mencapai kadar kekebalan atas ambang perlindungan. Imunisasi lanjutan merupakan ulangan imunisasi dasar untuk mempertahankan tingkat kekebalan dan memperpanjang masa perlindungan anak yang sudah mendapatkan imunisasi dasar.</div>
                        <inertia-link :href="route('info')" method="get">
                                <div class="mt-3 flex justify-center items-center text-sm font-semibold text-indigo-700">
                                    <div>Lihat Jenis Imunisasi Wajib</div>
                                    <div class="ml-1 text-indigo-500">
                                        <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </div>
                        </inertia-link>
                    </div>
                </div>
            </div>
            <div>
                <div class="bg-white text-center overflow-hidden shadow-xl rounded-lg ml-4 px-8 py-4">
                        <div class="font-semibold text-lg text-grey-500 leading-tight">
                            <div class="flex justify-center mb-3">
                                <img :src="vaksin" width="100" />
                            </div>
                            <h1>Imunisasi Pilihan</h1>
                            <div class="mt-2 text-justify text-sm text-gray-500">Vaksin HB0 merupakan vaksin Hepatitis B yang diberikan pertama kali segera setelah lahir. Vaksin ini merupakan vaksin yang bertujuan untuk mencegah penularan peyakit infeksi atau kerusakan hati kronis yang disebabkan oleh virus Hepatitis B.</div>
                            <inertia-link :href="route('daftarimunisasi')" method="get">
                                    <div class="mt-3 flex justify-center items-center text-sm font-semibold text-indigo-700">
                                        <div>Lihat Jenis Imunisasi Pilihan</div>
                                        <div class="ml-1 text-indigo-500">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                            </inertia-link>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo'
    import landing from "/images/landing.jpg"
    import vaksin from "/images/vaksin.jpg"
    import JetButton from '@/Jetstream/Button'

    export default {
        components: {
            JetApplicationLogo,
            JetButton,
        },

        methods:{
            gotoForm(){
                this.$router.push('form'); 
            },
            gotoDasar(){
                this.$inertia.get(this.route('form'));
            },
            gotoPilihan(){
                this.$inertia.get(this.route('kondisi'));
            }
        },
        data: function () {
            return {
            landing: landing,
            vaksin: vaksin
            }
        }
    }
</script>
