<template>
  <div class="container pl-5 mr-5">
    <div class="row justify-content-end">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header text-center">
            <h3>Edit Admin Information</h3>
          </div>
          <div class="card-body">
            <!-- Display validation errors if any -->
            <div v-if="errors.length" class="alert alert-danger">
              <ul>
                <li v-for="error in errors" :key="error">{{ error }}</li>
              </ul>
            </div>

            <!-- user editing form -->
            <form @submit.prevent="updateUser">
              <div class="text-center mb-4 position-relative">
                <img :src="imagePreviewUrl" alt="Profile Image" class="rounded-circle" width="150" height="150">

                <!-- Edit icon -->
                <label for="image" class="position-absolute edit-icon">
                  <i class="fa fa-pencil-alt"></i>
                </label>
                <input type="file" name="image" id="image" class="d-none" @change="handleFileUpload">
              </div>

              <div class="form-group px-3">
                <label for="first_name">First Name</label>
                <input type="text" v-model="user.first_name" id="first_name" class="form-control" required>
              </div>

              <div class="form-group px-3">
                <label for="last_name">Last Name</label>
                <input type="text" v-model="user.last_name" id="last_name" class="form-control" required>
              </div>

              <div class="form-group px-3">
                <label for="contact">Contact</label>
                <input type="text" v-model="user.contact" id="contact" class="form-control" required>
              </div>

              <div class="form-group px-3">
                <label for="email">Email</label>
                <input type="email" v-model="user.email" id="email" class="form-control" required>
              </div>

              <div class="form-group px-3">
                <label for="password">Password <small>(Leave blank if not changing)</small></label>
                <input type="password" v-model="user.password" id="password" class="form-control">
              </div>

              <div class="form-group px-3">
                <label for="cnic">CNIC</label>
                <input type="text" v-model="user.cnic" id="cnic" class="form-control">
              </div>

              <div class="form-group px-3">
                <label for="bio">Bio</label>
                <textarea v-model="user.bio" id="bio" class="form-control"></textarea>
              </div>

              <div class="text-center mt-4">
                <button type="button" class="btn btn-secondary" @click="cancel">Cancel</button>
                <button type="reset" class="btn btn-primary" @click="resetForm">Reset</button>
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

export default {
  data() {
    return {
      user: {
        first_name: '',
        last_name: '',
        contact: '',
        email: '',
        password: '',
        cnic: '',
        bio: ''
      },
      image: null,
      imagePreviewUrl: '',
      errors: []
    };
  },
  mounted() {
    this.fetchUserData();
  },
  methods: {
    async fetchUserData() {
      try {
        const response = await axios.get('/api/user'); // Adjust API endpoint
        this.user = response.data;
        this.imagePreviewUrl = this.user.image ? `/storage/${this.user.image}` : '/images/default-avatar.png';
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      this.image = file;
      const reader = new FileReader();
      reader.onload = (e) => {
        this.imagePreviewUrl = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    async updateUser() {
      const formData = new FormData();
      for (const key in this.user) {
        formData.append(key, this.user[key]);
      }
      if (this.image) {
        formData.append('image', this.image);
      }

      try {
        await axios.post('/api/user/update', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        alert('User updated successfully');
        // Redirect or additional actions
      } catch (error) {
        this.errors = error.response.data.errors || ['An error occurred'];
        console.error('Error updating user:', error);
      }
    },
    resetForm() {
      this.fetchUserData();
      this.image = null;
      this.imagePreviewUrl = this.user.image ? `/storage/${this.user.image}` : '/images/default-avatar.png';
    },
    cancel() {
      window.location.href = '/'; // Adjust URL as needed
    }
  }
};
</script>

<style scoped>
.edit-icon {
  bottom: 10px;
  right: 415px;
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
