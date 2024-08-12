<template>
  <div class="right_col" role="main">
    <div>
      <div class="page-title">
        <div class="title_left">
          <h3>Instructors <small>List of all instructors</small></h3>
        </div>
        <div class="title_right">
          <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for..." v-model="searchQuery" @input="filterInstructors">
              <span class="input-group-btn">
                <button class="btn btn-secondary" type="button" @click="filterInstructors">Go!</button>
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
              <h2>All Instructors<small>Administrator</small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div v-if="successMessage" class="alert alert-success">
                {{ successMessage }}
              </div>

              <div class="row mb-3">
                <div class="col-md-12">
                  <a href="/admin/instructors/create" class="btn btn-primary">Add New Instructor</a>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="card-box table-responsive">
                    <table class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Image</th>
                          <th>Email</th>
                          <th>Contact</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="instructor in filteredInstructors" :key="instructor.id">
                          <td>{{ instructor.id }}</td>
                          <td>{{ instructor.first_name }} {{ instructor.last_name }}</td>
                          <td>
                            <img :src="instructor.image ? '/storage/' + instructor.image : '/images/default.png'"
                                 class="rounded-circle justify-content-center"
                                 alt="Instructor Image"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                          </td>
                          <td>{{ instructor.email }}</td>
                          <td>{{ instructor.contact }}</td>
                          <td>
                            <a :href="`/admin/instructors/${instructor.id}`" class="btn btn-info btn-sm">View</a>
                            <a :href="`/admin/instructors/${instructor.id}/edit`" class="btn btn-warning btn-sm">Edit</a>
                            <button @click="deleteInstructor(instructor.id)" class="btn btn-danger btn-sm">Delete</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <pagination :data="pagination" @pagination-change-page="getInstructors"></pagination>
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
import Pagination from 'vue-pagination-2';

export default {
  components: {
    Pagination
  },
  data() {
    return {
      instructors: [],
      filteredInstructors: [],
      searchQuery: '',
      successMessage: '',
      pagination: {}
    };
  },
  methods: {
    getInstructors(page = 1) {
      axios.get(`/api/instructors?page=${page}`).then(response => {
        this.instructors = response.data.data;
        this.filteredInstructors = this.instructors;
        this.pagination = response.data.meta.pagination;
      });
    },
    deleteInstructor(id) {
      if (confirm('Are you sure you want to delete this instructor?')) {
        axios.delete(`/admin/instructors/${id}`).then(response => {
          this.successMessage = response.data.message;
          this.getInstructors();
        });
      }
    },
    filterInstructors() {
      this.filteredInstructors = this.instructors.filter(instructor => {
        return (
          instructor.first_name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          instructor.last_name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          instructor.email.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          instructor.contact.includes(this.searchQuery)
        );
      });
    }
  },
  mounted() {
    this.getInstructors();
  }
};
</script>

<style scoped>
.table-responsive {
  overflow-x: auto;
}

.rounded-circle {
  border-radius: 50% !important;
}

.justify-content-center {
  display: flex;
  justify-content: center;
  align-items: center;
}

.alert {
  margin-bottom: 20px;
}

.btn-sm {
  margin-right: 5px;
}
</style>
