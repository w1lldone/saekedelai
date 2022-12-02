<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header> Report </template>

    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card card-body p-4">
          <h4 class="font-bold">Total Kelompok Tani</h4>
          <div class="row mt-3 text-primary">
            <div class="col-md-6">
              <i class="fa fa-users fa-3x"></i>
            </div>
            <div class="col-md-6 text-end">
              <h1 class="m-0">{{ reports.organizations }}</h1>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-body p-4">
          <h4 class="font-bold">Total Petani</h4>
          <div class="row mt-3 text-success">
            <div class="col-md-6">
              <i class="fa fa-user-alt fa-3x"></i>
            </div>
            <div class="col-md-6 text-end">
              <h1 class="m-0">{{ reports.farmers }}</h1>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-body p-4">
          <h4 class="font-bold">Total Luas Lahan</h4>
          <div class="row mt-3 text-info">
            <div class="col-md-4">
              <i class="fa fa-spa fa-3x"></i>
            </div>
            <div class="col-md-8 text-end">
              <h1 class="m-0">{{ Math.trunc(reports.fields) }} Ha</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="card card-body p-4">
          <h4 class="font-bold">Hasil panen perdaerah</h4>
          <harvest-area-chart :harvests="reports.harvests"></harvest-area-chart>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card card-body p-4">
          <h4 class="font-bold">Produksi kedelai tahun ini</h4>
          <table class="table">
            <thead>
              <tr>
                <th>Petani</th>
                <th>Total produksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(packing, index) in reports.packings" :key="index" >
                <td>{{ packing.user.name }}</td>
                <td>{{ packing.total_quantity }} Kg</td>
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
import { Head } from "@inertiajs/inertia-vue3";
import HarvestAreaChart from "@/Components/Report/HarvestAreaChart.vue";

export default {
  props: {
    reports: {
      type: Object,
    },
  },
  components: {
    BreezeAuthenticatedLayout,
    Head,
    HarvestAreaChart,
  },
};
</script>
