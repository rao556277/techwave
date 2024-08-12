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
                        <input type="hidden" name="token" :value="token">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" v-model="email" :class="{ 'is-invalid': emailError }" required autofocus />

                                <span v-if="emailError" class="invalid-feedback" role="alert">
                                    <strong>{{ emailError }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" v-model="password" :class="{ 'is-invalid': passwordError }" required />

                                <span v-if="passwordError" class="invalid-feedback" role="alert">
                                    <strong>{{ passwordError }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" v-model="passwordConfirmation" required />
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
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
            token: this.$route.query.token || '',
            email: '',
            password: '',
            passwordConfirmation: '',
            errors: [],
            emailError: '',
            passwordError: ''
        };
    },
    methods: {
        async submitForm() {
            // Clear previous errors
            this.errors = [];
            this.emailError = '';
            this.passwordError = '';

            try {
                // Send request to the server
                const response = await fetch('/password/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        token: this.token,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.passwordConfirmation
                    })
                });

                if (!response.ok) {
                    const data = await response.json();
                    if (data.errors) {
                        // Handle validation errors
                        this.errors = Object.values(data.errors).flat();
                        this.emailError = data.errors.email ? data.errors.email[0] : '';
                        this.passwordError = data.errors.password ? data.errors.password[0] : '';
                    }
                } else {
                    // Handle success
                    alert('Password has been reset successfully!');
                    this.email = '';
                    this.password = '';
                    this.passwordConfirmation = '';
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
