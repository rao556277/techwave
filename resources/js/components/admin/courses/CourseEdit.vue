<template>
  <div class="container">
    <h1>Edit Course</h1>

    <form @submit.prevent="submitForm">
      <div class="form-group">
        <label for="title">Title</label>
        <input
          type="text"
          v-model="course.title"
          class="form-control"
          required
        />
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea
          v-model="course.description"
          class="form-control"
          rows="5"
          required
        ></textarea>
      </div>

      <div class="form-group">
        <label for="instructor_id">Instructor</label>
        <select v-model="course.instructor_id" class="form-control" required>
          <option
            v-for="instructor in instructors"
            :key="instructor.id"
            :value="instructor.id"
          >
            {{ instructor.first_name }} {{ instructor.last_name }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="category">Category</label>
        <input
          type="text"
          v-model="course.category"
          class="form-control"
          required
        />
      </div>

      <button type="submit" class="btn btn-primary">Update Course</button>
      <router-link :to="{ name: 'courses.index' }" class="btn btn-secondary">
        Back to List
      </router-link>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default {
  setup() {
    const course = ref({
      title: '',
      description: '',
      instructor_id: '',
      category: '',
    });

    const instructors = ref([]);
    const route = useRoute();
    const router = useRouter();

    onMounted(async () => {
      try {
        const { data } = await axios.get(`/admin/courses/${route.params.id}/edit`);
        course.value = data.course;
        instructors.value = data.instructors;
      } catch (error) {
        console.error(error);
      }
    });

    const submitForm = async () => {
      try {
        await axios.put(`/admin/courses/${route.params.id}`, course.value);
        router.push({ name: 'courses.index' });
      } catch (error) {
        console.error(error);
      }
    };

    return {
      course,
      instructors,
      submitForm,
    };
  },
};
</script>

<style scoped>
.container {
  margin-top: 30px;
}
</style>
