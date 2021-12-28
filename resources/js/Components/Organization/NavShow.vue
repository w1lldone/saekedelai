<template>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <InertiaLink
        class="nav-link"
        :class="{ active: route().current('organization.show', organization.id) }"
        aria-current="page"
        :href="route('organization.show', organization.id)"
        >Data kelompok</InertiaLink
      >
    </li>
    <li class="nav-item">
      <InertiaLink
        class="nav-link"
        :class="{ active: route().current('organization.user.index', organization.id) }"
        aria-current="page"
        :href="route('organization.user.index', organization.id)"
        >Anggota kelompok</InertiaLink
      >
    </li>
  </ul>
</template>

<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
  props: {
    organization: Object,
  },
  components: {
    InertiaLink,
  },
};
</script>

<style>
</style>
