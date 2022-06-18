<template>
  <Head title="Lahan pertanian"></Head>
  <Auth>
    <template #header> Lahan pertanian </template>
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="row mb-3 align-items-end justify-content-between">
          <div class="col-md-9">
            <Filter
              :submitUrl="route('field.index')"
              :queries="queries"
            ></Filter>
          </div>
          <div class="col-md-3 d-flex">
            <InertiaLink
              class="btn btn-primary ms-auto"
              :href="route('field.create')"
            >
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
                  <th style="width: 20%">Aksi</th>
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
                    <span>{{ field.description }} </span>
                  </td>
                  <td>
                    <InertiaLink
                      class="btn btn-primary me-1"
                      data-tippy-content="Lihat detail lahan"
                      :href="route('field.show', field.id)"
                    >
                      <i class="fa fa-eye"></i>
                    </InertiaLink>
                    <InertiaLink
                      data-tippy-content="Lihat riwayat penanaman"
                      class="btn btn-success text-white me-1"
                      :href="route('field.planting.index', field.id)"
                    >
                      <i class="far fa-calendar-alt"></i>
                    </InertiaLink>
                    <InertiaLink
                      data-tippy-content="Kelola penanaman terkini"
                      v-if="field.last_planting"
                      class="btn btn-info text-white"
                      :href="
                        route('field.planting.show', [
                          field.id,
                          field.last_planting_id,
                        ])
                      "
                    >
                      <i class="fa fa-seedling"></i>
                    </InertiaLink>
                  </td>
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
  components: {
    Head,
    InertiaLink,
    Auth,
    Pagination,
    Filter,
    Status,
  },
  data() {
    return {
      fields: this.initialFields,
    };
  },
};
</script>

<style>
</style>
