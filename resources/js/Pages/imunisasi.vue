<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight">
                Detail Imunisasi
            </h2>
        </template>
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mx-12 px-8 py-4">
                    <div class="mt-4">
                    </div>
                    <div class="mt-4">
                        <h3 class="font-semibold text-xl text-grey-500 leading-tight">
                        {{ data[0].nama }}
                        </h3>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center">
                        <i class="far fa-file-alt"></i>
                        <h2 class="font-semibold text-lg text-indigo-500 leading-tight">
                        Deskripsi
                        </h2>
                        </div>
                        <h1 class="mt-2 text-base">
                        {{ data[0].manfaat }}
                        </h1>
                        <div class="mt-2 text-base">
                            <span v-if="data[0].nama === 'Imunisasi Meningitis'">
                                <inertia-link class="text-green-500" :href="route('endemis')">
                                    <div class="mt-3 flex items-center text-sm font-semibold text-green-700">
                                        <div>Lihat Daftar Daerah Endemis Meningitis</div>
                                        <div class="ml-1 text-green-500">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                                </inertia-link>
                            </span>
                            <span v-else-if="data[0].nama === 'Imunisasi Japanese Ensephalitis'">
                                <inertia-link class="text-green-500" :href="route('endemis')">
                                    <div class="mt-3 flex items-center text-sm font-semibold text-green-700">
                                        <div>Lihat Daftar Daerah Endemis Japanese Ensephalitis</div>
                                        <div class="ml-1 text-green-500">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                                </inertia-link>
                                
                            </span>
                            <span v-else-if="data[0].nama === 'Imunisasi Yellow Fever'">
                                <inertia-link class="text-green-500" :href="route('endemis')">
                                    <div class="mt-3 flex items-center text-sm font-semibold text-green-700">
                                        <div>Lihat Daftar Daerah Endemis Yellow Fever</div>
                                        <div class="ml-1 text-green-500">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                                </inertia-link>
                            </span>
                            <span v-else-if="data[0].nama === 'Imunisasi Hepatitis A 1'">
                                <inertia-link class="text-green-500" :href="route('endemis')">
                                    <div class="mt-3 flex items-center text-sm font-semibold text-green-700">
                                        <div>Lihat Daftar Daerah Endemis Hepatitis A</div>
                                        <div class="ml-1 text-green-500">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                                </inertia-link>
                            </span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center">
                            <i class="fas fa-stethoscope"></i>
                            <h2 class="font-semibold text-lg text-indigo-500 leading-tight">
                            Indikasi
                            </h2>
                        </div>
                        <h1 class="mt-2 text-base">
                        {{ data[0].indikasi }}
                        </h1>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center">
                            <i class="fas fa-procedures"></i>
                            <h2 class="font-semibold text-lg text-indigo-500 leading-tight">
                            Kontra Indikasi
                            </h2>
                        </div>
                        <h1 class="mt-2 text-base">
                        {{ data[0].kontraindikasi }}
                        </h1>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center">
                            <i class="fas fa-syringe"></i>
                            <h2 class="font-semibold text-lg text-indigo-500 leading-tight">
                            Pemberian Imunisasi
                            </h2>
                        </div>
                        <h1 class="mt-2 text-base">
                        {{ data[0].dosis }}
                        </h1>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center">
                            <i class="fas fa-dollar-sign"></i>
                            <h2 class="font-semibold text-lg text-indigo-500 leading-tight">
                            Range Harga
                            </h2>
                        </div>
                        <h1 class="mt-2 text-base">
                        {{ data[0].harga }}
                        </h1>
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

        
    }
</script>