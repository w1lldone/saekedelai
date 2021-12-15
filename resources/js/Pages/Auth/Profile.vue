<template>
  <Head title="Profile" />

  <BreezeAuthenticatedLayout>
    <template #header> Ubah Profil </template>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-body p-4">
          <UserEdit :user="user" :status="status" :submit-route="route('profile.update')">
          </UserEdit>
          <!-- END OF COL-8 -->
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Auth.vue";
import BreezeButton from "@/Components/Button.vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import UserEdit from "@/Components/User/Edit.vue";
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

<style lang="scss" scoped></style>
