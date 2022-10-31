<template>
  <div>
    <Head title="Tambah perangkat"></Head>
    <Auth>
      <template #header>
        <InertiaLink class="text-primary" :href="route('device.index')"
          >Perangkat</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>Tambah perangkat
      </template>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card card-body p-4">
            <h3 class="text-primary font-bold">Tambah perangkat</h3>
            <form @submit.prevent="submit()" class="mt-3">
              <div class="form-group">
                <label for="">Pilih server perangkat</label>
                <VueSelect
                  v-model="form.integration"
                  :options="integrations"
                  @option:selected="
                    (selected) => {
                      this.fetchDevices();
                    }
                  "
                ></VueSelect>
                <span v-if="form.errors.integration" class="text-danger">{{
                  form.errors.integration
                }}</span>
              </div>
              <div class="form-group">
                <label for="">Pilih perangkat terdaftar</label>
                <VueSelect
                  v-model="form.device"
                  label="name"
                  :options="devices"
                  placeholder="Pilih perangkat terdaftar"
                  :loading="loadingDevices"
                >
                  <template v-slot:option="option">
                    <b>{{ option.name }}</b>
                    {{ option.device_id }}
                  </template>
                  <template #no-options>
                    Tidak ada perangkat tersedia di server ini atau semua
                    perangkat sudah ditambahkan.
                  </template>
                </VueSelect>
                <span v-if="form.errors.device_id" class="text-danger">{{
                  form.errors.device_id
                }}</span
                ><br />
                <span v-if="form.errors.name" class="text-danger">{{
                  form.errors.name
                }}</span>
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
                  Tambah perangkat
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
    integrations: Array,
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
        integration: null,
        name: null,
        attributes: null,
        device_id: null,
        device: {
          device_id: null,
          name: null,
        },
        description: null,
        latitude: null,
        longitude: null,
        province: null,
        city: null,
        district: null,
        subdistrict: null,
      }),
    };
  },
  methods: {
    submit() {
      this.form
        .transform((data) => ({
          ...data,
          device_id: data.device.device_id,
          name: data.device.name,
          payload_attributes: data.device.payload_attributes,
        }))
        .post(route("device.store"));
    },
    getDeviceEndpoint() {
      return `${this.form.integration}.device.index`;
    },
    async fetchDevices() {
      this.devices = [];
      this.loadingDevices = true;
      let response = await axios.get(this.route(this.getDeviceEndpoint()), {
        params: {
          exclude_registered: true,
        },
      });
      this.devices = response.data.data;
      this.loadingDevices = false;
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
