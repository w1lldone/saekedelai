<template>
  <Head title="Profile" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Ubah Profil
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
        <BreezeValidationErrors class="mb-4" />

        <div v-if="status">
          <div
            class="flex items-center bg-green-100 rounded-lg p-4 mb-4 text-sm text-green-700"
            role="alert"
          >
            <i class="fa fa-info-circle"></i>
            <div class="pl-2">
              <span class="font-medium">Success!</span> {{ status }}
            </div>
          </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <UserEdit :user="user" :submit-route="route('profile.update')">
            </UserEdit>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeButton from "@/Components/Button.vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import UserEdit from '@/Components/User/Edit.vue';
import { Head } from "@inertiajs/inertia-vue3";

export default {
  props: {
    user: Object,
    status: String,
  },
  components: {
    BreezeAuthenticatedLayout,
    BreezeButton,
    BreezeCheckbox,
    BreezeInput,
    BreezeLabel,
    BreezeValidationErrors,
    Head,
    UserEdit,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: this.user.name,
        email: this.user.email,
      }),
    };
  },
  methods: {
    submit() {
      this.form.put(this.route("profile.update"));
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
