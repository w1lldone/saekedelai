<template>
  <div>
    <Head title="Detail Penanaman"></Head>
    <Auth>
      <template #header>
        <InertiaLink class="text-primary" :href="route('field.index')"
          >Lahan pertanian</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        <InertiaLink
          class="text-primary"
          :href="route('field.show', planting.field_id)"
          >Detail lahan</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        <InertiaLink
          class="text-primary"
          :href="route('field.planting.index', planting.field_id)"
          >Penanaman</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        Detail penanaman
      </template>

      <div class="row justify-content-center">
        <div class="col-md-8">

          <Status></Status>

          <div class="card card-body p-4">
            <h3 class="text-primary font-bold">
              Penanaman Bulan
              {{
                format(new Date(planting.started_at), "MMMM", {
                  locale: id,
                })
              }}
            </h3>
            <div class="row mt-3">
              <div class="col-md-6 d-flex align-items-start">
                <div class="me-3">
                  <i class="fa fa-user fa-2x text-success"></i>
                </div>
                <div>
                  <b>Pemilik Lahan</b><br />
                  <span>{{ planting.field.user.name }}</span>
                </div>
              </div>
              <div class="col-md-6 d-flex align-items-start">
                <div class="me-3">
                  <i class="fas fa-ruler-combined fa-2x text-success"></i>
                </div>
                <div>
                  <b>Luas Lahan</b><br />
                  <span>{{ planting.field.area }} Ha</span>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-6 d-flex align-items-start">
                <div class="me-3">
                  <i class="fa fa-seedling fa-2x text-success"></i>
                </div>
                <div>
                  <b>Tanggal tanam</b><br />
                  <span>{{
                    format(new Date(planting.started_at), "d MMMM yyyy", {
                      locale: id,
                    })
                  }}</span>
                </div>
              </div>
              <div class="col-md-6 d-flex align-items-start">
                <div class="me-3">
                  <i class="fab fa-pagelines fa-2x text-success"></i>
                </div>
                <div>
                  <b>Tanggal panen</b><br />
                  <span v-if="planting.harvested_at">{{
                    format(new Date(planting.harvested_at), "d MMMM yyyy", {
                      locale: id,
                    })
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
                  <span>Varietas: {{ planting.seed_variety }}</span
                  ><br />
                  <span>Kuantitas: {{ planting.seed_quantity }} kg</span>
                </div>
              </div>
            </div>
          </div>

          <div class="my-3 d-flex justify-content-between">
            <InertiaLink
              class="btn btn-warning"
              :href="
                route('field.planting.edit', [planting.field_id, planting.id])
              "
            >
              <i class="fa fa-edit"></i> Edit penanaman
            </InertiaLink>
            <delete-button
              entity="Penanaman"
              :submitUrl="
                route('field.planting.delete', [planting.field_id, planting.id])
              "
            >
              <i class="fa fa-trash me-2"></i> Hapus data penanaman
            </delete-button>
          </div>

          <div class="mt-5">
            <h3 class="text-primary font-bold mb-3">Aktivitas Penanaman</h3>

            <div v-for="(onfarm, index) in planting.onfarms" :key="onfarm.id">
              <div class="card m-0 card-body p-4">
                <div class="d-flex">
                  <i class="fa fa-seedling me-3 fa-2x"></i>
                  <div class="flex-grow-1">
                    <h4>{{ onfarm.activity }}</h4>
                    <div v-if="onfarm.cost">
                      <i class="fas fa-coins"></i> Biaya : Rp{{
                        onfarm.cost.toLocaleString("id-ID")
                      }},00
                    </div>
                    <p>{{ onfarm.notes }}</p>
                  </div>
                  <div class="text-end">
                    {{
                      formatDistanceToNow(new Date(onfarm.timestamp), {
                        locale: id,
                        addSuffix: true,
                      })
                    }}
                  </div>
                </div>
                <div class="row ps-4 mt-3">
                  <div
                    v-for="media in onfarm.media"
                    class="col-md-4"
                    :key="media.id"
                  >
                    <img
                      :src="route('onfarm.media.show', [onfarm.id, media.id])"
                      alt=""
                      class="img-fluid rounded img-thumbnail"
                    />
                    <div class="mt-2">{{ media.name }}</div>
                  </div>
                </div>
              </div>
              <div
                class="text-center"
                v-if="index + 1 != planting.onfarms.length"
              >
                <div class="line"></div>
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
import { format, formatDistanceToNow } from "date-fns";
import { id } from "date-fns/locale";
import DeleteButton from "@/Components/DeleteButton.vue";
import Status from "@/Components/Status.vue";

export default {
  components: {
    Auth,
    Head,
    InertiaLink,
    DeleteButton,
    Status,
  },
  props: {
    planting: Object,
    can: Object,
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

<style scoped>
.line {
  left: 5%;
  position: relative;
  border-left: 4px solid green;
  opacity: 0.6;
  height: 2rem;
}
</style>
