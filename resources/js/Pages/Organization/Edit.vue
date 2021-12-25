<template>
  <Head title="Ubah Organisasi"></Head>
  <authenticated>
    <template #header>
      <InertiaLink class="text-primary" :href="route('organization.index')"
        >Kelompok tani</InertiaLink
      >
      <i class="fa fa-chevron-right mx-2"></i>
      <InertiaLink
        class="text-primary"
        :href="route('organization.show', organization.id)"
        >Detail kelompok</InertiaLink
      >
      <i class="fa fa-chevron-right mx-2"></i>Ubah kelompok
    </template>

    <div class="row justify-content-lg-center">
      <div class="col-md-7">
        <div class="card card-body p-4">
          <OrganizationForm
            :submit-url="route('organization.update', organization.id)"
            :init-organization="organization"
            method="put"
          >
          </OrganizationForm>
        </div>
      </div>
    </div>
  </authenticated>
</template>

<script>
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import Authenticated from "@/Layouts/Auth.vue";
import OrganizationForm from "@/Components/Organization/Form.vue";

export default {
  props: {
    organization: Object,
  },
  components: { Authenticated, InertiaLink, Head, OrganizationForm },
};
</script>

<style>
</style>
