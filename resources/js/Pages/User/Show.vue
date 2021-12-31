<template>
  <Head title="User Detail" />

  <AuthenticatedLayout>
    <template #header>
      <Link class="text-primary" :href="route('user.index')">Pengguna</Link>
      <i class="fa fa-chevron-right mx-2"></i>Detail pengguna
    </template>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-body p-4">
          <h2 class="text-primary font-bold">Data Pengguna</h2>
          <div>
            <div>
              <h4 class="font-bold m-0">Nama</h4>
              <h4>
                {{ user.name }}
              </h4>
            </div>
            <div class="mt-3">
              <h4 class="font-bold m-0">Role pengguna</h4>
              <h4 v-if="user.role">
                {{ user.role }}
              </h4>
              <h4 v-else class="text-muted">Pengguna tidak memiliki role</h4>
            </div>
            <div class="mt-3">
              <h4 class="font-bold m-0">Email</h4>
              <h4>
                {{ user.email }}
              </h4>
            </div>
            <div class="mt-3">
              <h4 class="font-bold m-0">No Hp</h4>
              <h4 v-if="user.phone_number">
                {{ user.phone_number }}
              </h4>
              <h4 v-else class="text-gray-400">Tidak tersedia</h4>
            </div>
            <div class="mt-3">
              <h4 class="font-bold">
                <span v-if="user.id_number"
                  ><i class="fa fa-id-card"></i> NIK Tersedia</span
                >
                <span class="text-muted" v-else>
                  <i class="fa fa-id-card"></i> NIK Tidak Tersedia
                </span>
              </h4>
            </div>
            <div class="mt-3">
              <h4 class="font-bold m-0">Alamat</h4>
              <h4 v-if="user.address.formatted_address">
                {{ user.address.formatted_address }}
              </h4>
              <h4 class="text-muted" v-else>Alamat tidak tersedia</h4>
            </div>
            <div class="mt-3">
              <h4 class="font-bold">Kelompok tani</h4>
              <ul v-if="user.organizations.length">
                <li
                  v-for="organization in user.organizations"
                  :key="organization.id"
                >
                  <Link
                    class="h4 text-cyan"
                    :href="route('organization.show', organization.id)"
                    >{{ organization.name }}</Link
                  >
                  ({{ organization.pivot.member_type }})
                </li>
              </ul>
              <h4 v-else class="text-muted">
                Pengguna tidak terdaftar pada kelompok tani
              </h4>
            </div>
          </div>
        </div>
        <div class="mt-3 d-flex justify-content-between">
          <Link
            class="btn btn-warning"
            v-if="can.update"
            :href="route('user.edit', user.id)"
          >
            <i class="fa fa-edit"></i> Edit Pengguna
          </Link>
          <delete-button
            :submitUrl="route('user.destroy', user.id)"
            entity="Angota"
          >
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
import DeleteButton from "@/Components/DeleteButton.vue";

export default {
  components: {
    AuthenticatedLayout,
    Head,
    Link,
    EditUser,
    BreezeButton,
    DeleteButton,
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
