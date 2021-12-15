<template>
  <nav v-if="links.length > 3" aria-label="Page navigation example">
    <ul class="pagination">
      <template v-for="(link, k) in links" :key="k">
        <li v-if="link.url === null || link.active" class="page-item" :class="{ 'disabled':link.url === null, 'active': link.active }">
          <a class="page-link" href="#" v-html="link.label"></a>
        </li>
        <li v-else class="page-item">
          <Link class="page-link" :href="link.url" v-html="link.label"></Link>
        </li>
      </template>
    </ul>
  </nav>
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
