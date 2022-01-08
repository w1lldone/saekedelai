<template>
  <ul class="nav nav-pills">
    <li class="nav-item">
      <Link class="nav-link" :class="{ active: route().current('profile.index') }" aria-current="page" :href="route('profile.index')">Data diri</Link>
    </li>
    <li class="nav-item">
      <Link class="nav-link" :class="{ active: route().current('profile.address.edit') }" aria-current="page" :href="route('profile.address.edit')">Alamat</Link>
    </li>
  </ul>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link
    }
};
</script>

<style>
</style>
