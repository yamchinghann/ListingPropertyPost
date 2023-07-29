<script setup>
import {useForm, Link} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const form = useForm({
    email: null,
    password: null
})
const login = () => form.post(route('login.store'))
</script>

<template>
    <form @submit.prevent="login">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="email" class="label">E-mail (username)</label>
                <input id="email" type="text" class="input" v-model="form.email"/>
                <InputError :input-error="form.errors.email" />
            </div>
            <div class="mt-4">
                <label for="password" class="label">Password</label>
                <input id="password" type="password" class="input" v-model="form.password"/>
                <InputError :input-error="form.errors.password" />
            </div>
            <div class="mt-4">
                <button class="btn-primary w-full" type="submit">Login</button>

                <div class="mt-2 text-center">
                    <Link :href="route('user-account.create')" class="text-sm text-gray-500">
                        Need an account? Click here
                    </Link>
                </div>
            </div>
        </div>
    </form>
</template>

<style scoped>

</style>
