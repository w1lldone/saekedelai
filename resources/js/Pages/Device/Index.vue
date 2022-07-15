<template>
  <div>
    <Head title="Perangkat"></Head>
    <Auth>
      <template #header> Perangkat </template>

      <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-body p-4">
                <div class="d-flex justify-content-between align-content-center">
                    <h3 class="font-bold text-primary">List Perangkat</h3>
                    <InertiaLink v-if="can['device.create']" class="btn btn-primary" :href="route('device.create')"><i class="fa fa-plus me-1"></i> Daftarkan perangkat</InertiaLink>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Id perangkat</th>
                            <th>Nama</th>
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="device in devices.data" :key="device.id">
                            <td>
                                <InertiaLink :href="route('device.show', device.id)">{{ device.device_id }}</InertiaLink>
                            </td>
                            <td>
                                {{ device.name }} <br>
                                <small>{{ device.description }}</small>
                            </td>
                            <td>
                                {{ device.address.formatted_address }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="devices.data.length == 0" class="p-4 text-center">
                    <h3 class="text-muted">Tidak ada perangkat terdaftar</h3>
                </div>
            </div>
        </div>
      </div>
    </Auth>
  </div>
</template>

<script>
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import Auth from "@/Layouts/Auth.vue";
import Status from "@/Components/Status.vue";
import Pagination from "@/Components/Pagination.vue";

export default {
  props: {
    devices: Object,
    can: Object,
  },
  components: {
    Head,
    InertiaLink,
    Auth,
    Status,
    Pagination,
  },
};
</script>

<style>
</style>
