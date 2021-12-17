<template>
  <Head title="User Detail" />
  <AuthenticatedLayout>
    <template #header>
      <Link class="text-primary" :href="route('user.index')">Users List</Link>
      <i class="fa fa-chevron-right mx-2"></i>
      <Link class="text-primary" :href="route('user.show', this.user.id)"
        >Users Details</Link
      >
      <i class="fa fa-chevron-right mx-2"></i>Edit
    </template>

    <div class="row justify-content-center">
      <div class="col-md-6">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button
              class="nav-link active"
              id="pills-basic-tab"
              data-bs-toggle="pill"
              data-bs-target="#pills-basic"
              type="button"
              role="tab"
              aria-controls="pills-basic"
              aria-selected="true"
            >
              Basic Info
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="pills-address-tab"
              data-bs-toggle="pill"
              data-bs-target="#pills-address"
              type="button"
              role="tab"
              aria-controls="pills-address"
              aria-selected="false"
            >
              Address
            </button>
          </li>
        </ul>

        <div class="card card-body p-4">
          <BreezeValidationErrors class="mb-4" />

          <div
            v-if="status"
            class="alert alert-success alert-dismissible fade show"
            role="alert"
          >
            <strong>Success!</strong> {{ status }}
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="alert"
              aria-label="Close"
            ></button>
          </div>

          <div class="tab-content" id="pills-tabContent">
            <div
              class="tab-pane fade show active"
              id="pills-basic"
              role="tabpanel"
              aria-labelledby="pills-basic-tab"
            >
              <EditUserBasic
                :user="user"
                :submit-route="route('user.update', user.id)"
                @success="isEditing = false"
              ></EditUserBasic>
            </div>
            <div
              class="tab-pane fade"
              id="pills-address"
              role="tabpanel"
              aria-labelledby="pills-address-tab"
            >
              <EditAddress
                :address="user.address"
                :submit-url="route('user.address.update', user.id)"
              ></EditAddress>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/Auth.vue";
import EditUserBasic from "@/Components/User/Edit.vue";
import EditAddress from "@/Components/User/EditAddress.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";

export default {
  components: {
    BreezeValidationErrors,
    AuthenticatedLayout,
    Head,
    Link,
    EditUserBasic,
    EditAddress,
  },
  props: {
    user: Object,
    status: String,
  },
};
</script>

<style>
</style>
