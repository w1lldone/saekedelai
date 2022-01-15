<template>
  <div>
    <div class="form-group">
      <label for="">Provinsi</label>
      <VueSelect
        label="name"
        :options="options.provinces"
        v-model="selected.province"
        placeholder="Pilih provinsi"
        @search="
          (search, loading) => {
            this.params.name = search;
            this.fetchProvinces();
          }
        "
        @option:selected="
          (selected) => {
            this.$emit('update:province', selected.name);
            this.fetchCities();
          }
        "
      ></VueSelect>
    </div>
    <div class="form-group">
      <label for="">Kabupaten / Kota</label>
      <VueSelect
        label="name"
        :options="options.cities"
        v-model="selected.city"
        placeholder="Pilih kabupaten / kota"
        @search="
          (search, loading) => {
            this.params.name = search;
            this.fetchCities();
          }
        "
        @option:selected="
          (selected) => {
            this.$emit('update:city', selected.name);
            this.fetchDistricts();
          }
        "
      ></VueSelect>
    </div>
    <div class="form-group">
      <label class="form-label">Kecamatan</label>
      <VueSelect
        label="name"
        :options="options.districts"
        v-model="selected.district"
        placeholder="Pilih kecamatan"
        @search="
          (search, loading) => {
            this.params.name = search;
            this.fetchDistricts();
          }
        "
        @option:selected="
          (selected) => {
            this.$emit('update:district', selected.name);
            this.fetchSubdistricts();
          }
        "
      ></VueSelect>
    </div>
    <div class="form-group">
      <label class="form-label">Desa</label>
      <VueSelect
        label="name"
        :options="options.subdistricts"
        v-model="selected.subdistrict"
        placeholder="Pilih desa"
        @search="
          (search, loading) => {
            this.params.name = search;
            this.fetchSubdistricts();
          }
        "
        @option:selected="
          (selected) => {
            this.$emit('update:subdistrict', selected.name);
          }
        "
      ></VueSelect>
    </div>
  </div>
</template>

<script>
import VueSelect from "vue-select";

export default {
  props: {
    province: String,
    city: String,
    district: String,
    subdistrict: String,
  },
  components: {
    VueSelect,
  },
  data() {
    return {
      options: {
        provinces: [],
        cities: [],
        districts: [],
        subdistricts: [],
      },
      selected: {
        province: { name: null },
        city: { name: null },
        district: { name: null },
        subdistrict: { name: null },
      },
      params: {
        name: null,
      },
    };
  },
  mounted() {
    this.fetchProvinces();
    this.selected.province.name = this.province;
    this.selected.city.name = this.city;
    this.selected.district.name = this.district;
    this.selected.subdistrict.name = this.subdistrict;

  },
  methods: {
    handleSelected(method) {},
    fetchProvinces: _.debounce(async function () {
      let response = await axios.get(this.route("address.provinces"), {
        params: this.params,
      });

      this.options.provinces = response.data.data;
    }, 350),
    fetchCities: _.debounce(async function () {
      let response = await axios.get(this.route("address.cities"), {
        params: {
          province_id: this.selected.province.id,
          name: this.params.name,
        },
      });
      this.options.cities = response.data.data;
    }, 350),
    fetchDistricts: _.debounce(async function (name) {
      let response = await axios.get(this.route("address.districts"), {
        params: {
          city_id: this.selected.city.id,
          name: this.params.name,
        },
      });
      this.options.districts = response.data.data;
    }, 350),
    fetchSubdistricts: _.debounce(async function (name) {
      let response = await axios.get(this.route("address.subdistricts"), {
        params: {
          district_id: this.selected.district.id,
          name: this.params.name,
        },
      });
      this.options.subdistricts = response.data.data;
    }, 350),
  },
};
</script>

<style>
</style>
