<template>
    <app-layout>
        <template #header>
            <h2 class="font-bold text-xl text-center text-gray-800 leading-tight">
                Detail Imunisasi
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 max-w-4xl mx-auto">
                        <h1 class="text-3xl font-bold">{{ imunisasiwajib.jenis }}</h1>
                        <p class="mt-3">{{ imunisasiwajib.deskripsi }}</p>
                        <p class="text-lg text-indigo-500 mt-3 font-bold">Cara Pemberian Dosis</p>
                        <p>{{ imunisasiwajib.cara_pemberian_dosis }}</p>
                        <p class="text-lg text-indigo-500 mt-3 font-bold">Indikasi</p>
                        <p>{{ imunisasiwajib.indikasi }}</p>
                        <p class="text-lg text-indigo-500 mt-3 font-bold">Indikasi Kontra</p>
                        <p>{{ imunisasiwajib.indikasi_kontra }}</p>
                        <p class="text-lg text-indigo-500 mt-3 font-bold">Efek Samping</p>
                        <p>{{ imunisasiwajib.efek_samping }}</p>
                        <p class="text-lg text-indigo-500 mt-3 font-bold">Penanganan Efek Samping</p>
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