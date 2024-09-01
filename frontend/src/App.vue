<template>
  <section class="container">
    <CreateUser/>
    <br>
    <find-user/>
  </section>

</template>

<script>

import CreateUser from "@/components/CreateUser.vue";
import FindUser from "@/components/FindUser.vue";

export default {
  name: 'App',
  components: {
    FindUser,
    CreateUser,
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 2vw;
}
</style>
