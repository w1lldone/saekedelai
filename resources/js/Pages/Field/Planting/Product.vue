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
        Produk
      </template>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <Status></Status>

          <PlantingInfo :planting="planting"></PlantingInfo>

          <NavShow :planting="planting" class="my-2"></NavShow>

          <div class="mt-3">
            <h3 class="text-primary font-bold">Produk rilis</h3>
          </div>
          <div
            v-if="!planting.production_date"
            class="text-center p-4 border my-3"
          >
            <h3 class="text-muted">Tambahkan data produk rilis</h3>
            <InertiaLink
              class="btn btn-success"
              :href="route('planting.product.create', planting.id)"
              ><i class="fa fa-plus"></i> Produk rilis</InertiaLink
            >

          </div>
          <div class="card card-body px-4 py-3" v-if="planting.production_date">
            <div class="row">
              <div class="col-md-6 mb-2">
                <b>Tanggal produksi</b><br />
                <span>
                  {{
                    format(new Date(planting.production_date), "d MMMM yyyy", {
                      locale: id,
                    })
                  }}
                </span>
              </div>
              <div class="col-md-6 mb-2">
                <b>No batch</b><br />
                <span>{{ planting.product_batch }}</span>
              </div>
              <div class="col-md-6 mb-2">
                <b>Tanggal kadaluarsa</b><br />
                <span>
                  {{
                    format(new Date(planting.expired_date), "d MMMM yyyy", {
                      locale: id,
                    })
                  }}
                </span>
              </div>
              <div class="col-md-6 mb-2">
                <b>Petugas</b><br />
                <span>{{ planting.product_processor }}</span>
              </div>
            </div>
          </div>
          <div class="card card-body px-4 py-3" v-if="planting.production_date && planting.product_quality">
              <Quality :quality="planting.product_quality"></Quality>
          </div>
          <div class="pb-3" v-if="planting.production_date">
            <InertiaLink
              class="btn btn-warning"
              :href="route('planting.product.create', planting.id)"
              ><i class="fa fa-edit"></i> Edit produk rilis</InertiaLink
            >
          </div>
          <div class="mt-3 mb-2 d-flex justify-content-between">
              <h3 class="text-primary font-bold">Pengemasan</h3>
              <InertiaLink class="btn btn-primary" :href="route('planting.packing.create', planting.id)">
                  <i class="fa fa-plus"></i> Tambah pengemasan
              </InertiaLink>
          </div>
          <div class="card card-body px-4 py-3">
            <div class="mt-2">
              <table class="table">
                <thead>
                  <tr>
                    <th>No Karung</th>
                    <th>Berat kedelai</th>
                    <th>Status</th>
                    <table>Aksi</table>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="packing in planting.packings" :key="packing.id">
                    <td>{{ packing.packing_number }}</td>
                    <td>{{ packing.quantity }} Kg</td>
                    <td>Disimpan</td>
                    <td>
                        <DeleteButton :submit-url="route('planting.packing.delete', [planting.id, packing.id])" entity="Packing" :preserve-scroll="true">
                            <i class="fa fa-trash"></i>
                        </DeleteButton>
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
import Auth from "@/Layouts/Auth.vue";
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import { format, formatDistanceToNow } from "date-fns";
import { id } from "date-fns/locale";
import Status from "@/Components/Status.vue";
import PlantingInfo from "@/Components/Planting/PlantingInfo.vue";
import NavShow from "@/Components/Planting/NavShow.vue";
import Quality from '@/Components/Planting/Quality.vue';
import DeleteButton from '@/Components/DeleteButton.vue';

export default {
  components: {
    Auth,
    Head,
    InertiaLink,
    Status,
    PlantingInfo,
    NavShow,
    Quality,
    DeleteButton
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
