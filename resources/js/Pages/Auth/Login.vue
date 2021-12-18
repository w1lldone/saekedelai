<template>
  <Head title="Log in" />

  <BreezeGuestLayout>
    <BreezeValidationErrors class="mb-4" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div class="mb-4">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" v-model="form.email" />
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" v-model="form.password" />
      </div>

      <div class="mb-4">
        <div class="form-check">
          <input
            class="form-check-input"
            type="checkbox"
            value=""
            id="rememberMe"
            v-model="form.remember"
          />
          <label class="form-check-label" for="rememberMe"> Remember me </label>
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-between mt-4">
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="underline text-sm text-gray-600 hover:text-gray-900"
        >
          Forgot your password?
        </Link>

        <button
          class="ml-4 btn btn-primary"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Log in
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
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import GoogleButton from "@/Components/GoogleButton.vue";

export default {
  // layout: BreezeGuestLayout,

  components: {
    BreezeGuestLayout,
    BreezeButton,
    BreezeCheckbox,
    BreezeInput,
    BreezeLabel,
    BreezeValidationErrors,
    Head,
    Link,
    GoogleButton,
  },

  props: {
    canResetPassword: Boolean,
    status: String,
  },

  data() {
    return {
      form: this.$inertia.form({
        email: "",
        password: "",
        remember: false,
      }),
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("login"), {
        onFinish: () => this.form.reset("password"),
      });
    },
  },
};
</script>
