<script setup>
import {useForm, Link} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
})
const register = () => form.post(route('user-account.store'))
</script>

<template>
    <form @submit.prevent="register">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="name" class="label">Your Name</label>
                <input id="name" type="text" class="input" v-model="form.name"/>
                <InputError :input-error="form.errors.name" />
            </div>
            <div class="mt-4">
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
                <label for="password_confirmation" class="label">Confirm Password</label>
                <input id="password_confirmation" type="password" class="input" v-model="form.password_confirmation"/>
                <InputError :input-error="form.errors.password_confirmation" />
            </div>
            <div class="mt-4">
                <button class="btn-primary w-full" type="submit">Create Register</button>

                <div class="mt-2 text-center">
                    <Link :href="route('login')" class="text-sm text-gray-500">
                        Already have an account? Click here
                    </Link>
                </div>
            </div>
        </div>
    </form>
</template>

<style scoped>

</style>
