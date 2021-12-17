<template>
  <Head title="Address"></Head>

  <AuthLayout>
    <template #header> Ubah Alamat</template>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card card-body p-4">
          <EditAddress
            :address="user.address"
            :status="status"
            :submit-url="route('user.address.update', user.id)"
          >
          </EditAddress>
          <!-- END OF COL-8 -->
        </div>
      </div>
    </div>
  </AuthLayout>
</template>

<script>
import AuthLayout from "@/Layouts/Auth.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import EditAddress from "@/Components/User/EditAddress.vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
  components: {
    AuthLayout,
    Head,
    BreezeValidationErrors,
    EditAddress,
  },
  props: {
      user: Object,
      status: String
  }
};
</script>

<style>
</style>
