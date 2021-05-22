<template>
    <!--<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <inertia-link v-if="$page.props.user" href="/dashboard" class="text-sm text-gray-700 underline">
                Dashboard
            </inertia-link>

            <template v-else>
                <inertia-link :href="route('login')" class="text-sm text-gray-700 underline">
                    Log in
                </inertia-link>

                <inertia-link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Register
                </inertia-link>
            </template>
        </div>
    </div> -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div>
                        <div class="p-7 sm:px-10 grid grid-cols-1 md:grid-cols-2">
                            <!-- banner -->
                            <div class="mx-auto">
                                <img :src="landing"/>
                            </div>
                            <div class="items-center ml-4">
                                <h1 class="text-5xl justify-left font-semibold text-grey-500">Pastikan <br />Jadwal Imunisasi Tidak Terlewat dengan <br /> I-Mun </h1>
                                <p class="mt-6 mb-3 text-base text-gray-600">Imunisasi memberi perlindungan terhadap  serangan penyakit <br /> serius bagi anak maupun dewasa, serta dapat mencegah <br /> persebarannya. Berikan imunisasi tepat pada waktunya <br /> untuk perlindungan yang maksimal dari penyakit. <br /> Melalui web ini Anda dapat mengetahui jadwal yang tepat untuk <br /> imunisasi wajib serta pilihan anak Anda.</p>
                                <jet-button class="mb-2" @click="login()">Masuk</jet-button> <br />
                                Belum punya akun?  
                                <inertia-link v-if="canRegister" :href="route('register')" class="text-sm text-gray-700 underline">
                                    Daftar
                                </inertia-link>
                            </div>
                        </div>
                        <!-- about -->
                        <h1 class="mt-16 text-3xl text-center font-semibold text-grey-500">Tentang Imunisasi Wajib dan Pilihan</h1>
                        <div class="p-5 sm:px-20 grid grid-cols-1 md:grid-cols-2">
                            <div>
                                <div class="bg-white text-center overflow-hidden shadow-xl rounded-lg ml-4 px-8 py-4">
                                    <div class="font-semibold text-lg text-grey-500 leading-tight">
                                        <div class="flex justify-center mb-3">
                                            <img :src="vaksin" width="100" />
                                        </div>
                                        <h1>Imunisasi Wajib</h1>
                                        <div class="mt-2 text-justify text-sm text-gray-500">Imunisasi wajib terdiri dari imunisasi dasar dan lanjutan. Imunisasi dasar adalah pemberian imunisasai awal pada bayi yang baru lahir hingga berusia satu tahun untuk mencapai kadar kekebalan atas ambang perlindungan. Imunisasi lanjutan merupakan ulangan imunisasi dasar untuk mempertahankan tingkat kekebalan dan memperpanjang masa perlindungan anak yang sudah mendapatkan imunisasi dasar.</div>
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
                                            <div class="mt-2 text-justify text-sm text-gray-500">Imunisasi pilihan adalah imunisasi lain yang tidak termasuk dalam imunisasi yang diwajibkan oleh pemerintah, namun penting diberikan pada bayi, anak, dan dewasa di Indonesia mengingat beban penyakit dari masing-masing penyakit. Menurut Ikatan Dokter Anak Indonesia (IDAI), penamaan imunisasi wajib dan tidak dikarenakan pemerintah baru mampu menyediakan subsidi untuk sebagian vaksin-vaksin tersebut.</div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!-- step -->
                        <h1 class="mt-16 text-3xl text-center font-semibold text-grey-500">Bagaimana Saya Mendapat Pengingat Jadwal Imunisasi?</h1>
                        <div class="p-6 mt-4 mb-6 flex sm:px-20 grid grid-cols-1 md:grid-cols-4">
                            <div class="bg-white text-center overflow-hidden shadow-xl rounded-lg mx-4 px-2 py-4">
                                <div class="font-semibold text-lg text-grey-500 leading-tight">
                                    <div class="flex justify-center mb-3">
                                        <img :src="step1" width="100" />
                                    </div>
                                    <h1>1.<br />Login atau Registrasi Akun</h1>
                                    <div class="mt-4 text-sm text-gray-500">
                                        Pemilik akun merupakan wali dari anak (ibu, ayah, atau caregiver)
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white text-center overflow-hidden shadow-xl rounded-lg mx-4 px-2 py-4">
                                <div class="font-semibold text-lg text-grey-500 leading-tight">
                                    <div class="flex justify-center mb-3">
                                        <img :src="step2" width="100" />
                                    </div>
                                    <h1>2.<br />Buat Jadwal Imunisasi Baru</h1>
                                    <div class="mt-4 text-sm text-gray-500">
                                        Tersedia opsi untuk membuat jadwal imunisasi wajib atau pilihan
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white text-center overflow-hidden shadow-xl rounded-lg mx-4 px-2 py-4">
                                <div class="font-semibold text-lg text-grey-500 leading-tight">
                                    <div class="flex justify-center mb-3">
                                        <img :src="step3" width="100" />
                                    </div>
                                    <h1>3.<br />Pengingat Dikirimkan Melalui WhatsApp</h1>
                                    <div class="mt-4 text-sm text-gray-500">
                                        Sistem mengirim pengingat jadwal imunisasi menggunakan aplikasi WhatsApp
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white text-center overflow-hidden shadow-xl rounded-lg mx-4 px-2 py-4">
                                <div class="font-semibold text-lg text-grey-500 leading-tight">
                                    <div class="flex justify-center mb-3">
                                        <img :src="step4" width="100" />
                                    </div>
                                    <h1>4.<br />Lihat Riwayat Imunisasi yang Diberikan</h1>
                                    <div class="mt-4 text-sm text-gray-500">
                                        Lihat riwayat serta update data pemberian imunisasi
                                    </div>
                                </div>
                            </div>
                        </div>    
                </div>
            </div>
        </div>
    </div>
    
