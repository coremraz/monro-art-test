<template>
  <div class="channel-select-container">
    <form v-if="isSended === false" @submit.prevent="requestCode">
      <select v-model="selectedChannel" class="channel-select-input">
        <option value="telegram">telegram</option>
        <option value="phone">sms</option>
        <option value="email">email</option>
      </select>
      <button type="submit" class="channel-select-button">Отправить код</button>
    </form>
    <div v-if="isSended">
      <CodeInput :code="code" :userId="userId" :channel="selectedChannel" :updatedData="updatedData"
                 @userUpdated="$emit('userUpdated')" @stopEditing="$emit('stopEditing')"/>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import CodeInput from "@/components/CodeInput.vue";
const apiUrl = process.env.VUE_APP_API_URL;

export default {
  components: {
    CodeInput
  },
  props: {
    userId: {
      type: Number,
      required: true
    },
    updatedData: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      selectedChannel: 'telegram',
      isSended: false,
      code: null
    };
  },
  methods: {
    async requestCode() {
      if (!this.userId) {
        throw new Error('User ID is required');
      }

      const requestData = {
        id: this.userId,
        channel: this.selectedChannel
      };

      try {
        const response = await axios.post(`${apiUrl}/api/v1/user/sendCode`, requestData);
        this.isSended = response.status === 200;
        this.code = response.data.data.code;
      } catch (error) {
        console.error(error);
      }
    }
  }
};
</script>

<style scoped>
.channel-select-container {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 1vw;
  gap: 10px;
  margin-bottom: 20px;
}

.channel-select-input {
  padding: 10px;
  background: #ffffff;
  border: 1px solid #ced4da;
  border-radius: 8px;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
  flex: 1;
}

.channel-select-button {
  padding: 10px;
  background: #007bff;
  color: #ffffff;
  border: none;
  margin-left: 0.5vw;
  border-radius: 8px;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.channel-select-button:hover {
  background-color: #0069d9;
}
</style>