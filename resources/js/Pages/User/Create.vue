<template>
  <Head title="Daftarkan anggota"></Head>
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
                maxlength="16"
                class="form-control"
                v-model="form.id_number"
                :class="{ 'is-invalid': form.errors.id_number }"
              />
              <span class="form-text">{{ form.id_number.length }} / 16</span>
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
            <div class="mb-3">
              <label for="formFile" class="form-label"
                >Unggah Foto <span class="text-muted">(opsional)</span></label
              >
              <input
                class="form-control"
                :class="{ 'is-invalid': form.errors.profile_picture }"
                type="file"
                id="formFile"
                @input="form.profile_picture = $event.target.files[0]"
              />
              <span class="invalid-feedback">{{
                form.errors.profile_picture
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
            <AddressSelect
              v-model:province="form.province"
              v-model:city="form.city"
              v-model:district="form.district"
              v-model:subdistrict="form.subdistrict"
            ></AddressSelect>
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
              <OrganizationSelect
                v-model="form.organization_id"
                :initialSelected="organization"
              ></OrganizationSelect>
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
import AddressSelect from "@/Components/Address/AddressSelect.vue";
import OrganizationSelect from "@/Components/Organization/OrganizationSelect.vue";

export default {
  props: {
    organization: {
      default: {},
    },
    roles: Array,
  },
  components: {
    Head,
    InertiaLink,
    AuthenticatedLayout,
    VueSelect,
    AddressSelect,
    OrganizationSelect,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: null,
        email: null,
        id_number: "",
        phone_number: null,
        password: null,
        province: null,
        city: null,
        district: null,
        subdistrict: null,
        address: null,
        organization_id: null,
        member_type: null,
        role: "member",
        profile_picture: null,
      }),
      hasEmail: false,
    };
  },
  mounted() {
    if (this.organization) {
      this.form.organization_id = this.organization.id;
    }
  },
  methods: {
    submit() {
      this.form.post(route("user.store"));
    },
  },
};
</script>

<style>
</style>
