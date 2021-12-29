<template>
  <Head title="Anggota kelompok tani"></Head>
  <authenticated-layout>
    <template #header>
      <InertiaLink class="text-primary" :href="route('organization.index')"
        >Kelompok tani</InertiaLink
      >
      <i class="fa fa-chevron-right mx-2"></i>Anggota kelompok
    </template>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <NavShow :organization="organization" class="mb-3"></NavShow>

        <div class="d-flex justify-content-end mb-3">
          <UserAddModal :organization="organization"></UserAddModal>
        </div>

        <div class="card card-body p-4">
          <Status class="my-2"></Status>

          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Nama anggota</th>
                  <th>Tipe anggota</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users.data" :key="user.id">
                  <td>
                      <InertiaLink :href="route('user.show', user.id)">
                          {{ user.name }}
                      </InertiaLink>
                  </td>
                  <td>{{ user.pivot.member_type }}</td>
                  <td>
                    <DeleteButton
                      class="btn-sm"
                      entity="anggota pada organisasi"
                      :submitUrl="
                        route('user.organization.delete', [
                          user.id,
                          organization.id,
                        ])
                      "
                    >
                      <i class="fa fa-trash"></i>
                    </DeleteButton>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <pagination :links="users.links"></pagination>
        </div>
      </div>
    </div>
  </authenticated-layout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Auth.vue";
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import NavShow from "@/Components/Organization/NavShow.vue";
import Status from "@/Components/Status.vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import UserAddModal from "@/Components/Organization/UserAddModal.vue";

export default {
  props: {
    users: Object,
    organization: Object,
  },
  components: {
    AuthenticatedLayout,
    Head,
    InertiaLink,
    Pagination,
    NavShow,
    Status,
    DeleteButton,
    UserAddModal,
  },
};
</script>

<style>
</style>
