// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
// Import your components here
import Dashboard from '../components/admin/Dashboard.vue';
import UserList from '../components/admin/UserList.vue';
import UserCreate from '../components/admin/UserCreate.vue';
import UserEdit from '../components/admin/UserEdit.vue';
import UserShow from '../components/admin/UserShow.vue';
import StudentList from '../components/admin/StudentList.vue';
import StudentCreate from '../components/admin/StudentCreate.vue';
import StudentEdit from '../components/admin/StudentEdit.vue';
import StudentShow from '../components/admin/StudentShow.vue';
import CourseList from '../components/admin/CourseList.vue';
import CourseCreate from '../components/admin/CourseCreate.vue';
import CourseEdit from '../components/admin/CourseEdit.vue';
import CourseShow from '../components/admin/CourseShow.vue';
import InstructorList from '../components/admin/InstructorList.vue';
import InstructorCreate from '../components/admin/InstructorCreate.vue';
import InstructorEdit from '../components/admin/InstructorEdit.vue';
import InstructorShow from '../components/admin/InstructorShow.vue';

const routes = [
  {
    path: '/',
    name: 'Login',
    component: Login,
    meta: { guest: true }
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: { guest: true }
  },
  {
    path: '/forgot-password',
    name: 'ForgotPassword',
    component: ForgotPassword,
    meta: { guest: true }
  },
  {
    path: '/reset-password/:token',
    name: 'ResetPassword',
    component: ResetPassword,
    meta: { guest: true }
  },
  {
    name: 'AdminDashboard',
    path: '/admin/dashboard',
    component: Dashboard,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/users',
    name: 'UserList',
    component: UserList,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/users/create',
    name: 'UserCreate',
    component: UserCreate,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/users/edit/:id',
    name: 'UserEdit',
    component: UserEdit,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/users/show/:id',
    name: 'UserShow',
    component: UserShow,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/students',
    name: 'StudentList',
    component: StudentList,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/students/create',
    name: 'StudentCreate',
    component: StudentCreate,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/students/edit/:id',
    name: 'StudentEdit',
    component: StudentEdit,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/students/show/:id',
    name: 'StudentShow',
    component: StudentShow,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/courses',
    name: 'CourseList',
    component: CourseList,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/courses/create',
    name: 'CourseCreate',
    component: CourseCreate,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/courses/edit/:id',
    name: 'CourseEdit',
    component: CourseEdit,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/courses/show/:id',
    name: 'CourseShow',
    component: CourseShow,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/instructors',
    name: 'InstructorList',
    component: InstructorList,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/instructors/create',
    name: 'InstructorCreate',
    component: InstructorCreate,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/instructors/edit/:id',
    name: 'InstructorEdit',
    component: InstructorEdit,
    meta: { requiresAuth: true }
  },
  {
    path: '/admin/instructors/show/:id',
    name: 'InstructorShow',
    component: InstructorShow,
    meta: { requiresAuth: true }
  }

];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
