<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight">
                Jenis Imunisasi Khusus dan Pilihan
            </h2>
        </template>
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3">
                    <div class="bg-white text-center overflow-hidden shadow-xl rounded-lg mx-8 mt-8 px-8 py-4">
                        <div class="font-semibold text-lg text-grey-500 leading-tight">
                            <div class="flex justify-center mb-3">
                                <img :src="vaksin" width="100" />
                            </div>
                            <h1>Meningitis</h1>
                            <div class="mt-2 text-sm text-gray-500">
                                Imunisasi yang diberikan untuk mencegah penyakit meningitis (radang selaput otak) yang disebabkan oleh bakteri Neisseria meningitidis. Diberikan jika bepergian ke daerah endemis penyakit. 
                            </div>
                            <inertia-link :href="route('imunisasi' ,{ data:'Imunisasi Meningitis' })" method="get">
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
                            <h1>Yellow Fever</h1>
                            <div class="mt-2 text-sm text-gray-500">
                                Imunisasi Yellow Fever memberikan kekebalan efektif bagi semua orang yang berasal dari negara atau akan melakukan perjalanan ke negara/daerah endemis demam kuning.
                            </div>
                            <inertia-link :href="route('imunisasi' ,{ data:'Imunisasi Yellow Fever' })" method="get">
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
                            <h1>Rabies</h1>
                            <div class="mt-2 text-sm text-gray-500">
                                Imunisasi yang diberikan untuk mencegah penyakit anjing gila atau dikenal dengan nama rabies, yaitu suatu penyakit infeksi akut pada susunan saraf pusat yang disebabkan oleh virus rabies.
                            </div>
                            <inertia-link :href="route('imunisasi' ,{ data:'Imunisasi Rabies' })" method="get">
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
                            <h1>Pneumokokus (PCV)</h1>
                            <div class="mt-2 text-sm text-gray-500">
                                Imunisasi yang diberikan untuk mencegah penyakit pneumonia. 
                            </div>
                            <inertia-link :href="route('imunisasi' ,{ data:'Imunisasi Pneumokokus 1 (PCV 1)' })" method="get">
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
                            <h1>Varisela</h1>
                            <div class="mt-2 text-sm text-gray-500">
                                Imunisasi yang diberikan untuk mencegah penyakit cacar air.
                            </div>
                            <inertia-link :href="route('imunisasi' ,{ data:'Imunisasi Varisela 1' })" method="get">
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
                            <h1>Tifoid</h1>
                            <div class="mt-2 text-sm text-gray-500">
                                Imunisasi yang diberikan untuk mencegah penyakit tifus.
                            </div>
                            <inertia-link :href="route('imunisasi' ,{ data:'Imunisasi Tifoid Polisakarida' })" method="get">
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
                            <h1>Hepatitis A</h1>
                            <div class="mt-2 text-sm text-gray-500">
                                Imunisasi yang diberikan untuk mengurangi risiko seseorang terinfeksi virus penyebab kerusakan hati.
                            </div>
                            <inertia-link :href="route('imunisasi' ,{ data:'Imunisasi Hepatitis A 1' })" method="get">
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
                            <h1>Human Papillomavirus (HPV)</h1>
                            <div class="mt-2 text-sm text-gray-500">
                                Imunisasi yang diberikan untuk menghindari infeksi terhadap HPV yang memicu penyakit kanker serviks.
                            </div>
                            <inertia-link :href="route('imunisasi' ,{ data:'Imunisasi HPV 1' })" method="get">
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
                            <h1>Japanese Ensephalitis</h1>
                            <div class="mt-2 text-sm text-gray-500">
                                Imunisasi untuk mencegah infeksi virus Japanese Encephalitis yang bisa menyebabkan penyakit radang otak.
                            </div>
                            <inertia-link :href="route('imunisasi' ,{ data:'Imunisasi Japanese Ensephalitis' })" method="get">
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
                            <h1>Hepatitis B</h1>
                            <div class="mt-2 text-sm text-gray-500">
                                Vaksin diberikan untuk mencegah infeksi hati serius yang disebabkan oleh virus hepatitis B pada orang dewasa.
                            </div>
                            <inertia-link :href="route('imunisasi' ,{ data:'Imunisasi Hepatitis B 1' })" method="get">
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
                            <h1>Demam Berdarah</h1>
                            <div class="mt-2 text-sm text-gray-500">
                                Imunisasi diberikan untuk mencegah infeksi dengue sehingga mampu mengurangi risiko seorang anak terkena infeksi dengue yang berat.
                            </div>
                            <inertia-link :href="route('imunisasi' ,{ data:'Imunisasi Dengue 1' })" method="get">
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
                            <h1>Influenza</h1>
                            <div class="mt-2 text-sm text-gray-500">
                                Vaksin influenza merupakan vaksin yang mampu melindungi dari penyakit flu. Meski biasanya hanya menimbulkan gejala ringan, flu juga bisa menyebabkan komplikasi serius.
                            </div>
                            <inertia-link :href="route('imunisasi' ,{ data:'Imunisasi Influenza 1' })" method="get">
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
                            <h1>Rotavirus</h1>
                            <div class="mt-2 text-sm text-gray-500">
                                Vaksin rotavirus dapat melindungi anak dari diare akibat infeksi rotavirus. Penyakit tersebut bisa berbahaya karena berisiko tinggi menyebabkan anak terkena dehidrasi.
                            </div>
                            <inertia-link :href="route('imunisasi' ,{ data:'Imunisasi Rotavirus 1' })" method="get">
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
    import AppLayout from './../Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetCheckbox from "@/Jetstream/Checkbox";
    import JetButton from '@/Jetstream/Button'
    import vaksin from "./images/vaksin.jpg"


    export default {
        components: {
            AppLayout,
            Welcome,
            JetInput,
            JetLabel,
            JetCheckbox,
            JetButton,

        },
        props: ['data'],

        data: function () {
            return {
            vaksin: vaksin
            }
        }
    }
</script>