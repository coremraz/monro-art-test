<template>
  <span>Total users: {{totalUsers}}</span>
</template>

<script>

import {ref} from "vue";
const apiUrl = process.env.VUE_APP_API_URL;

export default {
  setup() {
    let totalUsers = ref(0);

    const getTotalUsers = () => {
      fetch(`${apiUrl}/api/v1/users/all`)
          .then(response => response.json())
          .then(data => {
            totalUsers.value = data.data.userCount;
          })
          .catch(error => {
            console.error(error);
          });
    }

    getTotalUsers();

    return {
      totalUsers,
      getTotalUsers
    }
  }
};
</script>

<style scoped>

</style>