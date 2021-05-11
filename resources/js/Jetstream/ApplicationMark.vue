<template>
    <div class="mb-2 mt-2">
      <img :src="logo" width="48" />
    </div>
</template>

<script>
import logo from "/images/imunlogo2.png"

export default{
  data:function(){
    return{
      logo: logo
    }
  }
}
</script>

