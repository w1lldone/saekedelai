<template>
  <div>
    <Head title="Penanaman"></Head>

    <Auth>
      <template #header>
        <InertiaLink class="text-primary" :href="route('field.index')"
          >Lahan pertanian</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        <InertiaLink class="text-primary" :href="route('field.show', field.id)"
          >Detail lahan</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        Penanaman
      </template>

      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="text-end mb-2">
            <InertiaLink
              :href="route('field.planting.create', field.id)"
              class="btn btn-primary"
            >
              <i class="fa fa-plus"></i> Tambah penanaman
            </InertiaLink>
          </div>

          <Status></Status>

          <div class="card card-body p-4">
            <h3 class="text-primary font-bold">
              Riwayat Penanaman Lahan #{{ field.id }}
            </h3>
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
        </div>
      </div>
    </Auth>
  </div>
</template>

<script>
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import Auth from "@/Layouts/Auth.vue";
import { format, formatDistanceToNow } from "date-fns";
import { id } from "date-fns/locale";
import Status from "@/Components/Status.vue";

export default {
  props: {
    plantings: Object,
    field: Object,
  },
  components: {
    Head,
    InertiaLink,
    Auth,
    Status,
  },
  setup() {
    return {
      format,
      formatDistanceToNow,
      id,
    };
  },
};
</script>

<style>
</style>
