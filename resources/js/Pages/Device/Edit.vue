<template>
  <div>
    <Head title="Ubah perangkat"></Head>
    <Auth>
      <template #header>
        <InertiaLink class="text-primary" :href="route('device.index')"
          >Perangkat</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i
        ><InertiaLink
          class="text-primary"
          :href="route('device.show', device.id)"
          >Detail perangkat</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>Ubah perangkat
      </template>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card card-body p-4">
            <h3 class="text-primary font-bold">Ubah perangkat</h3>
            <form @submit.prevent="submit()" class="mt-3">
              <div class="form-group">
                <span>ID Perangkat: {{ device.device_id }}</span><br>
                <span>Server: {{ device.integration }}</span><br>
                <span>Nama perangkat: {{ device.name }}</span><br>
              </div>
              <div class="form-group">
                <label for=""
                  >Deskripsi <small class="text-muted">(opsional)</small></label
                >
                <input
                  type="text"
                  class="form-control"
                  v-model="form.description"
                  :class="{
                    'is-invalid': form.errors.description,
                  }"
                />
                <span class="invalid-feedback">{{
                  form.errors.description
                }}</span>
              </div>
              <h3 class="text-primary font-bold">Lokasi perangkat</h3>
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="" class="form-label"
                    >Latitude
                    <small class="text-muted">(opsional)</small></label
                  >
                  <input
                    type="number"
                    name="latitude"
                    id=""
                    step="0.00000001"
                    class="form-control"
                    v-model="form.latitude"
                    :class="{
                      'is-invalid': form.errors.latitude,
                    }"
                  />
                  <span class="invalid-feedback">{{
                    form.errors.latitude
                  }}</span>
                </div>
                <div class="col-md-6">
                  <label for=""
                    >Longitude
                    <small class="text-muted">(opsional)</small></label
                  >
                  <input
                    type="number"
                    name="longitude"
                    step="0.00000001"
                    v-model="form.longitude"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.longitude,
                    }"
                  />
                  <span class="invalid-feedback">{{
                    form.errors.longitude
                  }}</span>
                </div>
              </div>
              <AddressSelect
                class="form-group"
                v-model:province="form.province"
                v-model:city="form.city"
                v-model:district="form.district"
                v-model:subdistrict="form.subdistrict"
              ></AddressSelect>
              <div class="form-group pt-3 d-flex justify-content-end">
                <button
                  class="btn btn-success"
                  type="submit"
                  :disabled="form.processing"
                >
                  Ubah perangkat
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </Auth>
  </div>
</template>

<script>
import UserSelect from "@/Components/User/UserSelect.vue";
import { InertiaLink, Head } from "@inertiajs/inertia-vue3";
import Auth from "@/Layouts/Auth.vue";
import AddressSelect from "@/Components/Address/AddressSelect.vue";
import VueSelect from "vue-select";

export default {
  props: {
    device: Object,
  },
  components: {
    Auth,
    Head,
    InertiaLink,
    UserSelect,
    AddressSelect,
    VueSelect,
  },
  data() {
    return {
      devices: [],
      loadingDevices: false,
      form: this.$inertia.form({
        description: this.device.description,
        latitude: this.device.latitude,
        longitude: this.device.longitude,
        province: this.device.address.province,
        city: this.device.address.city,
        district: this.device.address.district,
        subdistrict: this.device.address.subdistrict,
      }),
    };
  },
  methods: {
    submit() {
      this.form.put(route("device.update", this.device.id));
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
