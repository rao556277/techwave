<template>
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Add New Instructor <small>Fill in the details below</small></h3>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Instructor Form <small>Administrator</small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <form @submit.prevent="submitForm" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="first_name">First Name</label>
                  <input v-model="form.first_name" type="text" class="form-control" required>
                  <span v-if="errors.first_name">{{ errors.first_name[0] }}</span>
                </div>

                <div class="form-group">
                  <label for="last_name">Last Name</label>
                  <input v-model="form.last_name" type="text" class="form-control" required>
                  <span v-if="errors.last_name">{{ errors.last_name[0] }}</span>
                </div>

                <div class="form-group">
                  <label for="contact">Contact</label>
                  <input v-model="form.contact" type="text" class="form-control" required>
                  <span v-if="errors.contact">{{ errors.contact[0] }}</span>
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input v-model="form.email" type="email" class="form-control" required>
                  <span v-if="errors.email">{{ errors.email[0] }}</span>
                </div>

                <div class="form-group">
                  <label for="password">Password</label>
                  <input v-model="form.password" type="password" class="form-control" required>
                  <span v-if="errors.password">{{ errors.password[0] }}</span>
                </div>

                <div class="form-group">
                  <label for="cnic">CNIC</label>
                  <input v-model="form.cnic" type="text" class="form-control">
                  <span v-if="errors.cnic">{{ errors.cnic[0] }}</span>
                </div>

                <div class="form-group">
                  <label for="bio">Bio</label>
                  <textarea v-model="form.bio" class="form-control" rows="3"></textarea>
                  <span v-if="errors.bio">{{ errors.bio[0] }}</span>
                </div>

                <div class="form-group">
                  <label for="image">Image</label>
                  <input @change="handleFileUpload" type="file" class="form-control">
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Add Instructor</button>
                  <router-link :to="{ name: 'instructors.index' }" class="btn btn-secondary">Cancel</router-link>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

export default {
  setup() {
    const router = useRouter();
    const form = ref({
      first_name: '',
      last_name: '',
      contact: '',
      email: '',
      password: '',
      cnic: '',
      bio: '',
      image: null,
    });

    const errors = ref({});

    const handleFileUpload = (event) => {
      form.value.image = event.target.files[0];
    };

    const submitForm = () => {
      const formData = new FormData();
      Object.keys(form.value).forEach(key => {
        formData.append(key, form.value[key]);
      });

      axios.post('/admin/instructors', formData)
        .then(() => {
          router.push({ name: 'instructors.index' });
        })
        .catch(error => {
          if (error.response && error.response.data.errors) {
            errors.value = error.response.data.errors;
          }
        });
    };

    return {
      form,
      errors,
      handleFileUpload,
      submitForm,
    };
  }
};
</script>

<style scoped>
/* Add any additional styles here */
</style>
