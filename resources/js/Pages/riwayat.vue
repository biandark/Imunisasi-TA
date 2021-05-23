<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight">
                Riwayat Imunisasi
            </h2>
        </template>
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-8 py-4">
                    <div class="grid text-center grid-flow-row grid-cols-1 md:grid-cols-3">
                        <div>
                            <div class="justify-center">
                                <i class="far fa-calendar-alt"></i>
                            </div>
                            <h2 class="mt-2 font-semibold">Nama Pasien</h2>
                            <p> {{ baby.nama }} </p>
                        </div>
                        <div>
                            <div class="justify-center">
                                <i class="far fa-user"></i>
                            </div>
                            <h2 class="mt-2 font-semibold">Usia</h2>
                            <p> {{ displayAge }}</p>
                        </div>
                        <div>
                            <div class="justify-center">
                                <i class="fas fa-venus-mars"></i>
                            </div>
                            <h2 class="mt-2 font-semibold">Jenis Kelamin</h2>
                            <p> {{ baby.gender }} </p>
                        </div>
                        
                    </div>
                    <h3 class="font-semibold mt-6 text-xl text-indigo-500 leading-tight">
                        Daftar Imunisasi
                    </h3>
                    <div class="mt-4 overflow-x-auto">
                    <element class="prose">
                        <table>
                        <thead>
                        <tr>
                            <th >No.</th>
                            <th >Imunisasi</th>
                            <th >Tanggal Rekomendasi</th>
                            <th >Status</th>
                            <th >Tanggal Pemberian Imunisasi</th>
                            <th ></th>
                            <th ></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(jadwal, index) in scheduled" :key="jadwal.id">
                            <td >{{ index+1 }}</td>
                            <td >{{ jadwal.nama }}</td>
                            <td >{{ formatDate(jadwal.tgl_rekom) }}</td>
                            <td >
                                <span v-if="jadwal.tgl_pelaksanaan != NULL" class="text-green-500 font-semibold">Sudah Dilakukan</span>
                                <span v-else class="text-red-500 font-semibold">Belum Dilakukan</span>
                            </td>
                            <td>
                                <div v-if="jadwal.tgl_pelaksanaan == NULL">
                                    {{ jadwal.tgl_pelaksanaan}}
                                </div>
                                <div v-else>
                                    {{ formatDate(jadwal.tgl_pelaksanaan) }}
                                </div>
                            </td>
                            <td>
                                <button v-if="jadwal.status != 'Sudah Dilakukan'" @click="edit(jadwal)" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Update</button>
                            </td>
                            <td>
                                <inertia-link class="text-sm text-indigo-500 underline" :href="route('imunisasi' ,{ data:jadwal.nama})" method="get">
                                Lihat Selengkapnya
                                </inertia-link>
                            </td>
                        </tr>
                        </tbody>
                        </table>
                    </element>
                    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity">
                          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                    <!-- This element is to trick the browser into centering the modal contents. -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                          <form>
                          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="">
                                  <div class="mb-4">
                                    <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Pilih Status" v-model="form.status">
                                        <option disabled value="">Pilih Status</option>
                                        <option>Belum Dilakukan</option>
                                        <option>Sudah Dilakukan</option>
                                    </select>
                                  </div>
                                  <div class="mb-4">
                                      <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pemberian:</label>
                                      <jet-input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput2" v-model="form.tgl_pelaksanaan" />
                                  </div>
                            </div>
                          </div>
                          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-indigo-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-indigo-400 focus:outline-none focus:border-indigo-600 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="editMode" @click="update(form)">
                                Update
                              </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                              
                              <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Cancel
                              </button>
                            </span>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    
                    <div>
                        <inertia-link class="text-indigo-500" :href="route('kondisi', {baby_id:baby.id})">
                            <div class="mt-3 flex items-center underline text-sm font-semibold text-indigo-700">
                                <div>Tambah jadwal imunisasi baru</div>
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
        props: ['baby', 'jadwals'],
        computed: {
            displayAge() {
                const ageInMonths = differenceInMonths(new Date(), new Date(this.baby.ttl))
                const years = Math.floor(ageInMonths / 12);
                const months = ageInMonths % 12;

                if (ageInMonths < 0) {
                   return 'Tanggal lahir bayi yang dimasukkan salah' 
                }

                if (ageInMonths >= 12) {
                   return `${years} Tahun ${months} Bulan`
                }
            
                return `${months} Bulan`
                
            },
            scheduled() {
                return this.jadwals
                    .filter(jadwal => !!jadwal.tgl_rekom)
                    .sort((a, b) => new Date(a.tgl_rekom) - new Date(b.tgl_rekom))
            },
        },
        
        data() {
            return {
                editMode: false,
                isOpen: false,
                form: {
                    Status: "Belum Dilakukan",
                    tgl_pelaksanaan: null,
                },
            }
        },

        methods: {
            openModal: function () {
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
                this.reset();
                this.editMode=false;
            },
            reset: function () {
                this.form = {
                    status: "Belum Dilakukan",
                    tgl_pelaksanaan: null,
                }
            },
            edit: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModal();
            },
            update: function (data) {
                data._method = 'PUT';
                this.$inertia.post(this.route('riwayat.update', {baby_id: this.baby.id}), data)
                this.reset();
                this.closeModal();
            },
            formatDate(date) {
                const tgl = new Date(date)
                return format(tgl, "d MMMM yyyy", {
                        locale: id
                    })
            }, 
        }
      }
      
</script>