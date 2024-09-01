<template>
  <TotalUsers ref="totalUsers"/>
  <form id="RegistrationForm" @submit.prevent="registerUser" class="registration-card">
    <input name="email" v-model="email" placeholder="email" class="input-field" />
    <input name="phone" v-model="phone" placeholder="phone" class="input-field" />
    <input name="telegram" v-model="telegram" placeholder="telegram" class="input-field" />
    <input type="password" name="password" v-model="password" placeholder="password" class="input-field" />
    <button type="submit" class="submit-button">Register</button>
    <p v-if="successMessage" class="success-message">{{ successMessage }}</p>
  </form>
</template>

<script>
import { ref } from 'vue';
import TotalUsers from "@/components/TotalUsers.vue";
const apiUrl = process.env.VUE_APP_API_URL;

export default {
  name: 'RegistrationForm',
  components: {
    TotalUsers,
  },
  setup() {
    let email = ref('');
    let phone = ref('');
    let telegram = ref('');
    let password = ref('');
    let successMessage = ref('');

    const registerUser = (event) => {
      event.preventDefault();
      const formData = new FormData(event.target);
      fetch(`${apiUrl}/api/v1/register`, {
        method: 'POST',
        body: formData
      })
          .then(response => response.json())
          .then(() => {
            successMessage.value = 'Пользователь зарегистрирован!';
          })
          .catch(error => {
            console.error(error);
          });
    }

    return {
      email,
      phone,
      telegram,
      password,
      successMessage,
      registerUser
    }
  }
}
</script>

<style scoped>
.registration-card {
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding: 20px;
  background: #f8f9fa;
  border-radius: 10px;
  box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);
}

.input-field {
  padding: 10px;
  background: #ffffff;
  border: 1px solid #ced4da;
  border-radius: 8px;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.submit-button {
  padding: 10px;
  background: #007bff;
  color: #ffffff;
  border: none;
  border-radius: 8px;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.submit-button:hover {
  background-color: #0069d9;
}

.success-message {
  color: #28a745; /* Зеленый цвет для сообщения об успехе */
  font-weight: 500;
  margin-top: 10px;
}
</style>