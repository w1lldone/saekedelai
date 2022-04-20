<template>
  <div>
    <Head title="Detail Penanaman"></Head>
    <Auth>
      <template #header>
        ...
        <i class="fa fa-chevron-right mx-2"></i>
        <InertiaLink
          class="text-primary"
          :href="route('field.planting.index', planting.field_id)"
          >Penanaman</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        <InertiaLink
          class="text-primary"
          :href="route('field.planting.show', [planting.field_id, planting.id])"
          >Detail penanaman</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        Pasca panen
      </template>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <Status></Status>

          <PlantingInfo :planting="planting"></PlantingInfo>

          <NavShow :planting="planting" class="my-2"></NavShow>

          <HarvestInfo class="mt-3" :planting="planting"></HarvestInfo>

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
import HarvestInfo from "@/Components/Planting/HarvestInfo.vue";
import PlantingInfo from '@/Components/Planting/PlantingInfo.vue';
import NavShow from '@/Components/Planting/NavShow.vue';

export default {
  components: {
    Auth,
    Head,
    InertiaLink,
    DeleteButton,
    Status,
    DeleteButton,
    HarvestInfo,
    PlantingInfo,
    NavShow
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
