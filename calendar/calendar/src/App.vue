<template>
  <div id="app">
    <div id="logo">
      <span>72 DRAGONS</span>
      <img src="./assets/72dragonLogo.png">
    </div>
    
    <router-view/>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
#app{
  background:black
}
#app,body,html{
  width: 100%;
  height: 100%;
  margin: 0;
  overflow: hidden;
}
#app img{
  width: 5rem;
  vertical-align: middle
}
#app #logo{
  display: inline-block;
  vertical-align: middle;
  margin-left: 2rem
}
#logo span{
  height: 5rem;
  line-height: 5rem;
  display: inline-block;
  vertical-align: middle;
  color: #96031A;
  font-size: 1.8rem;
}
@media screen and (max-width:767px) {
  #app #logo{
    display: none
  }
}
</style>
