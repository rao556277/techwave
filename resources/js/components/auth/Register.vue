<template>
  <div class="container" style="margin-top: 70px;">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Register') }}</div>

          <div class="card-body">
            <!-- Display validation errors if any -->
            <div v-if="errors.length" class="alert alert-danger">
              <ul>
                <li v-for="error in errors" :key="error">{{ error }}</li>
              </ul>
            </div>

            <!-- Registration form -->
            <form @submit.prevent="submitForm">
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                <div class="col-md-6">
                  <input
                    id="name"
                    type="text"
                    class="form-control"
                    v-model="form.name"
                    :class="{ 'is-invalid': errors.name }"
                    required
                    autofocus
                  />

                  <span v-if="errors.name" class="invalid-feedback" role="alert">
                    <strong>{{ errors.name[0] }}</strong>
                  </span>
                </div>
              </div>

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    v-model="form.email"
                    :class="{ 'is-invalid': errors.email }"
                    required
                  />

                  <span v-if="errors.email" class="invalid-feedback" role="alert">
                    <strong>{{ errors.email[0] }}</strong>
                  </span>
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                  <input
                    id="password"
                    type="password"
                    class="form-control"
                    v-model="form.password"
                    :class="{ 'is-invalid': errors.password }"
                    required
                  />

                  <span v-if="errors.password" class="invalid-feedback" role="alert">
                    <strong>{{ errors.password[0] }}</strong>
                  </span>
                </div>
              </div>

              <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                <div class="col-md-6">
                  <input
                    id="password-confirm"
                    type="password"
                    class="form-control"
                    v-model="form.password_confirmation"
                    required
                  />
                </div>
              </div>

              <div class="form-group row">
                <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                <div class="col-md-6">
                  <select
                    id="role"
                    class="form-control"
                    v-model="form.role"
                    :class="{ 'is-invalid': errors.role }"
                    required
                  >
                    <option value="Admin">Admin</option>
                    <option value="Instructor">Instructor</option>
                    <option value="Student">Student</option>
                  </select>

                  <span v-if="errors.role" class="invalid-feedback" role="alert">
                    <strong>{{ errors.role[0] }}</strong>
                  </span>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        role: 'Student' // default value
      },
      errors: {}
    };
  },
  methods: {
    async submitForm() {
      // Clear previous errors
      this.errors = {};

      try {
        // Send request to the server
        const response = await fetch('/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(this.form)
        });

        const data = await response.json();

        if (!response.ok) {
          // Handle validation errors
          this.errors = data.errors || {};
        } else {
          // Handle success
          alert('Registration successful!');
          this.$router.push('/login'); // Redirect to login or another page
        }
      } catch (error) {
        console.error('Error:', error);
      }
    }
  }
};
</script>

<style scoped>
/* Add any additional styling here */
.invalid-feedback {
  display: block;
}
</style>
