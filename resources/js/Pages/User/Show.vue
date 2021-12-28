<template>
  <Head title="User Detail" />

  <AuthenticatedLayout>
    <template #header>
      <Link class="text-primary" :href="route('user.index')">Pengguna</Link>
      <i class="fa fa-chevron-right mx-2"></i>Detail pengguna
    </template>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card card-body p-4">
          <div>
            <div>
              <h3 class="font-bold m-0">Nama</h3>
              <h3>
                {{ user.name }}
              </h3>
            </div>
            <div class="mt-3">
              <h3 class="font-bold m-0">Role pengguna</h3>
              <h3 v-if="user.role">
                {{ user.role }}
              </h3>
              <h3 v-else class="text-muted">Pengguna tidak memiliki role</h3>
            </div>
            <div class="mt-3">
              <h3 class="font-bold m-0">Email</h3>
              <h3>
                {{ user.email }}
              </h3>
            </div>
            <div class="mt-3">
              <h3 class="font-bold m-0">No Hp</h3>
              <h3 v-if="user.phone_number">
                {{ user.phone_number }}
              </h3>
              <h3 v-else class="text-gray-400">Tidak tersedia</h3>
            </div>
            <div class="mt-3">
              <h3 class="font-semibold text-xl">
                <span class="text-green-600" v-if="user.id_number"
                  ><i class="fa fa-id-card"></i> NIK Tersedia</span
                >
                <span class="text-gray-400" v-else>
                  <i class="fa fa-id-card"></i> NIK Tidak Tersedia
                </span>
              </h3>
            </div>
            <div class="mt-3">
              <h3 class="font-bold m-0">Alamat</h3>
              <h3 v-if="user.address.formatted_address">
                {{ user.address.formatted_address }}
              </h3>
              <h3 class="text-muted" v-else>Alamat tidak tersedia</h3>
            </div>
            <div class="mt-3">
              <h3 class="font-bold">Kelompok tani</h3>
              <ul v-if="user.organizations.length">
                <li
                  v-for="organization in user.organizations"
                  :key="organization.id"
                >
                  <Link class="h3 text-cyan" :href="route('organization.show', organization.id)">{{
                    organization.name
                  }}</Link>
                  (anggota)
                </li>
              </ul>
              <h3 v-else class="text-muted">
                Pengguna tidak terdaftar pada kelompok tani
              </h3>
            </div>
          </div>
        </div>
        <div class="mt-3 d-flex justify-content-between">
          <Link
            class="btn btn-warning"
            v-if="can.update"
            :href="route('user.edit', user.id)"
          >
            <i class="fa fa-edit"></i> Edit anggota
          </Link>
            <delete-button :submitUrl="route('user.destroy', user.id)" entity="Angota">
                <i class="fa fa-trash"></i> Hapus Anggota
            </delete-button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/Auth.vue";
import EditUser from "@/Components/User/Edit.vue";
import BreezeButton from "@/Components/Button.vue";
import DeleteButton from '@/Components/DeleteButton.vue';

export default {
  components: {
    AuthenticatedLayout,
    Head,
    Link,
    EditUser,
    BreezeButton,
    DeleteButton
  },
  props: {
    user: Object,
    status: String,
    can: Object,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: this.user.name,
        email: this.user.email,
      }),
      isEditing: false,
    };
  },
};
</script>

<style>
</style>
