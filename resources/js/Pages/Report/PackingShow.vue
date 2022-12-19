<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <InertiaLink class="text-primary" :href="route('report.packing')"
        >Laporan produk</InertiaLink
      >
      <i class="fa fa-chevron-right mx-2"></i>{{ organization.name }}
    </template>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-body p-4">
          <h4 class="font-bold">Total produk per petani</h4>
          <table class="table">
            <thead>
              <tr>
                <th>Petani</th>
                <th>Total produk</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(report, index) in reports" :key="index">
                <td>
                    {{ report.user_name }}
                </td>
                <td>{{ report.total_quantity }} Kg</td>
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
import HarvestAreaChart from "@/Components/Report/HarvestAreaChart.vue";

export default {
  props: {
    reports: {
      type: Array,
    },
    organization: Object
  },
  components: {
    BreezeAuthenticatedLayout,
    Head,
    HarvestAreaChart,
    InertiaLink
  },
};
</script>
