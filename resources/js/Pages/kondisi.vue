<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight">
                Tambah Jadwal Imunisasi Pilihan Baru
            </h2>
        </template>
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-8 py-4">
                    <div v-if="$page.props.flash.message" class="text-center text-red-600">
                        {{ $page.props.flash.message }}
                    </div>
                <form @submit.prevent="submit">
                <div class="grid grid-cols-1 md:grid-cols-2">   
                    <div class="p-6 mt-4">
                    <div class="flex items-center">
                        <i class="far fa-user"></i>
                        <h3 class="font-semibold text-xl text-indigo-500 leading-tight">
                        Data Pasien
                        </h3>
                    </div>
                    <div class="mt-4">
                        <jet-label for="namapasien" value="Nama Pasien*" />
                        <jet-input id="namapasien" type="text" class="mt-1 block w-full" v-model="form.nama" required disabled/>
                    </div>
                    <div class="mt-4">
                        <jet-label for="tgl_lahir" value="Tanggal Lahir*" />
                        <jet-input id="tgl_lahir" type="date" class="mt-1 block w-full" v-model="form.ttl" required disabled/>
                    </div>
                    <div class="mt-4">
                        <jet-label for="gender" value="Jenis Kelamin*" />
                        <jet-input id="gender" type="text" class="mt-1 block w-full" v-model="form.gender" required disabled/>
                    </div>
                    <div class="mt-4">
                        <jet-label for="travelling" value="Ada Keperluan Travelling?*" />
                        <select required v-model="form.travelling" placeholder="Travel" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option disabled value="">Travelling</option>
                            <option>Ya</option>
                            <option>Tidak</option>
                        </select>
                    </div>
                    </div>
                    <div class="p-6 mt-4">
                    <div class="flex items-center">
                        <i class="fas fa-route"></i>
                        <h3 class="font-semibold text-xl text-indigo-500 leading-tight">
                        Kondisi Pasien
                        </h3>
                    </div>
                    <div class="mt-4">
                        <jet-label for="kondisi" value="Kondisi" />
                        <div class="mt-2 flex">
			                <input type="checkbox" id="hamil" v-model="form.kondisi" value="hamil"/>
			                <jet-label class="pl-2" for="hamil">Hamil lebih dari 3 bulan</jet-label>
		                </div>
                        <div class="mt-2 flex">
			                <input type="checkbox" id="pneumo" v-model="form.kondisi" value="Tinggal di lingkungan rokok, padat, panti" />
			                <jet-label class="pl-2" for="pneumo">Tinggal di lingkungan merokok, lingkungan padat, atau panti asuhan</jet-label>
		                </div>
                        <div class="mt-2 flex">
			                <input type="checkbox" id="hewan" v-model="form.kondisi" value="Memiliki hewan peliharaan (anjing, kucing, kera)"/>
			                <jet-label class="pl-2" for="hewan">Memiliki hewan anjing, kucing, kera</jet-label>
		                </div>
                        <div class="mt-2 flex">
			                <input type="checkbox" id="endemism" v-model="form.kondisi" value="Pergi ke daerah endemis meningitis" />
			                <jet-label class="pl-2" for="endemism">Bepergian ke daerah endemis Meningitis</jet-label>
		                </div>
                        <div class="mt-2 flex">
                            <input type="checkbox"  id="endemisy" class="mt-1" v-model="form.kondisi" value="Pergi ke daerah endemis yellow fever"/>
                            <jet-label class="pl-2" for="endemisy">Bepergian ke daerah endemis Yellow Fever</jet-label>
                        </div>
                        <div class="mt-2 flex">
                            <input type="checkbox"  id="endemisa" class="mt-1" v-model="form.kondisi" value="Pergi ke daerah endemis hepatitis A" /> 
                            <jet-label class="pl-2" for="endemisa">Bepergian ke daerah endemis Hepatitis A</jet-label>
                        </div>
                        <div class="mt-2 flex">
                            <input type="checkbox"  id="endemisj" class="mt-1" v-model="form.kondisi" value="Pergi atau tinggal di daerah endemis Japanesse Ensephalitis" /> 
                            <jet-label class="pl-2" for="endemisj">Bepergian ke daerah endemis Japanese Ensephalitis</jet-label>
                        </div>
                        <div class="mt-2 flex">
                            <input type="checkbox"  id="hiv" class="mt-1" v-model="form.kondisi" value="Petugas fasilitas kesehatan" /> 
                            <jet-label class="pl-2" for="hiv">Petugas fasilitas kesehatan, pengobatan HIV PMS, endemis Hepatitis B</jet-label>
                        </div>
                        <div class="mt-2 flex">
                            <input type="checkbox"  id="dbd" class="mt-1" v-model="form.kondisi" value="Pernah terkena penyakit demam berdarah" /> 
                            <jet-label class="pl-2" for="dbd">Pernah terkena penyakit demam berdarah</jet-label>
                        </div>
                        <div class="mt-2 flex">
                        <inertia-link class="text-green-500" :href="route('endemis')">
                            <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                <div>Lihat Daftar Daerah Endemis</div>
                                <div class="ml-1 text-indigo-500">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                        </inertia-link>
                        </div>
                    </div>
                    <div class="mt-4">
                        <jet-label for="tgl_brkt" value="Tanggal Keberangkatan" />
                        <jet-input id="tgl_brkt" type="date" class="mt-1 block w-full" v-model="form.tgl_brkt" />
                        <p class="text-sm">*diisi jika bepergian ke daerah endemis</p>
                    </div>
                    <div class="mt-4">
                        <jet-label for="imunisasisblm" value="Imunisasi Sebelumnya" />
                        <select v-model="form.imunisasisblm" placeholder="Pilih Imunisasi" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option disabled value="">Pilih Imunisasi</option>
                            <option>Pneumokokus 1</option>
                            <option>Pneumokokus 2</option>
                            <option>Tifoid Polisakarida</option>
                            <option>Hepatitis A 1</option>
                            <option>HPV 1</option>
                            <option>HPV 1 Bivalen</option>
                            <option>HPV 2 Bivalen</option>
                            <option>HPV 1 Quadrivalen</option>
                            <option>HPV 2 Quadrivalen</option>
                            <option>Japanesse Ensephalitis 1</option>
                            <option>Hepatitis B 1</option>
                            <option>Hepatitis B 2</option>
                            <option>Demam Berdarah 1</option>
                            <option>Demam Berdarah 2</option>
                            <option>Influenza 1</option>
                            <option>Rotavirus 1</option>
                            <option>Rotavirus 2</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <jet-label for="tgl" value="Tanggal Pemberian" />
                        <jet-input id="tgl" type="date" class="mt-1 block w-full" v-model="form.tgl" />
                        <p class="text-sm">*diisi jika sudah mendapat imunisasi sebelumnya</p>
                    </div>
                    <div class="flex items-center mt-4">
                        <jet-button class="bg-indigo-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Simpan
                        </jet-button>
                        <inertia-link class="text-indigo-500 ml-5" :href="route('riwayat', {baby_id:baby.id})">
                            <div class="mt-3 underline text-sm font-semibold text-indigo-700">
                                <div>Lihat Riwayat Imunisasi</div>
                            </div>
                        </inertia-link>
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
        props: ['baby'],
        data() {
            return {
                form: {
                    nama: this.baby.nama,
                    ttl: this.baby.ttl,
                    gender: this.baby.gender,
                    travelling: "",
                    kondisi: [],
                    tgl_brkt: null,
                    imunisasisblm: "",
                    tgl: null,
                    imunisasi:"",
                    tgl_rekom:"",
                },
            }
            
        },
        methods: {
            submit() {
                if (this.form.kondisi.includes("Pergi ke daerah endemis meningitis") && this.form.tgl_brkt ==null) {
                    alert("Isi tanggal keberangkatan ke daerah endemis meningitis")
                    return
                }
                if (this.form.kondisi.includes("Pergi ke daerah endemis yellow fever") && this.form.tgl_brkt ==null) {
                    alert("Isi tanggal keberangkatan ke daerah endemis yellow fever")
                    return
                }
                const data = {...this.form}
                data.kondisi = JSON.stringify(this.form.kondisi)
                this.$inertia.post(this.route('kondisi.store', {baby_id: this.baby.id}), data)
            }
        }
    }
</script>