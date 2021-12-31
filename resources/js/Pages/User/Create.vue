<template>
  <Head title="Create a User"></Head>
  <AuthenticatedLayout>
    <template #header>
      <InertiaLink class="text-primary" :href="route('user.index')"
        >Pengguna</InertiaLink
      >
      <i class="fa fa-chevron-right mx-2"></i>Buat pengguna
    </template>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card card-body p-4">
          <form @submit.prevent="submit">
            <h3 class="text-primary font-bold">Data Diri</h3>
            <div class="mb-3">
              <label for="name" class="form-label">Nama</label>
              <input
                type="text"
                class="form-control"
                v-model="form.name"
                :class="{ 'is-invalid': form.errors.name }"
              />
              <span class="invalid-feedback">{{ form.errors.name }}</span>
            </div>
            <div class="mb-3">
              <label for="id_number" class="form-label">NIK</label>
              <input
                type="text"
                class="form-control"
                v-model="form.id_number"
                :class="{ 'is-invalid': form.errors.id_number }"
              />
              <span class="invalid-feedback">{{ form.errors.id_number }}</span>
            </div>
            <div class="mb-3">
              <label for="phone_number" class="form-label"
                >No HP <span class="text-muted">(opsional)</span></label
              >
              <input
                type="text"
                class="form-control"
                v-model="form.phone_number"
                :class="{ 'is-invalid': form.errors.phone_number }"
              />
              <span class="invalid-feedback">{{
                form.errors.phone_number
              }}</span>
            </div>
            <div class="form-check py-2">
              <input
                class="form-check-input"
                type="checkbox"
                :value="true"
                id="flexCheckDefault"
                v-model="hasEmail"
              />
              <label class="form-check-label" for="flexCheckDefault">
                Anggota mempunyai email untuk login
              </label>
            </div>
            <div class="mb-3" v-show="hasEmail">
              <label for="email" class="form-label"
                >Email <span class="text-muted">(opsional)</span></label
              >
              <input
                type="email"
                class="form-control"
                v-model="form.email"
                :class="{ 'is-invalid': form.errors.email }"
              />
              <span class="invalid-feedback">{{ form.errors.email }}</span>
              <span class="form-text"
                >Jika dikosongkan, sistem akan membuat random email untuk
                anggota</span
              >
            </div>
            <div class="mb-3" v-show="hasEmail">
              <label for="password" class="form-label"
                >Password <span class="text-muted">(opsional)</span></label
              >
              <input
                type="text"
                class="form-control"
                v-model="form.password"
                :class="{ 'is-invalid': form.errors.password }"
              />
              <span class="invalid-feedback">{{ form.errors.password }}</span>
              <span class="form-text"
                >Jika dikosongkan, sistem akan membuat random password untuk
                anggota</span
              >
            </div>
            <div class="mb-3" v-show="hasEmail">
              <label for="role">Pilih Role</label>
              <div clz>
                <div class="form-check" v-for="role in roles" :key="role">
                  <input
                    v-model="form.role"
                    :value="role"
                    class="form-check-input"
                    type="radio"
                    name="flexRadioDefault"
                    :id="role"
                  />
                  <label class="form-check-label" :for="role">
                    {{ role }}
                  </label>
                </div>
              </div>
            </div>
            <h3 class="text-primary font-bold">Alamat</h3>
            <div class="mb-3">
              <label for="province" class="form-label">Provinsi</label>
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
              <label for="district" class="form-label">Kecamatan</label>
              <vue-select
                label="name"
                @search="fetchDistricts"
                v-model="form.district"
                :options="districts"
                @option:selected="fetchSubdistricts(null)"
              ></vue-select>
              <span v-if="form.errors.district" class="form-text text-danger">{{
                form.errors.district
              }}</span>
            </div>
            <div class="mb-3">
              <label for="district" class="form-label">Kelurahan / Desa</label>
              <vue-select
                label="name"
                @search="fetchSubdistricts"
                v-model="form.subdistrict"
                :options="subdistricts"
              ></vue-select>
              <span
                v-if="form.errors.subdistrict"
                class="form-text text-danger"
                >{{ form.errors.subdistrict }}</span
              >
            </div>
            <div class="mb-4">
              <label for="address" class="form-label"
                >Dusun RT/RW - <small class="form-text">Opsional</small></label
              >
              <input
                type="text"
                v-model="form.address"
                placeholder="RT 01 RW 03"
                class="form-control"
                :class="{ 'is-invalid': form.errors.address }"
              />
              <span class="invalid-feedback">{{ form.errors.address }}</span>
            </div>
            <h3 class="text-primary font-bold">Kelompok tani</h3>
            <div class="mb-3">
              <label for="city" class="form-label"
                >Anggota pada kelompok tani
                <span class="text-muted">(opsional)</span></label
              >
              <vue-select
                :value="organization_id"
                :reduce="(organization) => organization.id"
                label="name"
                v-model="form.organization_id"
                :options="organizations"
              ></vue-select>
              <span
                v-if="form.errors.organization_id"
                class="form-text text-danger"
                >{{ form.errors.organization_id }}</span
              >
            </div>
            <div class="mb-3">
              <label for="member_type">Tipe keanggotaan</label>
              <div>
                <div class="form-check form-check-inline">
                  <input
                    checked
                    class="form-check-input"
                    type="radio"
                    name="inlineRadioOptions"
                    id="member"
                    value="member"
                    :disabled="form.organization_id == null"
                  />
                  <label class="form-check-label" for="member">Member</label>
                </div>
                <div class="form-check form-check-inline">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="inlineRadioOptions"
                    id="leader"
                    value="leader"
                    :disabled="form.organization_id == null"
                  />
                  <label class="form-check-label" for="leader">Ketua</label>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <button
                type="submit"
                class="btn btn-success"
                :class="{ disabled: form.processing }"
              >
                Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/Auth.vue";
import VueSelect from "vue-select";

export default {
  props: {
    organizations: Array,
    organization_id: String,
    roles: Array,
  },
  components: {
    Head,
    InertiaLink,
    AuthenticatedLayout,
    VueSelect,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: null,
        email: null,
        id_number: null,
        phone_number: null,
        password: null,
        province: { name: null },
        city: { name: null },
        district: { name: null },
        subdistrict: { name: null },
        address: null,
        organization_id: null,
        member_type: null,
        role: "member",
      }),
      hasEmail: false,
      provinces: [],
      cities: [],
      districts: [],
      subdistricts: [],
    };
  },
  mounted() {
    this.fetchProvinces();
    if (this.organization_id) {
      var index = this.organizations.findIndex(
        (item) => item.id == this.organization_id
      );
      this.form.organization_id = this.organizations[index];
    }
  },
  methods: {
    submit() {
      this.form
        .transform(function (data) {
          data.province = data.province.name;
          data.city = data.city.name;
          data.district = data.district.name;
          data.subdistrict = data.subdistrict.name;

          return data;
        })
        .post(route("user.store"));
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
