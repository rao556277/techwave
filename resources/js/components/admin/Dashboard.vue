<template>
  <div class="container">
    <div class="d-flex">
      <div class="tile_count col-md-12">
        <div class="col-md-2 col-sm-4 tile_stats_count">
          <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
          <div class="count">{{ totalUsers }}+</div>
        </div>
        <div class="col-md-2 col-sm-4 tile_stats_count">
          <span class="count_top"><i class="fa fa-clock-o"></i> Total Instructors</span>
          <div class="count">{{ totalInstructors }}+</div>
        </div>
        <div class="col-md-2 col-sm-4 tile_stats_count">
          <span class="count_top"><i class="fa fa-book"></i> Total Courses</span>
          <div class="count green">{{ totalCourses }}+</div>
        </div>
        <div class="col-md-2 col-sm-4 tile_stats_count">
          <span class="count_top"><i class="fa fa-users"></i> Total Students</span>
          <div class="count">{{ totalStudents }}+</div>
        </div>
        <div class="col-md-2 col-sm-4 tile_stats_count">
          <span class="count_top"><i class="fa fa-building"></i> Total Classes</span>
          <div class="count">{{ totalClasses }}+</div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="dashboard_graph">
          <div class="row x_title">
            <div class="col-md-6">
              <h3>Network Activities <small>Graph title sub-title</small></h3>
            </div>
            <div class="col-md-6">
              <div id="reportrange" class="pull-right"
                   style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                <span>{{ dateRange }}</span> <b class="caret"></b>
              </div>
            </div>
          </div>

          <div class="col-md-9 col-sm-9">
            <div id="chart_plot_01" class="demo-placeholder"></div>
          </div>
          <div class="col-md-3 col-sm-3 bg-white">
            <div class="x_title">
              <h2>Top Campaign Performance</h2>
              <div class="clearfix"></div>
            </div>

            <div class="col-md-12 col-sm-12">
              <div>
                <p>Users</p>
                <div class="">
                  <div class="progress progress_sm" :style="{ width: progressUsers + '%' }">
                    <div class="progress-bar bg-green" role="progressbar"
                         :data-transitiongoal="progressUsers"></div>
                  </div>
                </div>
              </div>
              <div>
                <p>Instructors</p>
                <div class="">
                  <div class="progress progress_sm" :style="{ width: progressInstructors + '%' }">
                    <div class="progress-bar bg-green" role="progressbar"
                         :data-transitiongoal="progressInstructors"></div>
                  </div>
                </div>
              </div>
              <div>
                <p>Courses</p>
                <div class="">
                  <div class="progress progress_sm" :style="{ width: progressCourses + '%' }">
                    <div class="progress-bar bg-green" role="progressbar"
                         :data-transitiongoal="progressCourses"></div>
                  </div>
                </div>
              </div>
              <div>
                <p>Students</p>
                <div class="">
                  <div class="progress progress_sm" :style="{ width: progressStudents + '%' }">
                    <div class="progress-bar bg-green" role="progressbar"
                         :data-transitiongoal="progressStudents"></div>
                  </div>
                </div>
              </div>
              <div>
                <p>Classes</p>
                <div class="">
                  <div class="progress progress_sm" :style="{ width: progressClasses + '%' }">
                    <div class="progress-bar bg-green" role="progressbar"
                         :data-transitiongoal="progressClasses"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <br/>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      totalUsers: 0,
      totalInstructors: 0,
      totalCourses: 0,
      totalStudents: 0,
      totalClasses: 0,
      progressUsers: 76,
      progressInstructors: 60,
      progressCourses: 40,
      progressStudents: 50,
      progressClasses: 50,
      dateRange: 'December 30, 2014 - January 28, 2015'
    };
  },
  mounted() {
    this.fetchDashboardData();
  },
  methods: {
    async fetchDashboardData() {
      try {
        const response = await axios.get('/api/dashboard'); // Adjust API endpoint
        const data = response.data;
        this.totalUsers = data.totalUsers;
        this.totalInstructors = data.totalInstructors;
        this.totalCourses = data.totalCourses;
        this.totalStudents = data.totalStudents;
        this.totalClasses = data.totalClasses;
        // Update progress bars if needed
        this.progressUsers = data.progressUsers;
        this.progressInstructors = data.progressInstructors;
        this.progressCourses = data.progressCourses;
        this.progressStudents = data.progressStudents;
        this.progressClasses = data.progressClasses;
        this.dateRange = data.dateRange;
      } catch (error) {
        console.error('Error fetching dashboard data:', error);
      }
    }
  }
};
</script>

<style scoped>
/* Add any additional styling you need here */
.container {
  max-width: 1200px;
  margin: 0 auto;
}
.tile_count {
  display: flex;
  justify-content: space-between;
}
.tile_stats_count {
  text-align: center;
}
</style>
