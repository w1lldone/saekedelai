<template>
  <Head title="User Detail" />
  <AuthenticatedLayout>
    <template #header>
      <Link class="text-primary" :href="route('user.index')">Pengguna</Link>
      <i class="fa fa-chevron-right mx-2"></i>
      <Link class="text-primary" :href="route('user.show', this.user.id)"
        >Detail pengguna</Link
      >
      <i class="fa fa-chevron-right mx-2"></i>Edit
    </template>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <NavEdit :user="user" class="mb-3"></NavEdit>
        <div class="card card-body p-4">
          <EditUserBasic
            :user="user"
            :submit-route="route('user.update', user.id)"
            @success="isEditing = false"
          ></EditUserBasic>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/Auth.vue";
import EditUserBasic from "@/Components/User/Edit.vue";
import NavEdit from "@/Components/User/NavEdit.vue";
import Status from "@/Components/Status.vue";

export default {
  components: {
    AuthenticatedLayout,
    Head,
    Link,
    EditUserBasic,
    NavEdit,
    Status,
  },
  props: {
    user: Object,
  },
};
</script>

<style>
</style>
