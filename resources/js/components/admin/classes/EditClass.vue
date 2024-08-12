<template>
  <div class="right_col" role="main" style="min-height: 3829.67px;">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Edit Class</h3>
        </div>

        <div class="title_right">
          <div class="col-md-5 col-sm-5 form-group pull-right top_search">
            <div class="input-group">
              <input
                type="text"
                class="form-control"
                placeholder="Search for..."
                v-model="searchQuery"
              />
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
              <h2>Class Edit Form</h2>
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
              <!-- Display validation errors if any -->
              <div v-if="errors.length" class="alert alert-danger">
                <ul>
                  <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
              </div>

              <!-- Class edit form -->
              <form @submit.prevent="updateClass" enctype="multipart/form-data" class="form-horizontal form-label-left" novalidate>
                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">
                    Class Name <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6">
                    <input
                      type="text"
                      id="name"
                      v-model="form.name"
                      required="required"
                      class="form-control"
                    />
                  </div>
                </div>

                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="description">
                    Description <span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6">
                    <textarea
                      id="description"
                      v-model="form.description"
                      rows="5"
                      required="required"
                      class="form-control"
                    ></textarea>
                  </div>
                </div>

                <div class="ln_solid"></div>
                <div class="item form-group">
                  <div class="col-md-6 col-sm-6 offset-md-3">
                    <a :href="cancelUrl" class="btn btn-primary">Cancel</a>
                    <button type="submit" class="btn btn-success">Update Class</button>
                  </div>
                </div>
              </form>

              <!-- Enrolled Students -->
              <h2 class="mt-4">Enrolled Students</h2>
              <ul class="list-group">
                <li
                  v-for="student in students"
                  :key="student.id"
                  class="list-group-item d-flex justify-content-between align-items-center"
                >
                  {{ student.first_name }} {{ student.last_name }}
                  <div class="btn-group" role="group">
                    <a :href="`/admin/students/${student.id}`" class="btn btn-info btn-sm">View</a>
                    <a :href="`/admin/students/${student.id}/edit`" class="btn btn-warning btn-sm">Edit</a>
                    <button
                      @click="deleteStudent(student.id)"
                      class="btn btn-danger btn-sm"
                    >
                      Delete
                    </button>
                  </div>
                </li>
              </ul>
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
  name: "EditClass",
  data() {
    return {
      form: {
        name: "",
        description: "",
      },
      students: [],
      errors: [],
      searchQuery: "",
      cancelUrl: "", // URL for cancel button
    };
  },
  methods: {
    async updateClass() {
      try {
        const response = await axios.put(`/admin/classes/${this.$route.params.id}`, this.form);
        // Handle successful response (e.g., redirect or show success message)
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.errors = Object.values(error.response.data.errors).flat();
        }
      }
    },
    async deleteStudent(id) {
      if (confirm('Are you sure you want to delete this student?')) {
        try {
          await axios.delete(`/admin/students/${id}`);
          this.students = this.students.filter(student => student.id !== id);
        } catch (error) {
          console.error("Error deleting student:", error);
        }
      }
    },
    search() {
      // Implement search functionality if needed
    },
  },
  async created() {
    const classId = this.$route.params.id;

    try {
      // Fetch class data
      const classResponse = await axios.get(`/admin/classes/${classId}`);
      this.form = classResponse.data;

      // Fetch enrolled students
      const studentsResponse = await axios.get(`/admin/classes/${classId}/students`);
      this.students = studentsResponse.data;

      // Set the cancel URL
      this.cancelUrl = `/admin/classes`;
    } catch (error) {
      console.error("Error fetching class data:", error);
    }
  },
};
</script>

<style scoped>
.right_col {
  /* Add your styles here */
}
</style>
