<template>
    <inertia-link :href="'/'">
            <img :src="logo" width="130" class="mt-4" />
    </inertia-link>
</template>

<script>
import logo from "/images/imunlogo3.png"

export default{
  data:function(){
    return{
      logo: logo
    }
  }
}
</script>
