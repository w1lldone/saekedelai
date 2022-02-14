<template>
  <div>
    <div class="card m-0 card-body p-4" :id="onfarm.id">
      <div class="d-flex">
        <i class="fa fa-seedling me-3 fa-2x"></i>
        <div class="flex-grow-1">
          <h4>{{ onfarm.name }}</h4>
          <div class="text-secondary">
          {{
            format(new Date(onfarm.started_at), "d MMMM yyyy", {
              locale: id,
            })
          }}
          <span v-if="onfarm.finished_at">
            &ndash;{{
              format(new Date(onfarm.finished_at), "d MMMM yyyy", {
                locale: id,
              })
            }}
          </span>
        </div>
          <div v-html="onfarm.description"></div>
        </div>
      </div>
      <div class="ps-5 mt-3" v-if="onfarm.media.length">
        <Carousel :items-to-show="2.5" :wrap-around="true">
          <Slide class="mx-3" v-for="media in onfarm.media" :key="media.id">
            <img
              :src="route('onfarm.media.show', [onfarm.id, media.id])"
              alt=""
              class="img-fluid rounded img-thumbnail"
            />
            <delete-button
              :preserveScroll="true"
              entity="Foto"
              :submitUrl="route('onfarm.media.delete', [onfarm.id, media.id])"
              class="btn-sm position-absolute top-0 end-0"
            >
              <i class="fa fa-trash"></i>
            </delete-button>
          </Slide>

          <template #addons>
            <Navigation />
          </template>
        </Carousel>
      </div>
      <div class="d-flex justify-content-center mt-3">
        <onfarm-media-upload
          class="py-2"
          :submit-url="route('onfarm.media.store', onfarm.id)"
        ></onfarm-media-upload>
      </div>
      <div class="ps-5 mt-3">
        <div class="border rounded p-3 border-dark">
          <div class="mb-1 font-bold">Rincian biaya</div>
          <div
            v-for="cost in onfarm.costs"
            :key="cost.description"
            class="d-flex justify-content-between py-1"
          >
            <div>
              {{ cost.description }}
            </div>
            <div>Rp{{ cost.value.toLocaleString("id-ID") }},00</div>
          </div>
          <hr />
          <div class="d-flex justify-content-between font-bold">
            <div>Total biaya</div>
            <div>Rp{{ onfarm.total_cost.toLocaleString("id-ID") }},00</div>
          </div>
        </div>
        <div class="d-flex justify-content-between mt-2">
          <InertiaLink
            :href="
              route('planting.onfarm.edit', [onfarm.planting_id, onfarm.id])
            "
            class="btn btn-warning"
          >
            <i class="fa fa-edit"></i> Edit aktivitas
          </InertiaLink>
          <delete-button
            entity="Aktivitas"
            :submitUrl="
              route('planting.onfarm.delete', [onfarm.planting_id, onfarm.id])
            "
            ><i class="fa fa-trash"></i> Hapus aktivitas</delete-button
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { format, formatDistanceToNow } from "date-fns";
import { InertiaLink } from "@inertiajs/inertia-vue3";
import { id } from "date-fns/locale";
import DeleteButton from "@/Components/DeleteButton.vue";
import OnfarmMediaUpload from "@/Components/Onfarm/OnfarmMediaUpload.vue";
import { Carousel, Navigation, Slide } from "vue3-carousel";
import "vue3-carousel/dist/carousel.css";

export default {
  props: {
    onfarm: {
      type: Object,
    },
  },
  components: {
    DeleteButton,
    OnfarmMediaUpload,
    Carousel,
    Slide,
    Navigation,
    InertiaLink,
  },
  data() {
    return {
      format,
      id,
    };
  },
};
</script>

<style lang="scss" scoped>
</style>
