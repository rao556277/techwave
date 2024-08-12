<template>
  <div class="container">
    <h1>Add New Student</h1>

    <div class="card">
      <div class="card-header">
        <h2>Student Information <small>Fill in the details below</small></h2>
      </div>
      <div class="card-body">
        <form @submit.prevent="submitForm" enctype="multipart/form-data">
          <div v-if="errors.length" class="alert alert-danger">
            <ul>
              <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
            </ul>
          </div>

          <div class="form-group row">
            <label for="first_name" class="col-md-3 col-form-label text-md-right">First Name <span class="required">*</span></label>
            <div class="col-md-6">
              <input v-model="student.first_name" type="text" id="first_name" name="first_name" required class="form-control">
            </div>
          </div>

          <div class="form-group row">
            <label for="last_name" class="col-md-3 col-form-label text-md-right">Last Name <span class="required">*</span></label>
            <div class="col-md-6">
              <input v-model="student.last_name" type="text" id="last_name" name="last_name" required class="form-control">
            </div>
          </div>

          <div class="form-group row">
            <label for="contact" class="col-md-3 col-form-label text-md-right">Contact <span class="required">*</span></label>
            <div class="col-md-6">
              <input v-model="student.contact" type="text" id="contact" name="contact" required class="form-control">
            </div>
          </div>

          <div class="form-group row">
            <label for="cnic" class="col-md-3 col-form-label text-md-right">CNIC <span class="required">*</span></label>
            <div class="col-md-6">
              <input v-model="student.cnic" type="text" id="cnic" name="cnic" required class="form-control">
            </div>
          </div>

          <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label text-md-right">Email <span class="required">*</span></label>
            <div class="col-md-6">
              <input v-model="student.email" type="email" id="email" name="email" required class="form-control">
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-md-3 col-form-label text-md-right">Password <span class="required">*</span></label>
            <div class="col-md-6">
              <input v-model="student.password" type="password" id="password" name="password" required class="form-control">
            </div>
          </div>

          <div class="form-group row">
            <label for="image" class="col-md-3 col-form-label text-md-right">Image</label>
            <div class="col-md-6">
              <input type="file" id="image" @change="onFileChange" class="form-control">
            </div>
          </div>

          <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-3">
              <button type="button" class="btn btn-primary" @click="cancel">Cancel</button>
              <button type="reset" class="btn btn-secondary">Reset</button>
              <button type="submit" class="btn btn-success">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { mapActions } from 'vuex';

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
      errors: []
    };
  },
  methods: {
    onFileChange(event) {
      this.student.image = event.target.files[0];
    },
    cancel() {
      this.$router.push('/admin/students');
    },
    async submitForm() {
      this.errors = [];

      try {
        const formData = new FormData();
        for (let key in this.student) {
          formData.append(key, this.student[key]);
        }

        const response = await axios.post('/api/students', formData, {
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
    }
  }
};
</script>

<style scoped>
.container {
  padding: 20px;
}

.form-group {
  margin-bottom: 15px;
}

.required {
  color: red;
}
</style>
