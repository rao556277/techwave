<template>
  <div class="container">
    <h1>Instructor Details</h1>

    <div class="card">
      <div class="card-body">
        <h5 class="card-title">{{ instructor.first_name }} {{ instructor.last_name }}</h5>
        <p class="card-text"><strong>Email:</strong> {{ instructor.email }}</p>
        <p class="card-text"><strong>Contact:</strong> {{ instructor.contact }}</p>
        <p class="card-text"><strong>Bio:</strong> {{ instructor.bio }}</p>
        <img :src="imageUrl" alt="Instructor Image" class="img-fluid" style="max-width: 200px;">
        <router-link :to="{ name: 'EditInstructor', params: { id: instructor.id } }" class="btn btn-warning mt-3">Edit</router-link>
        <router-link to="/admin/instructors" class="btn btn-secondary mt-3">Back to List</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      instructor: {}
    };
  },
  computed: {
    imageUrl() {
      return this.instructor.image ? `/storage/${this.instructor.image}` : '/images/default-avatar.png';
    }
  },
  methods: {
    fetchInstructor() {
      const instructorId = this.$route.params.id;
      axios.get(`/api/instructors/${instructorId}`)
        .then(response => {
          this.instructor = response.data;
        })
        .catch(error => {
          console.error('Error fetching instructor data:', error);
        });
    }
  },
  mounted() {
    this.fetchInstructor();
  }
};
</script>

<style scoped>
.card-body {
  padding: 20px;
}

.btn {
  margin-right: 10px;
}
</style>
