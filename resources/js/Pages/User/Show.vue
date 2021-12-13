<template>
  <Head title="User Detail" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <Link class="text-blue-800" :href="route('user.index')"
          >Users List</Link
        >
        <i class="fa fa-chevron-right mx-2"></i>User Details
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div v-if="status">
          <div
            class="
              flex
              items-center
              bg-green-100
              rounded-lg
              p-4
              mb-4
              text-sm text-green-700
            "
            role="alert"
          >
            <i class="fa fa-info-circle"></i>
            <div class="pl-2">
              <span class="font-medium">Success!</span> {{ status }}
            </div>
          </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
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
                <h3 v-if="user.phone_number" class="font-semibold text-xl text-gray-800">
                  {{ user.phone_number }}
                </h3>
                <h3 v-else class="text-gray-400">
                    Tidak tersedia
                </h3>
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

              <div class="mt-3 flex justify-end">
                <BreezeButton v-if="can.update" @click="isEditing = true"> Edit </BreezeButton>
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
    </div>
  </AuthenticatedLayout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
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
