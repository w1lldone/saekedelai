<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
        <InertiaLink class="text-primary" :href="route('report.farmer')"
          >Laporan petani</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>{{ region }}
      </template>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-body p-4">
          <h4 class="font-bold">Daftar petani pada wilayah {{ region }}</h4>
          <table class="table">
            <thead>
              <tr>
                <th>Nama petani</th>
                <th>Total luas lahan</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(user) in users" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.total_area }} Ha</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Auth.vue";
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";

export default {
  props: {
    users: Array,
    region: String
  },
  components: {
    BreezeAuthenticatedLayout,
    Head,
    InertiaLink
  },
};
</script>
