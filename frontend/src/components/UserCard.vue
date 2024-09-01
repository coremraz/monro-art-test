<template>
  <div class="user-profile-container" v-if="user">
    <form @submit.prevent="submitChanges">
      <div class="profile-field">
        <span>ID:</span> {{ user.id }}
      </div>
      <div class="profile-field">
        <span>Name:</span>
        <template v-if="!isEditing">
          {{ user.name }}
        </template>
        <template v-else>
          <input type="text" name="name" v-model="editedUser.name" :disabled="isInputDisabled"/>
        </template>
      </div>
      <div class="profile-field">
        <span>Email:</span>
        <template v-if="!isEditing">
          {{ user.email }}
        </template>
        <template v-else>
          <input type="email" name="email" v-model="editedUser.email" :disabled="isInputDisabled"/>
          <div v-if="errors.email" class="error-message">{{ errors.email }}</div>
        </template>
      </div>
      <div class="profile-field">
        <span>Telegram:</span>
        <template v-if="!isEditing">
          {{ user.telegram }}
        </template>
        <template v-else>
          <input type="text" name="telegram" v-model="editedUser.telegram" :disabled="isInputDisabled"/>
          <div v-if="errors.telegram" class="error-message">{{ errors.telegram }}</div>
        </template>
      </div>
      <div class="profile-field">
        <span>Phone:</span>
        <template v-if="!isEditing">
          {{ user.phone }}
        </template>
        <template v-else>
          <input type="tel" name="phone" v-model="editedUser.phone" :disabled="isInputDisabled"/>
          <div v-if="errors.phone" class="error-message">{{ errors.phone }}</div>
        </template>
      </div>

      <div class="action-buttons">
        <button class="edit-button" @click="toggleEditing" v-if="!isEditing">
          Edit
        </button>
        <button class="save-button" @click="submitChanges" v-if="!isDone && isEditing">
          Save
        </button>
      </div>
    </form>
  </div>

  <div v-if="isDone">
    <ChannelSelect :userId="user.id" :updatedData="updatedData" @userUpdated="$emit('update:user')"
                   @stopEditing="isEditing = false, isDone = false"/>
  </div>
</template>

<script>
import ChannelSelect from "@/components/ChannelSelect.vue";

export default {
  data() {
    return {
      isEditing: false,
      editedUser: {},
      isDone: false,
      updatedData: {
        type: Object,
        required: true
      },
      errors: {}
    };
  },
  computed: {
    isInputDisabled() {
      if (this.isDone) {
        return true;
      } else {
        return false;
      }
    }
  },
  components: {
    ChannelSelect
  },
  props: {
    user: Object,
  },
  methods: {
    submitChanges() {
      const errors = this.validateForm();
      if (Object.keys(errors).length > 0) {
        this.errors = errors;
        return;
      }

      for (const setting in this.editedUser) {
        if (this.editedUser[setting] !== this.user[setting] || (this.editedUser[setting]?.length >= 5 && this.user[setting]?.length < 5)) {
          this.updatedData[setting] = this.editedUser[setting];
        }
      }

      if (Object.keys(this.updatedData).length > 0) { // Отправляем запрос, только если есть измененные данные
        this.isDone = true;
      } else {
        // Можно вывести сообщение пользователю, что он не внес никаких изменений
        console.log("No changes made");
        this.isEditing = false;
      }
    },
    toggleEditing() {
      this.isEditing = !this.isEditing;
      if (this.isEditing) {
        this.editedUser = {...this.user}; // Копируем данные пользователя для редактирования
      }
    },
    validateForm() {
      const errors = {};
      if (this.editedUser.email && !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(this.editedUser.email)) {
        errors.email = 'Некорректный email';
      }
      if (this.editedUser.phone && !/^\d{10}$/.test(this.editedUser.phone)) {
        errors.phone = 'Некорректный номер телефона';
      }
      if (this.editedUser.telegram && !/^[a-zA-Z0-9_]+$/.test(this.editedUser.telegram)) {
        errors.telegram = 'Некорректный логин Telegram';
      }
      return errors;
    },
  },
};
</script>

<style scoped>
.error-message {
  color: red;
  font-size: 12px;
  margin-top: 5px;
}

.action-buttons {
  display: flex;
  align-items: center;
  justify-content: center;
}

.edit-button,
.save-button {
  padding: 8px 12px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-weight: 500;
}

.edit-button {
  background-color: #ffc107;
  color: #fff;
}

.save-button {
  background-color: #28a745;
  color: #fff;
}

.user-profile-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 1vw;
  gap: 15px;
  background: #f8f9fa;
  border-radius: 10px;
  box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);
}

.profile-field {
  display: flex;
  align-items: center;
  padding: 10px 15px;
  margin-bottom: 0.5vw;
  background: #ffffff;
  border-radius: 8px;
  box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.profile-field input {
  width: 100%;
}

.profile-field:hover {
  background-color: #f0f2f5;
}

.profile-field .error-message {
  color: red;
  font-size: 12px;
  margin-top: 5px;
}

.profile-field span {
  margin-right: 10px;
  font-weight: 500;
  color: #343a40;
}

</style>