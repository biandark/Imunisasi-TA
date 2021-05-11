<template>
    <inertia-link :href="'/'">
            <img :src="logo" width="90" class="mt-4" />
    </inertia-link>
</template>

<script>
import logo from "/images/imunlogo.png"

export default{
  data:function(){
    return{
      logo: logo
    }
  }
}
</script>
