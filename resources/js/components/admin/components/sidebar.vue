<template>
  <div class="col-md-3 left_col">
    <div class="left_col scroll-view">
      <div class="clearfix"></div>

      <!-- Menu Profile Quick Info -->
      <div class="profile clearfix">
        <div class="profile_pic">
          <img src="@/assets/images/img.jpg" alt="..." class="img-circle profile_img" />
        </div>
        <div class="profile_info">
          <h2 class="pt-2">{{ userName }}</h2>
        </div>
      </div>
      <!-- /Menu Profile Quick Info -->

      <br />

      <!-- Sidebar Menu -->
      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
          <h3>General</h3>
          <ul class="nav side-menu">
            <li>
              <router-link :to="{ name: 'admin.dashboard' }">
                <i class="fa fa-home"></i> Home
              </router-link>
            </li>
            <li>
              <a @click.prevent="toggleMenu('courses')">
                <i class="fa fa-edit"></i> Courses
                <span class="fa fa-chevron-down"></span>
              </a>
              <ul v-show="menus.courses" class="nav child_menu">
                <li>
                  <router-link :to="{ name: 'admin.courses.index' }">All Courses</router-link>
                </li>
                <li>
                  <router-link :to="{ name: 'admin.courses.create' }">Create New Course</router-link>
                </li>
              </ul>
            </li>
            <li>
              <a @click.prevent="toggleMenu('students')">
                <i class="fa fa-edit"></i> Students
                <span class="fa fa-chevron-down"></span>
              </a>
              <ul v-show="menus.students" class="nav child_menu">
                <li>
                  <router-link :to="{ name: 'admin.students.index' }">All Students</router-link>
                </li>
                <li>
                  <router-link :to="{ name: 'admin.students.create' }">Create New Student</router-link>
                </li>
              </ul>
            </li>
            <li>
              <a @click.prevent="toggleMenu('instructors')">
                <i class="fa fa-desktop"></i> Instructors
                <span class="fa fa-chevron-down"></span>
              </a>
              <ul v-show="menus.instructors" class="nav child_menu">
                <li>
                  <router-link :to="{ name: 'admin.instructors.index' }">All Instructors</router-link>
                </li>
                <li>
                  <router-link :to="{ name: 'admin.instructors.create' }">Create Instructor</router-link>
                </li>
              </ul>
            </li>
            <li>
              <a @click.prevent="toggleMenu('classes')">
                <i class="fa fa-table"></i> Classes
                <span class="fa fa-chevron-down"></span>
              </a>
              <ul v-show="menus.classes" class="nav child_menu">
                <li>
                  <router-link :to="{ name: 'admin.classes.index' }">All Classes</router-link>
                </li>
                <li>
                  <router-link :to="{ name: 'admin.classes.create' }">Create Class</router-link>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <div class="menu_section">
          <h3>Live On</h3>
          <ul class="nav side-menu">
            <li>
              <router-link :to="{ name: 'admin.profile.show' }">
                <i class="fa fa-laptop"></i> Profile
                <span class="label label-success pull-right">Coming Soon</span>
              </router-link>
            </li>
          </ul>
        </div>
      </div>
      <!-- /Sidebar Menu -->

      <!-- Menu Footer Buttons -->
      <div class="sidebar-footer hidden-small">
        <a @click.prevent="openSettings" data-toggle="tooltip" data-placement="top" title="Settings">
          <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </a>
        <a @click.prevent="goFullScreen" data-toggle="tooltip" data-placement="top" title="FullScreen">
          <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
        </a>
        <a @click.prevent="lockScreen" data-toggle="tooltip" data-placement="top" title="Lock">
          <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
        </a>
        <a @click.prevent="logout" data-toggle="tooltip" data-placement="top" title="Logout">
          <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
      </div>
      <!-- /Menu Footer Buttons -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      userName: "", // Will be set when fetching user data
      menus: {
        courses: false,
        students: false,
        instructors: false,
        classes: false,
      },
    };
  },
  methods: {
    toggleMenu(menu) {
      this.menus[menu] = !this.menus[menu];
    },
    openSettings() {
      console.log("Settings clicked");
      // Implement settings logic
    },
    goFullScreen() {
      console.log("FullScreen clicked");
      // Implement full screen logic
    },
    lockScreen() {
      console.log("Lock clicked");
      // Implement lock screen logic
    },
    logout() {
      console.log("Logout clicked");
      // Implement logout logic
    },
  },
  mounted() {
    // Fetch user data (e.g., from an API or Vuex store) and set the userName
    this.userName = "User Name"; // Replace with dynamic data
  },
};
</script>

<style scoped>
/* Add your styles here */
</style>
