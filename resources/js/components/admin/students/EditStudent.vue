<template>
  <div class="container pl-5 mr-5">
    <div class="row justify-content-end">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header text-center">
            <h3>Edit Student Information</h3>
          </div>
          <div class="card-body">
            <!-- Display validation errors if any -->
            <div v-if="errors.length" class="alert alert-danger">
              <ul>
                <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
              </ul>
            </div>

            <!-- Student editing form -->
            <form @submit.prevent="submitForm" enctype="multipart/form-data">
              <div class="text-center mb-4 position-relative">
                <img :src="imagePreview" alt="Profile Image" class="rounded-circle" width="150" height="150">
                <!-- Edit icon -->
                <label for="image" class="position-absolute edit-icon">
                  <i class="fa fa-pencil-alt"></i>
                </label>
                <input type="file" name="image" id="image" class="d-none" @change="onFileChange">
              </div>

              <div class="form-group px-3">
                <label for="first_name">First Name</label>
                <input v-model="student.first_name" type="text" id="first_name" name="first_name" class="form-control" required>
              </div>

              <div class="form-group px-3">
                <label for="last_name">Last Name</label>
                <input v-model="student.last_name" type="text" id="last_name" name="last_name" class="form-control" required>
              </div>

              <div class="form-group px-3">
                <label for="contact">Contact</label>
                <input v-model="student.contact" type="text" id="contact" name="contact" class="form-control" required>
              </div>

              <div class="form-group px-3">
                <label for="cnic">CNIC</label>
                <input v-model="student.cnic" type="text" id="cnic" name="cnic" class="form-control" required>
              </div>

              <div class="form-group px-3">
                <label for="email">Email</label>
                <input v-model="student.email" type="email" id="email" name="email" class="form-control" required>
              </div>

              <div class="form-group px-3">
                <label for="password">Password <small>(Leave blank if not changing)</small></label>
                <input v-model="student.password" type="password" id="password" name="password" class="form-control">
              </div>

              <div class="text-center mt-4">
                <button type="button" class="btn btn-secondary" @click="cancel">Cancel</button>
                <button type="reset" id="resetButton" class="btn btn-primary" @click="resetForm">Reset</button>
                <button type="submit" class="btn btn-success">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';

export default {
  data() {
    return {
      student: {
        first_name: '',
        last_name: '',
        contact: '',
        cnic: '',
        email: '',
        password: '',
        image: null
      },
      imagePreview: '',
      errors: []
    };
  },
  methods: {
    onFileChange(event) {
      const file = event.target.files[0];
      this.student.image = file;
      this.imagePreview = URL.createObjectURL(file);
    },
    async submitForm() {
      this.errors = [];

      try {
        const formData = new FormData();
        for (let key in this.student) {
          formData.append(key, this.student[key]);
        }

        const response = await axios.put(`/api/students/${this.$route.params.id}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });

        this.$router.push('/admin/students');
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.errors = Object.values(error.response.data.errors).flat();
        } else {
          this.errors.push('An error occurred. Please try again.');
        }
      }
    },
    cancel() {
      this.$router.push('/admin/students');
    },
    resetForm() {
      if (confirm('Are you sure you want to reset all fields?')) {
        this.student = {
          first_name: '',
          last_name: '',
          contact: '',
          cnic: '',
          email: '',
          password: '',
          image: null
        };
        this.imagePreview = '';
        this.errors = [];
      }
    }
  },
  created() {
    const studentId = this.$route.params.id;
    axios.get(`/api/students/${studentId}`)
      .then(response => {
        this.student = response.data;
        this.imagePreview = this.student.image ? `/storage/${this.student.image}` : '/images/default-avatar.png';
      })
      .catch(error => {
        console.error('Error fetching student data:', error);
      });
  }
};
</script>

<style scoped>
.edit-icon {
  bottom: 10px;
  right: 10px;
  background-color: #ff4081;
  color: white;
  border-radius: 50%;
  padding: 5px;
  cursor: pointer;
}
.edit-icon i {
  font-size: 16px;
}
</style>
