<template>
  <div class="container">
    <h2>Create User</h2>
    <form @submit.prevent="createUser">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" v-model="form.name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="form.email" required>
      </div>
      <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" id="pwd" v-model="form.password" required>
      </div>
      <div class="form-group">
        <label for="role">Role:</label>
        <select id="role" v-model="form.role" required>
          <option value="Admin">Admin</option>
          <option value="Instructor">Instructor</option>
          <option value="Student">Student</option>
        </select>
      </div>
      <div class="form-group">
        <label for="image">Profile Image:</label>
        <input type="file" id="image" @change="handleFileUpload">
      </div>
      <button type="submit">Create User</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        role: 'Student',
        image: null
      }
    };
  },
  methods: {
    handleFileUpload(event) {
      this.form.image = event.target.files[0];
    },
    async createUser() {
      const formData = new FormData();
      for (const key in this.form) {
        formData.append(key, this.form[key]);
      }

      try {
        await axios.post('/api/users', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        this.$router.push('/admin/users'); // Redirect to the user list or any other page
      } catch (error) {
        console.error('Error creating user:', error);
      }
    }
  }
};
</script>

<style scoped>
/* Add any additional styling you need here */
.container {
  max-width: 600px;
  margin: 0 auto;
}
.form-group {
  margin-bottom: 15px;
}
</style>
