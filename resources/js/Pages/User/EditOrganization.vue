<template>
  <Head title="User Detail" />
  <AuthenticatedLayout>
    <template #header>
      <InertiaLink class="text-primary" :href="route('user.index')">Pengguna</InertiaLink>
      <i class="fa fa-chevron-right mx-2"></i>
      <InertiaLink class="text-primary" :href="route('user.show', this.user.id)"
        >Detail pengguna</InertiaLink
      >
      <i class="fa fa-chevron-right mx-2"></i>Edit
    </template>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <NavEdit :user="user" class="mb-3"></NavEdit>

        <div class="card card-body p-4 table-responsive">

            <Status></Status>

          <div class="d-flex justify-content-end">
            <OrganizationAddModal
              :organizations="organizations"
              :user="user"
            ></OrganizationAddModal>
          </div>

          <table class="table">
            <thead>
              <tr>
                <th>Nama kelompok</th>
                <th>Jenis keanggotaan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="organization in user.organizations"
                :key="organization.id"
              >
                <td>
                    <InertiaLink :href="route('organization.show', organization.id)">
                        {{ organization.name }}
                    </InertiaLink>
                </td>
                <td>{{ organization.pivot.member_type }}</td>
                <td>
                  <DeleteButton
                    entity="anggota dari kelompok"
                    :submit-url="route('user.organization.delete', [user.id, organization.id])"
                    class="btn-sm"
                    title="Keluarkan dari kelompok ini"
                  >
                    <i class="fa fa-trash"></i>
                  </DeleteButton>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/Auth.vue";
import NavEdit from "@/Components/User/NavEdit.vue";
import Status from "@/Components/Status.vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import OrganizationAddModal from "@/Components/User/OrganizationAddModal.vue";

export default {
  components: {
    AuthenticatedLayout,
    Head,
    InertiaLink,
    NavEdit,
    Status,
    DeleteButton,
    OrganizationAddModal,
  },
  props: {
    user: Object,
    organizations: Array,
  },
};
</script>

<style>
</style>
