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
            <div class="row my-3">
              <div class="col-md-6">
                <h4 class="font-bold">Pemilik</h4>
                <span class="me-1">{{ field.user.name }}</span>
                (<span
                  v-for="organization in field.user.organizations"
                  :key="organization.id"
                  >Poktan {{ organization.name }} </span
                >)
              </div>
              <div class="col-md-6">
                <h4 class="font-bold">Luas lahan</h4>
                <span>{{ field.area }} Ha</span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <h4 class="font-bold">Deskripsi lahan</h4>
                <span>{{ field.description }}</span>
              </div>
              <div class="col-md-6">
                <h4 class="font-bold">Lokasi</h4>
                <span>{{ field.address.formatted_address }}</span>
              </div>
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

          <div class="my-4"></div>

          <!-- Last Planting -->
          <div class="card card-body p-4" v-if="plantings.data">
            <div class="d-flex justify-content-between">
              <h3 class="text-primary font-bold">
                Riwayat Penanaman Lahan #{{ field.id }}
              </h3>
              <InertiaLink
                :href="route('field.planting.create', field.id)"
                class="btn btn-primary"
              >
                <i class="fa fa-plus"></i> Tambah penanaman
              </InertiaLink>
            </div>
            <div>Lokasi: {{ field.address.formatted_address }}</div>
            <div>Pemilik Lahan: {{ field.user.name }}</div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Periode tanam</th>
                    <th>Tanggal tanam</th>
                    <th>Tanggal panen</th>
                    <th>Aktivitas Terkini</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="planting in plantings.data" :key="planting.id">
                    <td>
                      <InertiaLink
                        :href="
                          route('field.planting.show', [field.id, planting.id])
                        "
                      >
                        Penanaman bulan
                        {{
                          format(new Date(planting.started_at), "MMMM", {
                            locale: id,
                          })
                        }}
                      </InertiaLink>
                    </td>
                    <td>
                      {{
                        format(new Date(planting.started_at), "dd MMM yyyy", {
                          locale: id,
                        })
                      }}
                    </td>
                    <td>
                      <span v-if="planting.harvested_at">
                        {{
                          format(
                            new Date(planting.harvested_at),
                            "dd MMMM yyyy",
                            {
                              locale: id,
                            }
                          )
                        }}
                      </span>
                      <span v-else> Belum dipanen </span>
                    </td>
                    <td>
                      <span v-if="planting.last_onfarm">
                        {{ planting.last_onfarm.activity }}
                        <small>{{
                          formatDistanceToNow(
                            new Date(planting.last_onfarm.started_at),
                            {
                              addSuffix: true,
                              locale: id,
                            }
                          )
                        }}</small>
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div v-else class="row justify-content-center mt-5">
            <div class="col-md-8">
              <div class="card card-body p-4 text-center d-flex">
                <h3 class="text-muted">
                  Lahan ini belum punya riwayat penanaman
                </h3>
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
import { format, formatDistanceToNow } from "date-fns";
import { id } from "date-fns/locale";

export default {
  props: {
    field: Object,
    plantings: Object,
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
      formatDistanceToNow,
    };
  },
};
</script>

<style>
</style>
