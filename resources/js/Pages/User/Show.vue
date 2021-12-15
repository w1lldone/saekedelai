<template>
  <Head title="User Detail" />

  <AuthenticatedLayout>
    <template #header>
      <Link class="text-primary" :href="route('user.index')">Users List</Link>
      <i class="fa fa-chevron-right mx-2"></i>User Details
    </template>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-body p-4">
          <div v-if="isEditing == false">
            <div>
              <span class="font-semibold text-gray-400">Nama</span>
              <h3 class="font-semibold text-xl text-gray-800">
                {{ user.name }}
              </h3>
            </div>
            <div class="mt-3">
              <span class="font-semibold text-gray-400">Email</span>
              <h3 class="font-semibold text-xl text-gray-800">
                {{ user.email }}
              </h3>
            </div>
            <div class="mt-3">
              <span class="font-semibold text-gray-400">No Hp</span>
              <h3
                v-if="user.phone_number"
                class="font-semibold text-xl text-gray-800"
              >
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

            <div class="mt-3 d-flex justify-content-end">
              <button
                class="btn btn-primary"
                v-if="can.update"
                @click="isEditing = true"
              >
                Edit
              </button>
            </div>
          </div>
          <div v-else>
            <EditUser
              :user="user"
              :submit-route="route('user.update', user.id)"
              @success="isEditing = false"
            ></EditUser>
          </div>
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

export default {
  components: {
    AuthenticatedLayout,
    Head,
    Link,
    EditUser,
    BreezeButton,
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
