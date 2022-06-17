<template>
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
</template>

<script>
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import { format, formatDistanceToNow } from "date-fns";
import { id } from "date-fns/locale";

export default {
  props: {
    planting: {
      type: Object,
      default: null,
    },
  },
  components: {
    InertiaLink,
  },
  data() {
    return {
      format,
      id,
      formatDistanceToNow,
    };
  },
};
</script>

<style lang="scss" scoped>
</style>
