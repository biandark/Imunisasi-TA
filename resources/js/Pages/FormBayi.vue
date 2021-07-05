<template>
    <app-layout>
        <template #header>
            <h2 class="font-bold text-xl text-center text-gray-800 leading-tight">
                Tambah Data Anak Anda
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="p-6 mt-4">
                            <div class="flex items-center"> 
                                <i class="far fa-user"></i>
                                <h3 class="font-semibold text-xl text-indigo-500 leading-tight">
                                Data Anak
                                </h3>
                            </div>
                            <div class="mt-4">
                                <jet-label for="nama" value="Nama*" />
                                <jet-input id="nama" type="text" class="mt-1 block w-full" v-model="form.nama" required />
                            </div>
                            <div class="mt-4">
                                <jet-label for="ttl" value="Tanggal Lahir*" />
                                <jet-input id="ttl" type="date" class="mt-1 block w-full" v-model="form.ttl" required />
                            </div>
                            <div  class="mt-4">
                                <jet-label for="usia" value="Usia*" />
                                <div class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full">{{ displayAge }}</div>
                            </div>
                            <div class="mt-4">
                                <jet-label for="gender" value="Jenis Kelamin*" />
                                <select required v-model="form.gender" placeholder="Jenis Kelamin" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    <option disabled value="">Jenis Kelamin</option>
                                    <option>Laki-Laki</option>
                                    <option>Perempuan</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <jet-label for="bb" value="Apakah berat badan anak Anda lebih dari 2 kg?*" />
                                <select required v-model="form.bb" placeholder="Ya/Tidak" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <jet-label value="PERINGATAN: Aplikasi tidak dapat digunakan untuk bayi dengan kondisi prematur (lahir lebih awal dari hari perkiraan lahir)" />
                            </div>
                            <div class="flex justify-right pt-3">
                                <jet-button class="bg-indigo-500">
                                    Simpan
                                </jet-button>
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
    import JetCheckbox from "@/Jetstream/Checkbox";
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
        data() {
            return {
                form: {
                    nama: null,
                    ttl: null,
                    bb: null,
                    gender: null,
                    user_id: this.$page.props.user.id
                }
            }
        },
         methods: {
            submit() {
                if (this.form.bb == 0) {
                    alert("Anak Anda tidak dapat melaksanakan imunisasi karena berat badan tidak lebih dari 2 kg. Mohon isi kembali ketika berat badan anak sudah mencukupi.")
                    return
                }
                const data = {...this.form}
                this.$inertia.post(this.route('databayi.store'), data)
            }
        },
        computed: {
            displayAge() {
                if (!this.form.ttl) {
                    return 'Masukkan tanggal lahir terlebih dahulu'
                }

                const ageInMonths = differenceInMonths(new Date(), new Date(this.form.ttl))
                const years = Math.floor(ageInMonths / 12);
                const months = ageInMonths % 12;

                if (ageInMonths < 0) {
                   return 'Tanggal lahir yang dimasukkan salah' 
                }

                if (ageInMonths >= 12) {
                   return `${years} Tahun ${months} Bulan`
                }
            
                return `${months} Bulan`
            }
        }
    }
</script>