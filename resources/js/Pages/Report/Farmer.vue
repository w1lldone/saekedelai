<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header> Laporan petani </template>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-body p-4">
          <h4 class="font-bold">Jumlah petani perwilayah</h4>
          <table class="table">
            <thead>
              <tr>
                <th>Wilayah</th>
                <th>Jumlah petani</th>
                <th>Total luas lahan</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(report, index) in reports" :key="index">
                <td>
                  <InertiaLink :href="route('report.farmer.show', `${report.province};${report.city};${report.district}`)">
                    {{ report.province }}, {{ report.city }},
                    {{ report.district }}
                  </InertiaLink>
                </td>
                <td>{{ report.user_count }}</td>
                <td>{{ report.total_area }} Ha</td>
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
  },
  components: {
    BreezeAuthenticatedLayout,
    Head,
    HarvestAreaChart,
    InertiaLink
  },
};
</script>
