<template>
  <div>
    <Head title="Daftarkan lahan"></Head>
    <Auth>
      <template #header>
        <InertiaLink class="text-primary" :href="route('field.index')"
          >Lahan pertanian</InertiaLink>
        <i class="fa fa-chevron-right mx-2"></i>
        <InertiaLink class="text-primary" :href="route('field.show', field.id)"
          >Detail lahan</InertiaLink>
        <i class="fa fa-chevron-right mx-2"></i>
        Ubah lahan
      </template>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card card-body p-4">
            <form @submit.prevent="submit()">
              <h3 class="text-primary font-bold">Data Lahan</h3>
              <div class="form-group">
                <label class="form-label">Pemilik lahan</label>
                <input type="text" :value="field.user.name" class="form-control" disabled>
                <span class="form-text">Pemilik lahan tidak dapat dirubah</span>
              </div>
              <div class="form-group">
                <label for="">Luas lahan (Ha)</label>
                <input type="number" step="0.01" class="form-control" :class=" {'is-invalid': form.errors.area}" v-model="form.area" />
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
                  <label for="" class="form-label">Latitude</label>
                  <input
                    type="number"
                    name="latitude"
                    step="0.00000001"
                    class="form-control"
                    v-model="form.latitude"
                  />
                </div>
                <div class="col-md-6">
                  <label for="">Longitude</label>
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
                  <button class="btn btn-success" type="submit">Simpan lahan</button>
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
  props: {
      field: Object
  },
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
        user_id: this.field.user_id,
        area: this.field.area,
        description: this.field.description,
        latitude: this.field.latitude,
        longitude: this.field.longitude,
        province: this.field.address.province,
        city: this.field.address.city,
        district: this.field.address.district,
        subdistrict: this.field.address.subdistrict,
      }),
    };
  },
  methods: {
    submit() {
      this.form.put(route("field.update", this.field.id));
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
