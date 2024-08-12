<template>
<meta name="csrf-token" content="{{ csrf_token() }}">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Reset Password') }}</div>

          <div class="card-body">
            <!-- Display validation errors if any -->
            <div v-if="errors.length" class="alert alert-danger">
              <ul>
                <li v-for="error in errors" :key="error">{{ error }}</li>
              </ul>
            </div>

            <!-- Password reset form -->
            <form @submit.prevent="submitForm">
              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                  <input 
                    id="email" 
                    type="email" 
                    class="form-control"
                    v-model="email"
                    :class="{ 'is-invalid': emailError }"
                    required 
                    autofocus
                  >

                  <span v-if="emailError" class="invalid-feedback" role="alert">
                    <strong>{{ emailError }}</strong>
                  </span>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Send Password Reset Link') }}
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
      email: '',
      errors: [],
      emailError: ''
    };
  },
  methods: {
    async submitForm() {
      // Clear previous errors
      this.errors = [];
      this.emailError = '';

      try {
        // Send request to the server
        const response = await fetch('/password/email', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ email: this.email })
        });

        if (!response.ok) {
          const data = await response.json();
          if (data.errors) {
            this.errors = Object.values(data.errors).flat();
          } else if (data.message) {
            this.emailError = data.message;
          }
        } else {
          // Handle success
          alert('Password reset link sent!');
          this.email = '';
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
