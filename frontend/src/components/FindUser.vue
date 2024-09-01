<template>
  <div class="user-search-container">
    <input type="number" v-model="userId" placeholder="Enter user ID" class="user-search-input"/>
    <button @click="findUser" class="user-search-button">Find</button>
  </div>

  <div v-if="user">
    <UserCard :user="user" @update:user="findUser"/>
  </div>
</template>

<script>
import {ref} from 'vue';
import UserCard from "@/components/UserCard.vue";
import axios from "axios";
const apiUrl = process.env.VUE_APP_API_URL;

export default {
  components: {
    UserCard
  },
  setup() {
    let userId = ref('');
    let user = ref(null);

    const findUser = () => {
      axios.get(`${apiUrl}/api/v1/user/${userId.value}`)
          .then(response => {
            user.value = response.data.data[0];
          })
          .catch(error => {
            console.error(error);
          });
    }

    return {
      userId,
      user,
      findUser,
      apiUrl
    }
  }
}
</script>

<style scoped>
.user-search-container {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
}

.user-search-input {
  padding: 10px;
  background: #ffffff;
  border: 1px solid #ced4da;
  border-radius: 8px;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
  flex: 1;
}

.user-search-button {
  padding: 10px;
  background: #007bff;
  color: #ffffff;
  border: none;
  border-radius: 8px;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.user-search-button:hover {
  background-color: #0069d9;
}
</style>