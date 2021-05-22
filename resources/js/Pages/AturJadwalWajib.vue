<template>
    <app-layout>
        <template #header>
            <h2 class="font-bold text-xl text-center text-gray-800 leading-tight">
                Tambah Jadwal Pengingat Imunisasi Wajib
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6 mt-4">
                            <div class="flex items-center"> 
                                <i class="far fa-user"></i>
                                <h3 class="font-semibold text-xl text-indigo-500 leading-tight">
                                Data Bayi
                                </h3>
                            </div>
                            <div class="mt-4">
                                <jet-label for="nama" value="Nama Bayi*" />
                                <jet-input id="nama" type="text" class="mt-1 block w-full" v-model="form.nama" required disabled />
                            </div>
                            <div class="mt-4">
                                <jet-label for="ttl" value="Tanggal Lahir Bayi*" />
                                <jet-input id="ttl" type="date" class="mt-1 block w-full" v-model="form.ttl" required disabled />
                            </div>
                            <div  class="mt-4">
                                <jet-label for="usia" value="Usia Bayi*" />
                                <div class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full">{{ displayAge }}</div>
                            </div>
                            <div class="mt-4">
                                <jet-label for="bb" value="Apakah berat badan bayi Anda lebih dari 2 kg?*" />
                                <select required v-model="form.bb" placeholder="Ya/Tidak" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" disabled>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="p-6 mt-4">
                            <div class="flex items-center">
                                <i class="fas fa-clipboard"></i>
                                <h3 class="font-semibold text-xl text-indigo-500 leading-tight">
                                Riwayat Imunisasi
                                </h3>
                            </div>
                            <div class="mt-4">
                                <jet-label for="riwayat" value="Imunisasi yang Telah Diberikan*" />
                                <input v-model="form.done" type='checkbox' id='done1' value='1'>
                                <label class="ml-3" for="done1">HB0</label><br>
                                <input v-model="form.done" type='checkbox' id='done2' value='2'>
                                <label class="ml-3" for="done2">BCG</label><br>
                                <input v-model="form.done" type='checkbox' id='done3' value='3'>
                                <label class="ml-3" for="done3">Polio 1</label><br>
                                <input v-model="form.done" type='checkbox' id='done4' value='4'>
                                <label class="ml-3" for="done4">DPT-HB-Hib 1</label><br>
                                <input v-model="form.done" type='checkbox' id='done5' value='5'>
                                <label class="ml-3" for="done5">Polio 2</label><br>
                                <input v-model="form.done" type='checkbox' id='done6' value='6'>
                                <label class="ml-3" for="done6">DPT-HB-Hib 2</label><br>
                                <input v-model="form.done" type='checkbox' id='done7' value='7'>
                                <label class="ml-3" for="done7">Polio 3</label><br>
                                <input v-model="form.done" type='checkbox' id='done8' value='8'>
                                <label class="ml-3" for="done8">DPT-HB-Hib 3</label><br>
                                <input v-model="form.done" type='checkbox' id='done9' value='9'>
                                <label class="ml-3" for="done9">Polio 4</label><br>
                                <input v-model="form.done" type='checkbox' id='done10' value='10'>
                                <label class="ml-3" for="done10">MR</label><br>
                                <input v-model="form.done" type='checkbox' id='done11' value='11'>
                                <label class="ml-3" for="done11">DPT-HB-Hib Lanjutan</label><br>
                                <input v-model="form.done" type='checkbox' id='done11' value='12'>
                                <label class="ml-3" for="done11">MR Lanjutan</label><br>
                            </div>
                                <div class="mt-4">
                                    <jet-label for="last_polio" value="Tanggal Pemberian Polio Terakhir" />
                                    <jet-input id="last_polio" type="date" class="mt-1 block w-full" v-model="form.last_polio" />
                                </div>
                                <div class="mt-4">
                                    <jet-label for="last_dpt" value="Tanggal Pemberian DPT-HB-Hib Terakhir" />
                                    <jet-input id="last_dpt" type="date" class="mt-1 block w-full" v-model="form.last_dpt" />
                                </div>
                                <div class="mt-4">
                                    <jet-label for="last_mr" value="Tanggal Pemberian MR Terakhir" />
                                    <jet-input id="last_mr" type="date" class="mt-1 block w-full" v-model="form.last_mr" />
                                </div>
                                <div class="flex justify-right pt-3">
                                    <jet-button class="bg-indigo-500">
                                        Simpan
                                    </jet-button>
                                </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetCheckbox from "@/Jetstream/Checkbox"
    import JetButton from '@/Jetstream/Button'
    import { differenceInMonths } from 'date-fns'

    export default {
        components: {
            AppLayout,
            Welcome,
            JetButton,
            JetLabel,
            JetCheckbox,
            JetInput
        },
        props: ['baby'],
        data() {
            return {
                form: {
                    nama: this.baby.nama,
                    ttl: this.baby.ttl,
                    bb: this.baby.bb,
                    done: [],
                    last_polio: null,
                    last_dpt: null,
                    last_mr: null,
                    user_id: this.$page.props.user.id
                }
            }
        },
         methods: {
            submit() {
                if (this.form.bb == 0) {
                    alert("Bayi tidak dapat melaksanakan imunisasi karena berat badan bayi tidak lebih dari 2 kg. Mohon isi kembali ketika berat badan bayi sudah mencukupi.")
                    return
                }
                const data = {...this.form}
                data.done = JSON.stringify(this.form.done)
                this.$inertia.post(this.route('form.store', {baby_id: this.baby.id}), data)
            }
        },
        computed: {
            displayAge() {
                if (!this.form.ttl) {
                    return 'Masukkan tanggal lahir bayi terlebih dahulu'
                }

                const age = differenceInMonths(new Date(), new Date(this.form.ttl))
                if (age < 0) {
                   return 'Tanggal lahir bayi yang dimasukkan salah' 
                }
            
                return age + ' Bulan'
            }
        }
    }
</script>