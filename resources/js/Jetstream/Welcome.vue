<template>
    <div>
        <div class="p-6 flex sm:px-20 grid grid-cols-1 md:grid-cols-2">
            <!-- banner -->
            <div class="mx-auto">
                <img :src="landing"/>
            </div>
            <div class="items-center ml-4">
                <h1 class="text-5xl justify-left font-semibold text-grey-500">Pastikan <br />Jadwal Imunisasi Tidak Terlewat  <br />dengan I-Mun </h1>
                <p class="my-6 text-base text-gray-600">Imunisasi memberi perlindungan terhadap  <br />serangan penyakit serius bagi anak  <br />maupun dewasa, serta dapat mencegah <br />persebarannya. Berikan imunisasi tepat pada waktunya  <br />untuk perlindungan yang maksimal dari penyakit.</p>
                <jet-button @click="gotoForm()">Buat Jadwal Imunisasi</jet-button>     
            </div>
        </div>
    </div>
</template>

<script>
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo'
    import landing from "/images/landing.jpg"
    import JetButton from '@/Jetstream/Button'

    export default {
        components: {
            JetApplicationLogo,
            JetButton,
        },

        methods:{
            gotoForm(){
                this.$router.push('form'); 
            }
        },
        data: function () {
            return {
            landing: landing
            }
        }
    }
</script>
