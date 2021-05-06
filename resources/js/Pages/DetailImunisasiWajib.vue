<template>
    <app-layout>
        <template #header>
            <h2 class="font-bold text-xl text-center text-gray-800 leading-tight">
                Detail Imunisasi
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 max-w-5xl mx-auto">
                        <h3 class="font-semibold text-xl text-grey-500 leading-tight">Imunisasi {{ imunisasiwajib.jenis }}</h3>
                        <p class="mt-4">{{ imunisasiwajib.deskripsi }}</p>
                        <p class="mt-4 font-semibold text-lg text-indigo-500 leading-tight">
                            <i class="fas fa-syringe"></i>
                            Cara Pemberian Dosis
                        </p>
                        <p>{{ imunisasiwajib.cara_pemberian_dosis }}</p>
                        <p class="mt-4 font-semibold text-lg text-indigo-500 leading-tight">
                            <i class="fas fa-stethoscope"></i>
                            Indikasi
                        </p>
                        <p>{{ imunisasiwajib.indikasi }}</p>
                        <p class="mt-4 font-semibold text-lg text-indigo-500 leading-tight"> 
                            <i class="fas fa-procedures"></i> 
                            Indikasi Kontra
                        </p>
                        <p>{{ imunisasiwajib.indikasi_kontra }}</p>
                        <p class="mt-4 font-semibold text-lg text-indigo-500 leading-tight">
                            <i class="fas fa-diagnoses"></i> 
                            Efek Samping
                        </p>
                        <p>{{ imunisasiwajib.efek_samping }}</p>
                        <p class="mt-4 font-semibold text-lg text-indigo-500 leading-tight">
                            <i class="fas fa-medkit"></i> 
                            Penanganan Efek Samping
                        </p>
                        <p>{{ imunisasiwajib.penanganan_efek_samping }}</p>

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
        props: ['imunisasiwajib'],
    }
</script>