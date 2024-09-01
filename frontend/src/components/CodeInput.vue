<template>
  <form @submit.prevent="checkCode" v-if="isUserUpdate === false" class="code-input-container">
    <span class="code-input-label">Ваш код: {{ code }}</span>
    <input v-model="userCode" type="text" name="userCode" placeholder="введите код" class="code-input-field">
    <button type="submit" class="code-input-button">Подтвердить</button>
    <p v-if="successMessage" class="code-input-success">{{ successMessage }}</p>
    <p v-if="errorMessage" class="code-input-error">{{ errorMessage }}</p>
  </form>
</template>

<script>
import axios from "axios";
const apiUrl = process.env.VUE_APP_API_URL;

export default {
  props: {
    channel: String,
    userId: {
      type: Number,
      required: true
    },
    code: String,
    updatedData: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      isUserUpdate: false,
      userCode: null,
      successMessage: null,
      errorMessage: null
    }
  },
  methods: {
    checkCode() {
      const requestData = {
        id: this.userId,
        code: this.userCode
      };

      try {
        axios.post(`${apiUrl}/api/v1/user/verifyCode`, requestData)
            .then(response => {
              console.log(response)
              this.updateUser();
              this.successMessage = 'Код подтвержден!';
              this.errorMessage = null;
            })
            .catch(error => {
              console.error(error);
              this.errorMessage = 'Ошибка подтверждения кода!';
              this.successMessage = null;
            });
      } catch (error) {
        console.error(error);
        this.errorMessage = 'Ошибка подтверждения кода!';
        this.successMessage = null;
      }
    },
    updateUser() {
      axios.patch(`${apiUrl}/api/v1/user/${this.userId}`, this.updatedData)
          .then(() => {
            this.isUserUpdate = true;
            this.$emit('userUpdated');
            this.$emit('stopEditing');
          })
          .catch(error => {
            console.error(error);
          });
    }
  }
}
</script>

<style scoped>
.code-input-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
}

.code-input-success {
  color: #28a745; /* Green color for success message */
  font-weight: 500;
  margin-top: 10px;
}

.code-input-error {
  color: #dc3545; /* Red color for error message */
  font-weight: 500;
  margin-top: 10px;
}

.code-input-label {
  font-weight: bold;
  margin-bottom: 5px;
}

.code-input-field {
  padding: 10px;
  background: #ffffff;
  border: 1px solid #ced4da;
  border-radius: 8px;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
  width: 100%;
}

.code-input-button {
  padding: 10px;
  background: #007bff;
  color: #ffffff;
  border: none;
  border-radius: 8px;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.code-input-button:hover {
  background-color: #0069d9;
}
</style>