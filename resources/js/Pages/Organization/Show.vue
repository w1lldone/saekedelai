<template>
  <Head title="Detail Kelompok Tani"></Head>
  <authenticated-layout>
    <template #header>
      <InertiaLink class="text-primary" :href="route('organization.index')"
        >Kelompok tani</InertiaLink
      >
      <i class="fa fa-chevron-right mx-2"></i>Detail kelompok
    </template>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <Status class="my-2"></Status>
        <div class="card card-body p-4">
          <h3 class="text-primary font-bold">{{ organization.name }}</h3>
          <span>
            {{ organization.description }}
          </span>

          <div class="mt-3">
            <h4 class="font-bold">Lokasi</h4>
            <span>
              {{ organization.address.formatted_address }}
            </span>
          </div>
        </div>
        <div class="mt-3 d-flex justify-content-between align-items-center">
          <InertiaLink
            :href="route('organization.edit', organization.id)"
            class="btn btn-warning"
          >
            <i class="fa fa-edit"></i> Ubah Kelompok
          </InertiaLink>
          <DeleteButton
            entity="Kelompok tani"
            :submitUrl="route('organization.destroy', organization.id)"
          >
            <i class="fa fa-trash me-2"></i> Hapus kelompok tani
          </DeleteButton>
        </div>
      </div>
    </div>
  </authenticated-layout>
</template>

<script>
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/Auth.vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import Status from "@/Components/Status.vue";

export default {
  components: {
    Head,
    InertiaLink,
    AuthenticatedLayout,
    DeleteButton,
    Status,
  },
  props: {
    organization: Object,
  },
};
</script>

<style>
</style>
