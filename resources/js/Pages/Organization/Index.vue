<template>
  <Head title="Kelompok Tani"></Head>
  <authenticated-layout>
    <template #header>Kelompok Tani</template>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="d-flex justify-content-end mb-3">
          <InertiaLink
            :href="route('organization.create')"
            class="btn btn-primary"
          >
            <i class="fa fa-plus me-2"></i> Buat Kelompok Tani
          </InertiaLink>
        </div>

        <div class="card card-body p-4 table-responsive">
          <div
            v-if="status"
            class="alert alert-success alert-dismissible fade show"
            role="alert"
          >
            <strong>Success!</strong> {{ status }}
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="alert"
              aria-label="Close"
            ></button>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th class="text-left">Nama Kelompok</th>
                <th class="text-left">Lokasi</th>
                <th class="text-left">Jumlah Anggota</th>
              </tr>
            </thead>

            <tbody>
              <tr
                v-for="organization in organizations.data"
                :key="organization.id"
              >
                <td>
                  <InertiaLink
                    class="underline text-blue-600"
                    :href="route('organization.show', organization.id)"
                  >
                    {{ organization.name }}
                  </InertiaLink>
                </td>
                <td>
                  {{ organization.address.province }},
                  {{ organization.address.city }}
                </td>
                <td>{{ organization.users_count }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-center">
          <pagination :links="organizations.links"></pagination>
        </div>
      </div>
    </div>
  </authenticated-layout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Auth.vue";
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

export default {
  props: {
    organizations: Object,
    status: String,
  },
  components: {
    AuthenticatedLayout,
    Head,
    InertiaLink,
    Pagination,
  },
};
</script>

<style>
</style>
