<template>
  <div class="right_col" role="main" style="min-height: 3829.67px;">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>All Classes</h3>
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
              <h2>Class List <small>Overview of all classes</small></h2>
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
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <a href="/admin/classes/create" class="btn btn-primary mb-3">Create New Class</a>
                  <!-- Display validation errors if any -->
                  <div v-if="errors.length" class="alert alert-danger">
                    <ul>
                      <li v-for="error in errors" :key="error">{{ error }}</li>
                    </ul>
                  </div>

                  <!-- Classes table -->
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="class in classes" :key="class.id">
                        <td>{{ class.name }}</td>
                        <td>{{ class.description }}</td>
                        <td>
                          <a :href="`/admin/classes/${class.id}`" class="btn btn-info btn-sm">View</a>
                          <a :href="`/admin/classes/${class.id}/edit`" class="btn btn-warning btn-sm">Edit</a>
                          <button
                            @click="deleteClass(class.id)"
                            class="btn btn-danger btn-sm"
                          >
                            Delete
                          </button>
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
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "ClassList",
  data() {
    return {
      classes: [],
      errors: [],
      searchQuery: "",
    };
  },
  methods: {
    async fetchClasses() {
      try {
        const response = await axios.get('/admin/classes', {
          params: { search: this.searchQuery }
        });
        this.classes = response.data;
      } catch (error) {
        console.error("Error fetching classes:", error);
      }
    },
    async deleteClass(id) {
      if (confirm('Are you sure you want to delete this class?')) {
        try {
          await axios.delete(`/admin/classes/${id}`);
          this.classes = this.classes.filter(classItem => classItem.id !== id);
        } catch (error) {
          console.error("Error deleting class:", error);
        }
      }
    },
    search() {
      this.fetchClasses();
    },
  },
  created() {
    this.fetchClasses();
  },
};
</script>

<style scoped>
.right_col {
  /* Add your styles here */
}
</style>
