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

          <EditAddress
                :address="user.address"
                :submit-url="route('user.address.update', user.id)"
              ></EditAddress>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/Auth.vue";
import EditAddress from "@/Components/User/EditAddress.vue";
import NavEdit from '@/Components/User/NavEdit.vue';
import Status from '@/Components/Status.vue';

export default {
  components: {
    AuthenticatedLayout,
    Head,
    Link,
    EditAddress,
    NavEdit,
    Status
  },
  props: {
    user: Object,
    status: String,
    roles: Array
  },
};
</script>

<style>
</style>
