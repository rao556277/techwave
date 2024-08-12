<template>
  <div class="container">
    <h1>Users</h1>
    <router-link to="/admin/users/create" class="btn btn-primary mb-4">Create User</router-link>
    <table class="table mt-4">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.role }}</td>
          <td>
            <router-link :to="'/admin/users/' + user.id + '/edit'" class="btn btn-warning">Edit</router-link>
            <button @click="deleteUser(user.id)" class="btn btn-danger">Delete</button>
            <router-link :to="'/admin/users/' + user.id" class="btn btn-info">View</router-link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      users: []
    };
  },
  mounted() {
    this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await axios.get('/api/users');
        this.users = response.data;
      } catch (error) {
        console.error('Error fetching users:', error);
      }
    },
    async deleteUser(userId) {
      if (confirm('Are you sure you want to delete this user?')) {
        try {
          await axios.delete(`/api/users/${userId}`);
          this.fetchUsers(); // Refresh the list after deletion
        } catch (error) {
          console.error('Error deleting user:', error);
        }
      }
    }
  }
};
</script>

<style scoped>
/* Add any additional styling you need here */
.container {
  max-width: 800px;
  margin: 0 auto;
}
</style>
