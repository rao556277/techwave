<template>
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Users <small>Some examples to get you started</small></h3>
        </div>
        <div class="title_right">
          <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
              <input
                type="text"
                class="form-control"
                placeholder="Search for..."
                v-model="searchQuery"
              />
              <span class="input-group-btn">
                <button class="btn btn-secondary" type="button" @click="searchCourses">
                  Go!
                </button>
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 ">
          <div class="x_panel">
            <div class="x_title">
              <h2>All Courses <small>Administrator</small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li>
                  <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li>
                  <a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row">
                <div class="col-sm-12">
                  <div class="card-box table-responsive">
                    <p class="text-muted font-13 m-b-30">
                      DataTables has most features enabled by default, so all you need to do is to call the construction function: <code>$().DataTable();</code>
                    </p>
                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Instructor</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="course in courses" :key="course.id">
                          <td>{{ course.title }}</td>
                          <td>
                            {{ course.instructor ? `${course.instructor.first_name} ${course.instructor.last_name}` : 'No Instructor' }}
                          </td>
                          <td>
                            <router-link
                              :to="{ name: 'course.show', params: { id: course.id } }"
                              class="btn btn-info btn-sm"
                            >
                              View
                            </router-link>
                            <router-link
                              :to="{ name: 'course.edit', params: { id: course.id } }"
                              class="btn btn-warning btn-sm"
                            >
                              Edit
                            </router-link>
                            <button @click="deleteCourse(course.id)" class="btn btn-danger btn-sm">Delete</button>
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
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      courses: [],
      searchQuery: '',
    };
  },
  mounted() {
    this.fetchCourses();
  },
  methods: {
    fetchCourses() {
      axios
        .get('/admin/courses')
        .then((response) => {
          this.courses = response.data.courses;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    deleteCourse(id) {
      if (confirm('Are you sure you want to delete this course?')) {
        axios
          .delete(`/admin/courses/${id}`)
          .then(() => {
            this.fetchCourses(); // Refresh the list after deletion
          })
          .catch((error) => {
            console.error(error);
          });
      }
    },
    searchCourses() {
      // Implement search functionality here
      // You can use the searchQuery data property to filter the courses
    },
  },
};
</script>

<style scoped>
/* Add your scoped styles here */
</style>
