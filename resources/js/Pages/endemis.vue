<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight">
                Daftar Daerah Endemis
            </h2>
        </template>
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mx-12 px-8 py-4">
                    <div class="mt-4 overflow-x-auto">
                    <element class="prose">
                        <table>
                        <thead>
                        <tr>
                            <th >No.</th>
                            <th >Imunisasi</th>
                            <th >Daerah Endemis</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(data, index) in data" :key="data.id">
                            <td >{{ index+1 }}</td>
                            <td >{{ data.jenis }}</td>
                            <td >{{ data.daerah }}</td>
                        </tr>
                        </tbody>
                        </table>
                    </element>
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