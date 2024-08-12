<template>
  <div class="container">
    <h2>Edit User</h2>
    <form @submit.prevent="updateUser">
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
        <input type="password" id="pwd" v-model="form.password">
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
      <button type="submit">Update User</button>
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
  mounted() {
    this.fetchUser();
  },
  methods: {
    async fetchUser() {
      try {
        const response = await axios.get(`/api/users/${this.$route.params.id}`);
        this.form = { ...response.data, password: '' }; // Do not preload the password
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    },
    handleFileUpload(event) {
      this.form.image = event.target.files[0];
    },
    async updateUser() {
      const formData = new FormData();
      for (const key in this.form) {
        formData.append(key, this.form[key]);
      }

      try {
        await axios.put(`/api/users/${this.$route.params.id}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        this.$router.push('/admin/users'); // Redirect to the user list or another page
      } catch (error) {
        console.error('Error updating user:', error);
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
