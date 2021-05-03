<template>
    <app-layout>
        <template #header>
            <h2 class="font-bold text-xl text-center text-gray-800 leading-tight">
                Imunisasi Selanjutnya
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 max-w-4xl mx-auto">
                        <div class="flex flex-col sm:flex-row justify-between">
                            <div class="my-1">
                                <p class="text-xs font-semibold">Nama</p>
                                <p>{{ baby.nama }}</p>
                            </div>
                            <div class="my-1">
                                <p class="text-xs font-semibold">Tanggal Lahir</p>
                                <p>{{ formatDate(baby.ttl) }}</p>
                            </div>
                            <div class="my-1">
                                <p class="text-xs font-semibold">Usia</p>
                                <p>{{ displayAge }}</p>
                            </div>
                        </div>
                        <div class="max-w-2xl mx-auto">
                            <table class="min-w-full leading-normal mt-10">
                                <thead>
                                    <tr>
                                        <th class="px-3 py-3">No</th>
                                        <th class="px-2 py-3">Jenis Imunisasi</th>
                                        <th class="px-2 py-3">Tanggal Penjadwalan</th>
                                        <th class="px-2 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y text-sm">
                                    <tr v-for="(riwayat, index) in scheduled" :key="riwayat.id">
                                        <td class="px-2 py-1 text-center">{{ index+1 }}</td>
                                        <td class="px-2 py-1">{{ riwayat.imunisasiwajib.jenis }}</td>
                                        <td class="px-2 py-1 text-center">{{ formatDate(riwayat.tgl_penjadwalan) }}</td>
                                        <td class="px-2 py-1 text-center"><inertia-link :href="route('detail', {id: riwayat.imunisasiwajib_id})" class="text-blue-800 underline">Lihat Lebih Lanjut</inertia-link></td>
                                    </tr>
                                </tbody>
                            </table>
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
        props: ['baby', 'riwayats'],
        computed: {
            displayAge() {
                if (!this.baby.ttl) {
                    return 'Masukkan tanggal lahir bayi terlebih dahulu'
                }

                const age = differenceInMonths(new Date(), new Date(this.baby.ttl))
                if (age < 0) {
                   return 'Tanggal lahir bayi yang dimasukkan salah' 
                }
            
                return age + ' Bulan'
            },
            scheduled() {
                return this.riwayats
                    .filter(riwayat => !!riwayat.tgl_penjadwalan)
                    .sort((a, b) => new Date(a.tgl_penjadwalan) - new Date(b.tgl_penjadwalan))
            },
        },
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