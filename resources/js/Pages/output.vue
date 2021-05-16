<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight">
                Jadwal Imunisasi Baru
            </h2>
        </template>
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-8 py-4">
                <div class="grid grid-flow-row grid-cols-1 md:grid-cols-2">
                    <div class="mx-auto"> 
                        <div class="mt-4">
                            <div>
                                <img :src="image" width="350" />
                            </div>
                        </div>
                    </div>
                    <div class="py-9 px-0 mt-4"> 
                    <h3 class="font-semibold text-xl text-indigo-500 leading-tight">
                    Data Pasien
                    </h3>
                    <div class="mt-4 overflow-x-auto">
                    <element class="prose">
                        <table>
                        <thead>
                        <tr>
                            <th >Tanggal Lahir</th>
                            <th >Gender</th>
                            <th >Travelling</th>
                            <th >Kondisi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td >{{ formatDate(data[0].tgl_lahir) }}</td>
                            <td >{{ data[0].gender }}</td>
                            <td >{{ data[0].travelling }}</td>
                            <td >{{ data[0].kondisi.slice(2,-2) }}</td>
                        </tr>
                        </tbody>
                        </table>
                    </element>
                    </div>
                    <div class="mt-8">
                    <h3 class="font-semibold text-xl text-indigo-500 leading-tight">
                    Rekomendasi Imunisasi
                    </h3>
                    <div class="mt-4 overflow-x-auto">
                    <element class="prose">
                        <table>
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Jenis Imunisasi</th>
                            <th>Tanggal Pemberian</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(data, index) in data" :key="data.id">
                            <td>{{ index+1 }}</td>
                            <td>{{ data.nama }}</td>
                            <td>{{ formatDate(data.tgl_rekom) }}</td>
                            <td>
                                <inertia-link class="text-sm text-indigo-500 underline" :href="route('imunisasi' ,{ data:data.nama})" method="get">
                                Lihat Selengkapnya
                                </inertia-link>
                            </td>
                        </tr>
                        </tbody>
                        </table>
                        </element>
                    </div>
                    </div>
                    <div class="flex mt-4">
                        <inertia-link class="text-green-500" :href="route('riwayat')">
                            <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                <div>Lihat Riwayat Imunisasi</div>
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
    import AppLayout from './../Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetCheckbox from "@/Jetstream/Checkbox";
    import JetButton from '@/Jetstream/Button'
    import image from "/images/vacc.jpg"
    import { format, differenceInYears, differenceInMonths } from 'date-fns'
    import { id } from 'date-fns/locale'


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
        computed: {
            displayAge() {
                if (this.data[0].usia >= 12) {
                    const age = differenceInYears(new Date(), new Date(this.data[0].tgl_lahir))
                    return age + ' Tahun'
                }
                else {
                    const agebulan = differenceInMonths(new Date(), new Date(this.data[0].tgl_lahir))
                    return agebulan + ' Bulan'
                }
                
            },
        },
        methods: {
            formatDate(date) {
                const tgl = new Date(date)
                return format(tgl, "d MMMM yyyy", {
                        locale: id
                    })
            }, 
        },

        data: function () {
            return {
            image: image
            }
        }

      }
      
</script>