<template>
  <div class="container pl-5 mr-5">
    <div class="row justify-content-end">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header text-center">
            <h3>Edit Instructor Information</h3>
          </div>
          <div class="card-body">
            <!-- Display validation errors if any -->
            <div v-if="errors.length" class="alert alert-danger">
              <ul>
                <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
              </ul>
            </div>

            <!-- Instructor editing form -->
            <form @submit.prevent="submitForm" enctype="multipart/form-data">
              <div class="text-center mb-4 position-relative">
                <img :src="imagePreview" alt="Profile Image" class="rounded-circle" width="150" height="150" />
                <!-- Edit icon -->
                <label for="image" class="position-absolute edit-icon">
                  <i class="fa fa-pencil-alt"></i>
                </label>
                <input type="file" name="image" id="image" class="d-none" @change="onImageChange" />
              </div>

              <div class="form-group px-3">
                <label for="first_name">First Name</label>
                <input type="text" v-model="instructor.first_name" id="first_name" class="form-control" required />
              </div>

              <div class="form-group px-3">
                <label for="last_name">Last Name</label>
                <input type="text" v-model="instructor.last_name" id="last_name" class="form-control" required />
              </div>

              <div class="form-group px-3">
                <label for="contact">Contact</label>
                <input type="text" v-model="instructor.contact" id="contact" class="form-control" required />
              </div>

              <div class="form-group px-3">
                <label for="email">Email</label>
                <input type="email" v-model="instructor.email" id="email" class="form-control" required />
              </div>

              <div class="form-group px-3">
                <label for="password">Password <small>(Leave blank if not changing)</small></label>
                <input type="password" v-model="instructor.password" id="password" class="form-control" />
              </div>

              <div class="form-group px-3">
                <label for="cnic">CNIC</label>
                <input type="text" v-model="instructor.cnic" id="cnic" class="form-control" />
              </div>

              <div class="form-group px-3">
                <label for="bio">Bio</label>
                <textarea v-model="instructor.bio" id="bio" class="form-control"></textarea>
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
export default {
  props: {
    initialInstructor: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      instructor: {
        ...this.initialInstructor,
        password: ''
      },
      errors: [],
      imagePreview: this.initialInstructor.image
        ? `/storage/${this.initialInstructor.image}`
        : '/images/default-avatar.png'
    };
  },
  methods: {
    submitForm() {
      this.errors = [];

      // Add validation here if necessary

      // Create a FormData object
      const formData = new FormData();
      for (const key in this.instructor) {
        formData.append(key, this.instructor[key]);
      }

      // Submit the form using axios or fetch
      axios
        .post(`/admin/instructors/${this.instructor.id}`, formData)
        .then((response) => {
          // Handle success
          alert('Instructor updated successfully!');
        })
        .catch((error) => {
          // Handle error
          if (error.response && error.response.data.errors) {
            this.errors = Object.values(error.response.data.errors).flat();
          }
        });
    },
    onImageChange(event) {
      const file = event.target.files[0];
      if (file) {
        this.instructor.image = file;

        // Create a preview of the uploaded image
        const reader = new FileReader();
        reader.onload = (e) => {
          this.imagePreview = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    resetForm() {
      if (confirm('Are you sure you want to reset all fields?')) {
        this.instructor = {
          ...this.initialInstructor,
          password: ''
        };
        this.imagePreview = this.initialInstructor.image
          ? `/storage/${this.initialInstructor.image}`
          : '/images/default-avatar.png';
        document.getElementById('image').value = ''; // Clear file input
      }
    },
    cancel() {
      window.location.href = '/admin/instructors';
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
