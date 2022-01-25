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

      <!-- Last Planting -->
      <div class="row justify-content-center mt-5" v-if="field.last_planting">
        <div class="col-md-8">
          <div class="card card-body p-4">
            <h3 class="font-bold text-primary">
              <InertiaLink
                :href="
                  route('field.planting.show', [
                    field.id,
                    field.last_planting.id,
                  ])
                "
                >Penanaman Terkini <i class="fa fa-link"></i
              ></InertiaLink>
            </h3>

            <div class="row mt-3">
              <div class="col-md-6 d-flex align-items-start">
                <div class="me-3">
                  <i class="fa fa-seedling fa-2x text-success"></i>
                </div>
                <div>
                  <b>Tanggal tanam</b><br />
                  <span>{{
                    format(
                      new Date(field.last_planting.started_at),
                      "d MMMM yyyy",
                      {
                        locale: id,
                      }
                    )
                  }}</span>
                </div>
              </div>
              <div class="col-md-6 d-flex align-items-start">
                <div class="me-3">
                  <i class="fab fa-pagelines fa-2x text-success"></i>
                </div>
                <div>
                  <b>Tanggal panen</b><br />
                  <span v-if="field.last_planting.harvested_at">{{
                    format(
                      new Date(field.last_planting.harvested_at),
                      "d MMMM yyyy",
                      {
                        locale: id,
                      }
                    )
                  }}</span>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-6 d-flex align-items-start">
                <div class="me-3">
                  <i class="fa fa-archive fa-2x text-success"></i>
                </div>
                <div>
                  <b>Informasi bibit</b><br />
                  <span>Varietas: {{ field.last_planting.seed_variety }}</span
                  ><br />
                  <span
                    >Kuantitas: {{ field.last_planting.seed_quantity }} kg</span
                  >
                </div>
              </div>
              <div
                class="col-md-6 d-flex align-items-start"
                v-if="field.last_activity"
              >
                <div class="me-3">
                  <i class="fa fa-calendar-check fa-2x text-success"></i>
                </div>
                <div>
                  <b>Aktivitas Terkini</b><br />
                  <span>{{ field.last_activity.activity }}</span
                  ><br />
                  <span>{{
                    format(
                      new Date(field.last_activity.timestamp),
                      "d MMMM yyyy",
                      {
                        locale: id,
                      }
                    )
                  }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="mt-3 text-center">
            <InertiaLink
              :href="route('field.planting.index', field.id)"
              class="btn btn-outline-primary"
            >
              Lihat Semua Riwayat Penanaman
            </InertiaLink>
          </div>
        </div>
      </div>
      <div v-else class="row justify-content-center mt-5">
        <div class="col-md-8">
          <div class="card card-body p-4 text-center d-flex">
            <h3 class="text-muted">Lahan ini belum punya riwayat penanaman</h3>
          </div>
          <div class="mt-3 text-center">
              <InertiaLink
                :href="route('field.planting.create', field.id)"
                class="btn btn-outline-primary"
                ><i class="fa fa-plus"></i> Tambah data penanaman</InertiaLink
              >
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
import Status from "@/Components/Status.vue";
import { format } from "date-fns";
import { id } from "date-fns/locale";

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
  setup() {
    return {
      format,
      id,
    };
  },
};
</script>

<style>
</style>
