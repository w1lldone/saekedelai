<template>
  <div>
    <Head title="Daftarkan lahan"></Head>
    <Auth>
      <template #header>
        <InertiaLink class="text-primary" :href="route('field.index')"
          >Lahan pertanian</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>Daftarkan lahan
      </template>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card card-body p-4">
            <form @submit.prevent="submit()">
              <h3 class="text-primary font-bold">Data Lahan</h3>
              <div class="form-group">
                <label class="form-label">Pemilik lahan</label>
                <UserSelect v-model="form.user_id"></UserSelect>
                <span v-if="form.errors.user_id" class="text-danger">{{ form.errors.user_id }}</span>
              </div>
              <div class="form-group">
                <label for="">Luas lahan (Ha)</label>
                <input
                  type="number"
                  step="0.01"
                  class="form-control"
                  v-model="form.area"
                  :class="{ 'is-invalid': form.errors.area }"
                />
                <span class="invalid-feedback">{{ form.errors.area }}</span>
              </div>
              <div class="form-group">
                <label for=""
                  >Deskripsi <small class="text-muted">(opsional)</small></label
                >
                <input
                  type="text"
                  class="form-control"
                  v-model="form.description"
                />
              </div>
              <h3 class="text-primary font-bold">Lokasi lahan</h3>
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
                  />
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
                  />
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
                <button class="btn btn-success" type="submit" :disabled="form.processing">
                  Simpan lahan
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

export default {
  props: {},
  components: {
    Auth,
    Head,
    InertiaLink,
    UserSelect,
    AddressSelect,
  },
  data() {
    return {
      form: this.$inertia.form({
        user_id: null,
        area: null,
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
      this.form.post(route("field.store"));
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
