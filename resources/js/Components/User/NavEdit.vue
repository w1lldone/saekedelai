<template>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <InertiaLink
        class="nav-link"
        :class="{ active: route().current('user.edit', user.id) }"
        aria-current="page"
        :href="route('user.edit', user.id)"
        >Data diri</InertiaLink
      >
    </li>
    <li class="nav-item">
      <InertiaLink
        class="nav-link"
        :class="{ active: route().current('user.address.edit', user.id) }"
        aria-current="page"
        :href="route('user.address.edit', user.id)"
        >Alamat</InertiaLink
      >
    </li>
    <li class="nav-item">
      <InertiaLink
        class="nav-link"
        :class="{ active: route().current('user.role.edit', user.id) }"
        aria-current="page"
        :href="route('user.role.edit', user.id)"
        >Role</InertiaLink
      >
    </li>
    <li class="nav-item">
      <InertiaLink
        class="nav-link"
        :class="{ active: route().current('user.organization.edit', user.id) }"
        aria-current="page"
        :href="route('user.organization.edit', user.id)"
        >Kelompok tani</InertiaLink
      >
    </li>
  </ul>
</template>

<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
  props: {
    user: Object,
  },
  components: {
    InertiaLink,
  },
};
</script>

<style>
</style>
