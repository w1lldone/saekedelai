<template>
  <div>
    <Head title="Detail perangkat"></Head>
    <Auth>
      <template #header>
        <InertiaLink class="text-primary" :href="route('device.index')"
          >Perangkat</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>Detail perangkat
      </template>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <Status></Status>

          <div class="card card-body p-4">
            <h3 class="font-bold text-primary">{{ device.name }}</h3>
            <p>
              {{ device.description }}
            </p>
            <div class="row">
              <div class="col-md-6">
                <div class="d-flex align-items-center">
                  <div class="me-2">
                    <i class="fa fa-microchip fa-2x"></i>
                  </div>
                  <div>
                    <b>Device id</b><br />
                    <span>{{ device.device_id }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-center">
                  <div class="me-2">
                    <i class="fa fa-map-marker-alt fa-2x"></i>
                  </div>
                  <div>
                    <b>Lokasi</b><br />
                    <a
                      target="_blank"
                      :href="`http://www.google.com/maps/place/${device.latitude},${device.longitude}`"
                      v-if="device.longitude && device.latitude"
                      >{{ device.latitude }},{{ device.longitude }}
                      <i class="fas fa-external-link-alt"></i
                    ></a>
                    <span v-else class="text-muted"
                      >Lokasi perangkat belum diset</span
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6 mt-3">
                <div class="d-flex align-items-center">
                  <div class="me-2">
                    <i class="far fa-compass fa-2x"></i>
                  </div>
                  <div>
                    <b>Alamat</b><br />
                    <span v-if="device.address.formatted_address">{{
                      device.address.formatted_address
                    }}</span>
                    <span v-else class="text-muted"
                      >Alamat perangkat belum diset</span
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-12 mt-3">
                <div class="d-flex align-items-center">
                  <div class="me-2">
                    <i class="fas fa-thermometer-empty fa-2x"></i>
                  </div>
                  <div>
                    <b>Atribut perangkat</b>
                  </div>
                </div>
                <div class="mt-2">
                  <span
                    v-for="attribute in device.payload_attributes"
                    class="badge bg-primary rounded-pill m-1"
                    :key="attribute.name"
                    >{{ attribute.name }}</span
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <InertiaLink
              class="btn btn-warning"
              :href="route('device.edit', device.id)"
            >
              <i class="fa fa-edit"></i> Ubah perangkat
            </InertiaLink>
            <DeleteButton
              entity="perangkat"
              :submitUrl="route('device.delete', device.id)"
              >Hapus perangkat</DeleteButton
            >
          </div>
        </div>
      </div>
    </Auth>
  </div>
</template>

<script>
import Auth from "@/Layouts/Auth.vue";
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import DeleteButton from "@/Components/DeleteButton.vue";
import Status from "@/Components/Status.vue";

export default {
  props: {
    device: Object,
  },
  components: {
    Auth,
    Head,
    InertiaLink,
    Status,
    DeleteButton,
  },
};
</script>

<style>
</style>
