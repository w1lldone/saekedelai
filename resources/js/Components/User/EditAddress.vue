<template>
  <form @submit.prevent="submit()">
    <div
      v-if="status"
      class="alert alert-success alert-dismissible fade show"
      role="alert"
    >
      <strong>Success!</strong> {{ status }}
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
      ></button>
    </div>
    <div class="mb-3">
      <label for="province" class="form-label">Provinsi</label>
      <vue-select
        label="name"
        @search="fetchProvinces"
        v-model="form.province"
        :options="provinces"
        @option:selected="fetchCities(null)"
      ></vue-select>
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
    </div>
    <div class="mb-3">
      <label for="district" class="form-label">Kecamatan</label>
      <vue-select
        label="name"
        @search="fetchDistricts"
        v-model="form.district"
        :options="districts"
        @option:selected="fetchSubdistricts(null)"
      ></vue-select>
    </div>
    <div class="mb-3">
      <label for="district" class="form-label">Kelurahan / Desa</label>
      <vue-select
        label="name"
        @search="fetchSubdistricts"
        v-model="form.subdistrict"
        :options="subdistricts"
      ></vue-select>
    </div>
    <div class="mb-3">
      <label for="address" class="form-label"
        >Dusun RT/RW - <small class="form-text">Opsional</small></label
      >

      <input
        type="text"
        v-model="form.address"
        placeholder="RT 01 RW 03"
        class="form-control"
      />
    </div>
    <div class="d-flex justify-content-end">
      <button
        class="btn btn-success"
        :class="{ disabled: form.processing }"
        type="submit"
      >
        Simpan Alamat
      </button>
    </div>
  </form>
</template>

<script>
import VueSelect from "vue-select";

export default {
  components: {
    VueSelect,
  },
  props: {
    address: Object,
    submitUrl: String,
    status: String
  },
  data() {
    return {
      form: this.$inertia.form({
        province: { name: this.address.province },
        city: { name: this.address.city },
        district: { name: this.address.district },
        subdistrict: { name: this.address.subdistrict },
        address: this.address.address,
      }),
      provinces: [],
      cities: [],
      districts: [],
      subdistricts: [],
    };
  },
  mounted() {
    this.fetchProvinces();
  },
  methods: {
    submit() {
      this.form
        .transform((data) => ({
          ...data,
          province: data.province.name,
          city: data.city.name,
          district: data.district.name,
          subdistrict: data.subdistrict.name,
          address: data.address,
        }))
        .put(this.submitUrl);
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
    async fetchSubdistricts(name) {
      try {
        let response = await axios.get(this.route("address.subdistricts"), {
          params: {
            district_id: this.form.district.id,
            name: name,
          },
        });
        this.subdistricts = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>

<style>
</style>
