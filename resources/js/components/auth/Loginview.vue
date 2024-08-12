<template>
<div class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form col-md-4 m-auto">
                <section class="login_content">
                    <form @submit.prevent="submitForm">
                        <h1>Login Form</h1>
                        <div>
                            <input type="email" v-model="form.email" class="form-control" placeholder="Email" required />
                        </div>
                        <div>
                            <input type="password" v-model="form.password" class="form-control" placeholder="Password" required />
                        </div>
                        <div>
                            <button class="btn btn-default submit" :disabled="loading">
                                Log in
                            </button>
                            <a class="reset_pass" href="/password/reset">Lost your password?</a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">
                            <p class="change_link">
                                New to site?
                                <a href="/register" class="to_register">Create Account</a>
                            </p>
                            <div class="clearfix"></div>
                            <br />
                            <div>
                                <h1><i class="fa fa-paw"></i> Techwave</h1>
                                <p>©2024 All Rights Reserved. Techwave!. Privacy and Terms</p>
                            </div>
                        </div>
                    </form>
                    <div v-if="error" class="alert alert-danger">
                        {{ error }}
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'LoginForm',
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            loading: false,
            error: null,
        };
    },
    methods: {
        async submitForm() {
            this.loading = true;
            this.error = null;

            try {
                const response = await axios.post('http://localhost:8000/api/login', this.form);
                window.location.href = response.data.redirect;
            } catch (error) {
                this.error = error.response ? error.response.data.message : 'An error occurred. Please try again.';
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.login {
    /* Add your styles here */
}

.alert {
    margin-top: 20px;
    color: red;
}
</style>
