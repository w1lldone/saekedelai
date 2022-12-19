<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header> Laporan produk akhir </template>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-body p-4">
          <h4 class="font-bold">Jumlah produk per kelompok tani</h4>
          <table class="table">
            <thead>
              <tr>
                <th>Kelompok tani</th>
                <th>Alamat</th>
                <th>Total produk</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(report, index) in reports" :key="index">
                <td>
                    <InertiaLink :href="route('report.packing.show', report.organization_id)">
                        {{ report.organization.name }}
                    </InertiaLink>
                </td>
                <td>{{ report.organization.address.formatted_address }}</td>
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
  },
  components: {
    BreezeAuthenticatedLayout,
    Head,
    HarvestAreaChart,
    InertiaLink
  },
};
</script>
