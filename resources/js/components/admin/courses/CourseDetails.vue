<template>
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Course Details <small>Details of the selected course</small></h3>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Course ID: {{ course.id }}<small>Details</small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row mb-3">
                <div class="col-md-12">
                  <router-link :to="{ name: 'course.edit', params: { id: course.id } }" class="btn btn-warning">Edit
                    Course</router-link>
                  <button @click="deleteCourse(course.id)" class="btn btn-danger">Delete Course</button>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Course Information</h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <ul class="list-unstyled">
                        <li><strong>Title:</strong> {{ course.title }}</li>
                        <li><strong>Description:</strong> {{ course.description }}</li>
                        <li>
                          <strong>Instructor:</strong> {{ course.instructor ? `${course.instructor.first_name} ${course.instructor.last_name}` : 'No Instructor' }}
                        </li>
                        <li><strong>Created At:</strong> {{ formatDate(course.created_at) }}</li>
                        <li><strong>Updated At:</strong> {{ formatDate(course.updated_at) }}</li>
                      </ul>
                    </div>
                  </div>
                </div>

                <!-- Add more details or sections here if needed -->
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
import { ref } from 'vue';

export default {
  props: {
    courseId: {
      type: Number,
      required: true
    }
  },
  setup(props) {
    const course = ref({});

    const fetchCourseDetails = () => {
      axios
        .get(`/admin/courses/${props.courseId}`)
        .then((response) => {
          course.value = response.data.course;
        })
        .catch((error) => {
          console.error(error);
        });
    };

    const deleteCourse = (id) => {
      if (confirm('Are you sure you want to delete this course?')) {
        axios
          .delete(`/admin/courses/${id}`)
          .then(() => {
            // Redirect or show a success message
          })
          .catch((error) => {
            console.error(error);
          });
      }
    };

    const formatDate = (date) => {
      return new Date(date).toLocaleDateString('en-US', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
      });
    };

    fetchCourseDetails();

    return {
      course,
      deleteCourse,
      formatDate,
    };
  }
};
</script>

<style scoped>
/* Add your scoped styles here */
</style>
