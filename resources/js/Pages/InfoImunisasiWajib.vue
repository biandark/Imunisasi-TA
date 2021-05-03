<template>
    <app-layout>
        <template #header>
            <h2 class="font-bold text-xl text-center text-gray-800 leading-tight">
                Jenis Imunisasi Dasar dan Pilihan
            </h2>
        </template>
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="bg-white text-center overflow-hidden shadow-xl rounded-lg mx-8 mt-8 px-8 py-4">
                        <div class="font-semibold text-lg text-grey-500 leading-tight">
                            <div class="flex justify-center mb-3">
                                    <img :src="vaksin" width="100" />
                            </div>
                            <h1>HB0</h1>
                            <div class="mt-2 text-sm text-gray-500">Vaksin HB0 merupakan vaksin Hepatitis B yang diberikan pertama kali segera setelah lahir. Vaksin ini merupakan vaksin yang bertujuan untuk mencegah penularan peyakit infeksi atau kerusakan hati kronis yang disebabkan oleh virus Hepatitis B.</div>
                            <inertia-link :href="route('detail', {id: 1})" method="get">
                                    <div class="mt-3 flex justify-center items-center text-sm font-semibold text-indigo-700">
                                        <div>Lihat Selengkapnya</div>
                                        <div class="ml-1 text-indigo-500">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                            </inertia-link>
                        </div>
                    </div>
                    <div class="bg-white text-center overflow-hidden shadow-xl rounded-lg mx-8 mt-8 px-8 py-4">
                        <div class="font-semibold text-lg text-grey-500 leading-tight">
                            <div class="flex justify-center mb-3">
                                    <img :src="vaksin" width="100" />
                            </div>
                            <h1>BCG</h1>
                            <div class="mt-2 text-sm text-gray-500">Vaksin ini merupakan vaksin yang dapat mencegah penularan penyakit TBC atau Tuberkulosis yang berat. Vaksin BCG dibuat dari bakteri Mycobacterium bovis yang sudah dilemahkan.</div>
                            <inertia-link :href="route('detail', {id: 2})" method="get">
                                    <div class="mt-3 flex justify-center items-center text-sm font-semibold text-indigo-700">
                                        <div>Lihat Selengkapnya</div>
                                        <div class="ml-1 text-indigo-500">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                            </inertia-link>
                        </div>
                    </div>
                    <div class="bg-white text-center overflow-hidden shadow-xl rounded-lg mx-8 mt-8 px-8 py-4">
                        <div class="font-semibold text-lg text-grey-500 leading-tight">
                            <div class="flex justify-center mb-3">
                                    <img :src="vaksin" width="100" />
                            </div>
                            <h1>Polio</h1>
                            <div class="mt-2 text-sm text-gray-500">Vaksin polio merupakan vaksin yang dapat mencegah penyakit polio yang dapat menyebabkan lumpuh layu pada tungkai
                            dan atau lengan</div>
                            <inertia-link :href="route('detail', {id: 3})" method="get">
                                    <div class="mt-3 flex justify-center items-center text-sm font-semibold text-indigo-700">
                                        <div>Lihat Selengkapnya</div>
                                        <div class="ml-1 text-indigo-500">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                            </inertia-link>
                        </div>
                    </div>
                    <div class="bg-white text-center overflow-hidden shadow-xl rounded-lg mx-8 mt-8 px-8 py-4">
                        <div class="font-semibold text-lg text-grey-500 leading-tight">
                            <div class="flex justify-center mb-3">
                                    <img :src="vaksin" width="100" />
                            </div>
                            <h1>DPT-HB-Hib</h1>
                            <div class="mt-2 text-sm text-gray-500">Vaksin ini merupakan vaksin yang dapat mencegah terhadap penyakit difteri, tetanus, pertusis (batuk rejan), hepatitis B, dan infeksi Haemophilus influenzae tipe b secara simultan</div>
                            <inertia-link :href="route('detail', {id: 4})" method="get">
                                    <div class="mt-3 flex justify-center items-center text-sm font-semibold text-indigo-700">
                                        <div>Lihat Selengkapnya</div>
                                        <div class="ml-1 text-indigo-500">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                            </inertia-link>
                        </div>
                    </div>
                    <div class="bg-white text-center overflow-hidden shadow-xl rounded-lg mx-8 mt-8 px-8 py-4">
                        <div class="font-semibold text-lg text-grey-500 leading-tight">
                            <div class="flex justify-center mb-3">
                                    <img :src="vaksin" width="100" />
                            </div>
                            <h1>MR</h1>
                            <div class="mt-2 text-sm text-gray-500">Vaksin ini merupakan vaksin yang diberikan untuk mencegah terjadinya penyakit yang disebabkan oleh virus campak
                            dan rubela</div>
                            <inertia-link :href="route('detail', {id: 10})" method="get">
                                    <div class="mt-3 flex justify-center items-center text-sm font-semibold text-indigo-700">
                                        <div>Lihat Selengkapnya</div>
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
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import JetButton from '@/Jetstream/Button'
    import { format, differenceInMonths } from 'date-fns'
    import { id } from 'date-fns/locale'

    export default {
        components: {
            AppLayout,
            Welcome,
            JetButton,
        },
        props: ['imunisasiwajibs'],
        methods: {
            formatDate(date) {
                const tgl = new Date(date)
                return format(tgl, "d MMMM yyyy", {
                        locale: id
                    })
            } 
        },
    }
</script>