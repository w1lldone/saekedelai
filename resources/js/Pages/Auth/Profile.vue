<template>
  <Head title="Profile" />

  <BreezeAuthenticatedLayout>
    <template #header> Ubah Profil </template>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <ProfileNav class="mb-4"></ProfileNav>

        <div class="card card-body p-4">
          <UserEdit
            :user="user"
            :status="status"
            :submit-route="route('profile.update')"
          >
          </UserEdit>
          <!-- END OF COL-8 -->
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Auth.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import UserEdit from "@/Components/User/Edit.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ProfileNav from "@/Components/ProfileNav.vue";

export default {
  props: {
    user: Object,
    status: String,
  },
  components: {
    BreezeAuthenticatedLayout,
    BreezeValidationErrors,
    Head,
    UserEdit,
    ProfileNav,
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
