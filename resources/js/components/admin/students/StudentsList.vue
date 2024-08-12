<template>
  <div class="container pl-5 mr-5">
    <div class="row justify-content-end">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <h3>Students <small>Manage your students</small></h3>
              </div>
              <div class="col-md-6 text-right">
                <div class="input-group">
                  <input v-model="searchQuery" type="text" class="form-control" placeholder="Search for students...">
                  <span class="input-group-btn">
                    <button class="btn btn-secondary" @click="search">Search</button>
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div class="card-body">
            <router-link to="/admin/students/create" class="btn btn-primary mb-3">Add Student</router-link>
            <div class="card-box table-responsive">
              <table class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Image</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="student in filteredStudents" :key="student.id">
                    <td>{{ student.id }}</td>
                    <td>{{ student.first_name }} {{ student.last_name }}</td>
                    <td>
                      <img :src="student.image ? `/storage/${student.image}` : '/images/default.png'"
                           alt="Student Image"
                           class="rounded-circle"
                           style="width: 50px; height: 50px; object-fit: cover;">
                    </td>
                    <td>{{ student.contact }}</td>
                    <td>{{ student.email }}</td>
                    <td>
                      <router-link :to="{ name: 'students.show', params: { id: student.id } }" class="btn btn-info btn-sm">View</router-link>
                      <router-link :to="{ name: 'students.edit', params: { id: student.id } }" class="btn btn-warning btn-sm">Edit</router-link>
                      <button @click="confirmDelete(student.id)" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { mapState } from 'vuex';

export default {
  data() {
    return {
      students: [],
      searchQuery: '',
    };
  },
  computed: {
    filteredStudents() {
      return this.students.filter(student => {
        return student.first_name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
               student.last_name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
               student.email.toLowerCase().includes(this.searchQuery.toLowerCase());
      });
    }
  },
  methods: {
    async fetchStudents() {
      try {
        const response = await axios.get('/api/students');
        this.students = response.data;
      } catch (error) {
        console.error('Error fetching students:', error);
      }
    },
    async confirmDelete(id) {
      if (confirm('Are you sure you want to delete this student?')) {
        try {
          await axios.delete(`/api/students/${id}`);
          this.students = this.students.filter(student => student.id !== id);
        } catch (error) {
          console.error('Error deleting student:', error);
        }
      }
    },
    search() {
      // The search is handled dynamically via the computed property
    }
  },
  created() {
    this.fetchStudents();
  }
};
</script>

<style scoped>
/* Add any additional styling you need here */
</style>
