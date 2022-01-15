<template>
  <div>
    <Head title="Detail lahan"></Head>
    <Auth>
      <template #header>
        <InertiaLink class="text-primary" :href="route('field.index')"
          >Lahan pertanian</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>Detail lahan
      </template>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <Status></Status>
          <div class="card card-body p-4">
            <h3 class="font-bold text-primary">Lahan #{{ field.id }}</h3>
            <div class="my-3">
              <h4 class="font-bold">Pemilik</h4>
              <span class="me-1">{{ field.user.name }}</span>
              (<span
                v-for="organization in field.user.organizations"
                :key="organization.id"
                >Poktan {{ organization.name }} </span
              >)
            </div>
            <div class="mb-3">
              <h4 class="font-bold">Luas lahan</h4>
              <span>{{ field.area }} Ha</span>
            </div>
            <div class="mb-3">
              <h4 class="font-bold">Deskripsi lahan</h4>
              <span>{{ field.description }}</span>
            </div>
            <div class="mb-3">
              <h4 class="font-bold">Lokasi</h4>
              <span>{{ field.address.formatted_address }}</span>
            </div>
          </div>
          <div class="mt-3 d-flex justify-content-between">
            <InertiaLink
              class="btn btn-warning"
              :href="route('field.edit', field.id)"
            >
              <i class="fa fa-edit"></i> Edit data lahan
            </InertiaLink>
            <DeleteButton
              entity="Lahan"
              :submitUrl="route('field.delete', field.id)"
            >
              <i class="fa fa-trash me-1"></i> Hapus lahan
            </DeleteButton>
          </div>
        </div>
      </div>
    </Auth>
  </div>
</template>

<script>
import Auth from "@/Layouts/Auth.vue";
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import DeleteButton from "@/Components/DeleteButton.vue";
import Status from '@/Components/Status.vue';

export default {
  props: {
    field: Object,
  },
  components: {
    Auth,
    InertiaLink,
    Head,
    DeleteButton,
    Status,
  },
};
</script>

<style>
</style>
