<template>
  <Head title="Register" />

  <BreezeValidationErrors class="mb-4" />
  <BreezeGuestLayout>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label for="name" class="form-label">Name</label>
        <input type="text" required class="form-control" v-model="form.name" />
      </div>

      <div class="mb-4">
        <label for="email" class="form-label">Email</label>
        <input
          type="email"
          required
          class="form-control"
          v-model="form.email"
        />
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">New Password</label>
        <input
          type="password"
          required
          class="form-control"
          v-model="form.password"
        />
      </div>

      <div class="mb-4">
        <label for="password_confirmation" class="form-label"
          >Password Confirmation</label
        >
        <input
          type="password"
          required
          class="form-control"
          v-model="form.password_confirmation"
        />
      </div>

      <div class="d-flex align-items-center justify-content-between mt-4">
        <Link :href="route('login')" class="underline text-sm">
          Already registered?
        </Link>

        <button
          type="submit"
          class="btn btn-primary"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Register
        </button>
      </div>
    </form>
    <template v-slot:outside>
      <div class="row justify-content-center">
        <div class="col-md-3 text-center">
          <GoogleButton></GoogleButton>
        </div>
      </div>
    </template>
  </BreezeGuestLayout>
</template>

<script>
import BreezeButton from "@/Components/Button.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import GoogleButton from "@/Components/GoogleButton.vue";

export default {
  components: {
    BreezeGuestLayout,
    BreezeButton,
    BreezeInput,
    BreezeLabel,
    BreezeValidationErrors,
    Head,
    Link,
    GoogleButton,
  },

  data() {
    return {
      form: this.$inertia.form({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        terms: false,
      }),
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("register"), {
        onFinish: () => this.form.reset("password", "password_confirmation"),
      });
    },
  },
};
</script>
