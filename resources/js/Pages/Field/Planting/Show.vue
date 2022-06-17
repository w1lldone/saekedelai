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
        Detail penanaman
      </template>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <Status></Status>

          <NavShow :planting="planting"></NavShow>

          <PlantingInfo :planting="planting"></PlantingInfo>

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
              v-if="can.update"
              entity="Penanaman"
              :submitUrl="
                route('field.planting.delete', [planting.field_id, planting.id])
              "
            >
              <i class="fa fa-trash me-2"></i> Hapus data penanaman
            </delete-button>
          </div>
          <div class="mt-2">
            <div class="d-flex justify-content-between mb-3">
              <h3 class="text-primary font-bold m-0">Aktivitas Penanaman</h3>
              <div class="d-flex flex-column">
                <InertiaLink
                  class="btn btn-primary mb-2"
                  :href="route('planting.onfarm.create', planting.id)"
                >
                  <i class="fa fa-plus"></i>
                  Tambah aktivitas
                </InertiaLink>
              </div>
            </div>

            <div v-for="(onfarm, index) in planting.onfarms" :key="onfarm.id">
              <onfarm-list-item :onfarm="onfarm"></onfarm-list-item>
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
import OnfarmListItem from "@/Components/Onfarm/OnfarmListItem.vue";
import PlantingInfo from "@/Components/Planting/PlantingInfo.vue";
import NavShow from "@/Components/Planting/NavShow.vue";

export default {
  components: {
    Auth,
    Head,
    InertiaLink,
    DeleteButton,
    Status,
    DeleteButton,
    OnfarmListItem,
    PlantingInfo,
    NavShow,
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
