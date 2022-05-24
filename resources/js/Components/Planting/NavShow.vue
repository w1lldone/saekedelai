<template>
  <div class="card p-2">
    <ul class="nav nav-pills">
      <li class="nav-item">
        <InertiaLink
          class="nav-link"
          :class="{
            active: route().current('field.planting.show', [
              planting.field_id,
              planting.id,
            ]),
          }"
          aria-current="page"
          :href="route('field.planting.show', [planting.field_id, planting.id])"
          >Detail penanaman</InertiaLink
        >
      </li>
      <li class="nav-item">
        <InertiaLink
          class="nav-link"
          :class="{
            active: route().current('field.planting.postharvest', [
              planting.field_id,
              planting.id,
            ]),
          }"
          aria-current="page"
          :href="
            route('field.planting.postharvest', [
              planting.field_id,
              planting.id,
            ])
          "
          >Pasca panen</InertiaLink
        >
      </li>
      <li class="nav-item">
        <InertiaLink
          class="nav-link"
          :class="{
            active: route().current('field.planting.product', [
              planting.field_id,
              planting.id,
            ]),
          }"
          aria-current="page"
          :href="
            route('field.planting.product', [
              planting.field_id,
              planting.id,
            ])
          "
          >Produk dan pengemasan</InertiaLink
        >
      </li>
    </ul>
  </div>
</template>

<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
  props: {
    planting: Object,
  },
  components: {
    InertiaLink,
  },
};
</script>

<style>
</style>
