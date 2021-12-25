<template>
  <form @submit.prevent="submit()" class="mt-2">
    <h3 class="text-primary font-bold">Informasi Umum</h3>
    <div class="mb-3">
      <label for="name" class="form-label">Nama Kelompok</label>
      <input
        name="name"
        type="text"
        class="form-control"
        v-model="form.name"
        :class="{ 'is-invalid': form.errors.name }"
      />
      <span class="invalid-feedback">{{ form.errors.name }}</span>
    </div>
    <div class="mb-3">
      <label for="description" class="form-label"
        >Deskripsi Kelompok
        <span class="text-muted">(opsional)</span>
      </label>
      <input
        name="description"
        type="text"
        class="form-control"
        v-model="form.description"
        :class="{ 'is-invalid': form.errors.description }"
      />
      <span class="invalid-feedback">{{ form.errors.description }}</span>
    </div>
    <h3 class="text-primary font-bold">Lokasi</h3>
    <div class="mb-3">
      <label for="city" class="form-label">Provinsi</label>
      <vue-select
        label="name"
        @search="fetchProvinces"
        v-model="form.province"
        :options="provinces"
        @option:selected="fetchCities(null)"
      ></vue-select>
      <span v-if="form.errors.province" class="form-text text-danger">{{
        form.errors.province
      }}</span>
    </div>
    <div class="mb-3">
      <label for="city" class="form-label">Kota / Kabupaten</label>
      <vue-select
        label="name"
        @search="fetchCities"
        v-model="form.city"
        :options="cities"
        @option:selected="fetchDistricts(null)"
      ></vue-select>
      <span v-if="form.errors.city" class="form-text text-danger">{{
        form.errors.city
      }}</span>
    </div>
    <div class="mb-3">
      <label for="district" class="form-label"
        >Kecamatan <span class="text-muted">(opsional)</span></label
      >
      <vue-select
        label="name"
        @search="fetchDistricts"
        v-model="form.district"
        :options="districts"
      ></vue-select>
      <span v-if="form.errors.district" class="form-text text-danger">{{
        form.errors.district
      }}</span>
    </div>
    <div class="d-flex justify-content-end">
      <button class="btn btn-success" type="submit">Simpan kelompok</button>
    </div>
  </form>
</template>

<script>
import VueSelect from "vue-select";

export default {
  props: {
    submitUrl: String,
    method: {
      type: String,
      default: "post",
    },
    initOrganization: Object,
  },
  components: { VueSelect },
  data() {
    return {
      form: this.$inertia.form({
        name: null,
        description: null,
        province: { name: null },
        city: { name: null },
        district: { name: null },
      }),
      provinces: [],
      cities: [],
      districts: [],
    };
  },
  mounted() {
    this.fetchProvinces();

    if (this.initOrganization) {
      this.form = this.$inertia.form({
        name: this.initOrganization.name,
        description: this.initOrganization.description,
        province: { name: this.initOrganization.address.province },
        city: { name: this.initOrganization.address.city },
        district: { name: this.initOrganization.address.district },
      });
    }
  },
  methods: {
    submit() {
      this.form
        .transform(function (data) {
          data.province = data.province.name;
          data.city = data.city.name;
          data.district = data.district.name;

          return data;
        })
        .submit(this.method, this.submitUrl);
    },
    async fetchProvinces(name) {
      try {
        let response = await axios.get(this.route("address.provinces"), {
          params: {
            name: name,
          },
        });
        this.provinces = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
    async fetchCities(name) {
      try {
        let response = await axios.get(this.route("address.cities"), {
          params: {
            province_id: this.form.province.id,
            name: name,
          },
        });
        this.cities = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
    async fetchDistricts(name) {
      try {
        let response = await axios.get(this.route("address.districts"), {
          params: {
            city_id: this.form.city.id,
            name: name,
          },
        });
        this.districts = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>

<style>
</style>
