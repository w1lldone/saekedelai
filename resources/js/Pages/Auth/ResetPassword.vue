<template>
    <Head title="Reset Password" />

    <BreezeValidationErrors class="mb-4" />

    <form @submit.prevent="submit">
        <div>
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" v-model="form.email" name="email">
        </div>

        <div class="mt-4">
            <label for="password" class="form-password">New Password</label>
            <input type="password" class="form-control" name="password" id="password" v-model="form.password">
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="form-label">Password Confirmation</label>
            <input type="password" class="form-control" v-model="form.password_confirmation">
        </div>

        <div class="d-flex align-items-center justify-content-end mt-4">
            <button class="btn btn-primary" :class="{ 'disabled': form.processing }" :disabled="form.processing">
                Reset Password
            </button>
        </div>
    </form>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    layout: BreezeGuestLayout,

    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
    },

    props: {
        email: String,
        token: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                token: this.token,
                email: this.email,
                password: '',
                password_confirmation: '',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.update'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>
