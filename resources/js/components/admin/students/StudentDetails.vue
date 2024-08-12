<template>
  <div class="container pl-5 mr-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header text-center">
            <h3>Student Details</h3>
          </div>
          <div class="card-body">
            <!-- Display validation errors if any -->
            <div v-if="error" class="alert alert-danger">
              {{ error }}
            </div>

            <!-- Student details -->
            <div v-if="student">
              <div class="text-center mb-4">
                <img :src="student.image ? `/storage/${student.image}` : '/images/default.png'"
                     alt="Student Image"
                     class="rounded-circle"
                     style="width: 150px; height: 150px; object-fit: cover;">
              </div>

              <div class="form-group">
                <label for="first_name">First Name:</label>
                <p>{{ student.first_name }}</p>
              </div>

              <div class="form-group">
                <label for="last_name">Last Name:</label>
                <p>{{ student.last_name }}</p>
              </div>

              <div class="form-group">
                <label for="contact">Contact:</label>
                <p>{{ student.contact }}</p>
              </div>

              <div class="form-group">
                <label for="cnic">CNIC:</label>
                <p>{{ student.cnic }}</p>
              </div>

              <div class="form-group">
                <label for="email">Email:</label>
                <p>{{ student.email }}</p>
              </div>

              <!-- Buttons for actions -->
              <div class="text-center mt-4">
                <router-link :to="{ name: 'students.edit', params: { id: student.id } }" class="btn btn-warning">Edit</router-link>
                <router-link to="/admin/students" class="btn btn-secondary">Back to List</router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      student: null,
      error: null,
    };
  },
  methods: {
    async fetchStudent() {
      try {
        const response = await axios.get(`/api/students/${this.$route.params.id}`);
        this.student = response.data;
      } catch (error) {
        this.error = 'Error fetching student details.';
        console.error(error);
      }
    }
  },
  created() {
    this.fetchStudent();
  }
};
</script>

<style scoped>
/* Add any additional styling you need here */
</style>
