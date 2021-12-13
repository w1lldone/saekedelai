<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap -mb-1">
      <template v-for="(link, k) in links" :key="k">
        <div
          v-if="link.url === null || link.active"
          class="
            mr-1
            mb-1
            px-4
            py-3
            text-sm
            leading-4
            border
            rounded
          "
          :class="{ 'bg-blue-700 text-white': link.active, 'text-gray-400': link.active == false }"
          v-html="link.label"
        />
        <Link
          v-else
          class="
            mr-1
            mb-1
            px-4
            py-3
            text-sm
            leading-4
            border
            rounded
            hover:bg-white
            focus:border-indigo-500 focus:text-indigo-500
          "
          :href="link.url"
          v-html="link.label"
        />
      </template>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
      Link,
  },
  props: {
    links: Array,
  },
};
</script>
