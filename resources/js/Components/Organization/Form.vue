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
      <AddressSelect
        v-model:province="form.province"
        v-model:city="form.city"
        v-model:district="form.district"
        v-model:subdistrict="form.subdistrict"
      ></AddressSelect>
    </div>
    <div class="d-flex justify-content-end">
      <button class="btn btn-success" type="submit">Simpan kelompok</button>
    </div>
  </form>
</template>

<script>
import VueSelect from "vue-select";
import AddressSelect from "@/Components/Address/AddressSelect.vue";

export default {
  props: {
    submitUrl: String,
    method: {
      type: String,
      default: "post",
    },
    initOrganization: {
      type: Object,
      default: {
        address: {},
      },
    },
  },
  components: { VueSelect, AddressSelect },
  data() {
    return {
      form: this.$inertia.form({
        name: this.initOrganization.name,
        description: this.initOrganization.description,
        province: this.initOrganization.address.province,
        city: this.initOrganization.address.city,
        district: this.initOrganization.address.district,
        subdistrict: this.initOrganization.address.subdistrict,
      }),
    };
  },
  methods: {
    submit() {
      this.form.submit(this.method, this.submitUrl);
    },
  },
};
</script>

<style>
</style>
