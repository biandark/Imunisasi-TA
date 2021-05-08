<template>
    <app-layout>
        <template #header>
            <h2 class="font-bold text-xl text-center text-gray-800 leading-tight">
                Jadwal Imunisasi Selanjutnya
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 max-w-4xl mx-auto">
                        <h3 class="font-semibold mt-6 text-xl text-indigo-500 leading-tight">
                                Data Bayi
                        </h3>
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
                        <h3 class="font-semibold mt-6 text-xl text-indigo-500 leading-tight">
                                Rekomendasi Imunisasi
                        </h3>
                        <div class="max-w-4xl mx-auto">
                            <table class="min-w-full leading-normal">
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
                                        <td class="px-2 py-1 text-center"><inertia-link :href="route('detail', {id: riwayat.imunisasiwajib_id})" class="text-sm text-indigo-500 underline">Lihat Selengkapnya</inertia-link></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="flex m-4">
                                <inertia-link class="text-green-500" :href="route('riwayatwajib')">
                                    <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                        <div>Lihat Riwayat Imunisasi Wajib</div>
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