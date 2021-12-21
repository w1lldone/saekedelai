<template>
  <Head title="Users List"></Head>
  <authenticated-layout>
    <template #header> Users List </template>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-body p-4 table-responsive">
          <table class="table">
            <thead
              class="text-xs font-semibold uppercase text-gray-400 bg-gray-50"
            >
              <tr>
                <th class="text-left">Nama</th>
                <th class="text-left">Email</th>
                <th class="text-left">Role</th>
              </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
              <tr v-for="user in users.data" :key="user.id">
                <td>
                  <Link
                    class="underline text-blue-600"
                    :href="route('user.show', user.id)"
                  >
                    {{ user.name }}
                  </Link>
                </td>
                <td>{{ user.email }}</td>
                <td>
                  <span v-if="user.is_superadmin">Admin</span>
                  <span v-else>{{ user.role }}</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-center">
          <pagination :links="users.links"></pagination>
        </div>
      </div>
    </div>
  </authenticated-layout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Auth.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

export default {
  components: {
    Head,
    AuthenticatedLayout,
    Pagination,
    Link,
  },
  props: {
    users: Object,
  },
};
</script>

<style lang="scss" scoped>
</style>
