<template>
    <div>
        <div class="modal fade" id="loginModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="p-3">
                        <ul class="list-group" v-if="errors.length > 0">
                            <li class="list-group-item alert alert-danger" v-for="error in errors" :key="errors.indexOf(error)">
                                {{ error }}
                            </li>
                        </ul>
                        <div class="form-group">
                            <h5>Login</h5>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" class="form-control" v-model="email" aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" name="password" v-model="password" placeholder="Password">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" v-model="remember">
                            <label class="form-check-label" for="exampleCheck1">Remember me</label>
                        </div>
                        <button v-on:click.prevent="attemptLogin" type="submit" class="btn btn-primary" :disabled="!isValidLoginForm" >Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                email: "",
                password: "",
                remember: true,
                loading: false,
                formData: {},
                errors: []
            }
        },

        methods: {
            validateEmail() 
            {
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email))
                {
                    return (true)
                }
                    return (false)
            },

            attemptLogin() {
                this.errors = []

                this.loading = true

                this.formData = {
                    email: this.email,
                    password: this.password,
                    remember: this.remember
                }
                
                axios.post('/login', this.formData)
                .then(response => { 
                    location.reload();
                })
                .catch(error => {
                    this.loading = false
                    if(error.response.status == 422) {
                        this.errors.push('Email or Password is wrong.');
                    } else {
                        this.errors.push('Refresh and try again.')
                    }
                });

            }
        },

        computed: {
            isValidLoginForm() {
                return this.validateEmail && this.password && !this.loading
            }
        },
    }
</script>
