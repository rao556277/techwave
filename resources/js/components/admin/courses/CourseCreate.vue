<template>
  <div class="right_col" role="main" style="min-height: 3829.67px;">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Create New Course</h3>
        </div>

        <div class="title_right">
          <div class="col-md-5 col-sm-5 form-group pull-right top_search">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for..." v-model="searchQuery">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button" @click="search">Go!</button>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Course Creation <small>different form elements</small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-wrench"></i>
                  </a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a class="dropdown-item" href="#">Settings 1</a></li>
                    <li><a class="dropdown-item" href="#">Settings 2</a></li>
                  </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br>
              <div v-if="errors.length">
                <div class="alert alert-danger">
                  <ul>
                    <li v-for="error in errors" :key="error">{{ error }}</li>
                  </ul>
                </div>
              </div>

              <form @submit.prevent="submitForm" enctype="multipart/form-data" class="form-horizontal form-label-left" novalidate>
                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="title">Course Title
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6">
                    <input type="text" id="title" v-model="course.title" required class="form-control">
                  </div>
                </div>

                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="description">Description
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6">
                    <textarea id="description" v-model="course.description" rows="5" required class="form-control"></textarea>
                  </div>
                </div>

                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="category">Category
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6">
                    <input type="text" id="category" v-model="course.category" required class="form-control">
                  </div>
                </div>

                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="instructor_id">Instructor
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6">
                    <select id="instructor_id" v-model="course.instructor_id" required class="form-select form-control">
                      <option value="">Select Instructor</option>
                      <option v-for="instructor in instructors" :key="instructor.id" :value="instructor.id">
                        {{ instructor.first_name }} {{ instructor.last_name }}
                      </option>
                    </select>
                  </div>
                </div>

                <div class="ln_solid"></div>
                <div class="item form-group">
                  <div class="col-md-6 col-sm-6 offset-md-3">
                    <button class="btn btn-primary" type="button" @click="cancel">Cancel</button>
                    <button class="btn btn-primary" type="reset" @click="resetForm">Reset</button>
                    <button type="submit" class="btn btn-success">Create Course</button>
                  </div>
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

export default {
  data() {
    return {
      course: {
        title: '',
        description: '',
        category: '',
        instructor_id: ''
      },
      instructors: [],
      errors: [],
      searchQuery: ''
    };
  },
  methods: {
    async fetchInstructors() {
      try {
        const response = await axios.get('/admin/instructors');
        this.instructors = response.data;
      } catch (error) {
        console.error('Error fetching instructors:', error);
      }
    },
    async submitForm() {
      try {
        await axios.post('/admin/courses', this.course);
        this.$router.push('/admin/courses');
      } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
          this.errors = Object.values(error.response.data.errors).flat();
        } else {
          console.error('Error creating course:', error);
        }
      }
    },
    resetForm() {
      this.course = {
        title: '',
        description: '',
        category: '',
        instructor_id: ''
      };
      this.errors = [];
    },
    cancel() {
      this.$router.push('/admin/courses');
    },
    search() {
      // Implement search functionality if needed
    }
  },
  created() {
    this.fetchInstructors();
  }
};
</script>

<style scoped>
.right_col {
  /* Add your styles here */
}
</style>
