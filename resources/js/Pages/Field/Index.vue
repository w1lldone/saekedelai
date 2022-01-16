<template>
  <Head title="Users List"></Head>
  <Auth>
    <template #header> Lahan pertanian </template>
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="row mb-3 align-items-end justify-content-between">
          <div class="col-md-9">
            <Filter
              :submitUrl="route('field.index')"
              :queries="queries"
            ></Filter>
          </div>
          <div class="col-md-3 d-flex">
            <InertiaLink class="btn btn-primary ms-auto" :href="route('field.create')">
              <i class="fa fa-plus me-2"></i> Daftarkan lahan
            </InertiaLink>
          </div>
        </div>
        <Status></Status>
        <div class="card card-body p-4">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Pemilik</th>
                  <th>Lokasi lahan</th>
                  <th>Luas (Ha)</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="field in fields.data" :key="field.id">
                  <td>
                    <InertiaLink :href="route('field.show', field.id)"
                      >#{{ field.id }}</InertiaLink
                    >
                  </td>
                  <td>
                    {{ field.user.name }} <br />
                    <small v-if="field.user.organizations.length">
                      Poktan {{ field.user.organizations[0].name }}
                    </small>
                  </td>
                  <td>
                    <InertiaLink :href="route('field.show', field.id)"
                      ><b>{{ field.address.formatted_address }}</b></InertiaLink
                    ><br />
                    <span>{{ field.description }}</span>
                  </td>
                  <td>{{ field.area }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <pagination :links="fields.links"></pagination>
        </div>
      </div>
    </div>
  </Auth>
</template>

<script>
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import Auth from "@/Layouts/Auth.vue";
import Status from "@/Components/Status.vue";
import Pagination from "@/Components/Pagination.vue";
import Filter from "@/Components/Field/Filter.vue";

export default {
  props: {
    initialFields: Object,
    queries: Object,
  },
  data() {
    return {
      fields: this.initialFields,
    };
  },
  components: {
    Head,
    InertiaLink,
    Auth,
    Pagination,
    Filter,
    Status,
  },
};
</script>

<style>
</style>