</template>

<style scoped>
    .bg-gray-100 {
        background-color: #f7fafc;
        background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
    }

    .border-gray-200 {
        border-color: #edf2f7;
        border-color: rgba(237, 242, 247, var(--tw-border-opacity));
    }

    .text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }

    .text-gray-500 {
        color: #a0aec0;
        color: rgba(160, 174, 192, var(--tw-text-opacity));
    }

    .text-gray-600 {
        color: #718096;
        color: rgba(113, 128, 150, var(--tw-text-opacity));
    }

    .text-gray-700 {
        color: #4a5568;
        color: rgba(74, 85, 104, var(--tw-text-opacity));
    }

    .text-gray-900 {
        color: #1a202c;
        color: rgba(26, 32, 44, var(--tw-text-opacity));
    }

    @media (prefers-color-scheme: dark) {
        .dark\:bg-gray-800 {
            background-color: #2d3748;
            background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
        }

        .dark\:bg-gray-900 {
            background-color: #1a202c;
            background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
        }

        .dark\:border-gray-700 {
            border-color: #4a5568;
            border-color: rgba(74, 85, 104, var(--tw-border-opacity));
        }

        .dark\:text-white {
            color: #fff;
            color: rgba(255, 255, 255, var(--tw-text-opacity));
        }

        .dark\:text-gray-400 {
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--tw-text-opacity));
        }
    }
</style>

<script>
    import landing from "/images/landing.jpg"
    import vaksin from "/images/vaksin.jpg"
    import step1 from "/images/1.png"
    import step2 from "/images/2.png"
    import step3 from "/images/3.png"
    import step4 from "/images/4.png"
    import JetButton from '@/Jetstream/Button'

    export default {
        components: {
            JetButton,
        },
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
        },
        methods:{
            gotoDasar(){
                // this.$inertia.get(this.route('form'));
            },
            gotoPilihan(){
                this.$inertia.get(this.route('kondisi'));
            },
            login(){
                this.$inertia.get(this.route('login'));
            }
        },
        data: function () {
            return {
            landing: landing,
            vaksin: vaksin,
            step1: step1,
            step2: step2,
            step3: step3,
            step4: step4
            }
        }
    }
</script>
