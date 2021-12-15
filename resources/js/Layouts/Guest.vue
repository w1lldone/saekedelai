<template>
  <div class="py-5 bg-gray full-height">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-3 mb-4">
          <a href="/">
            <BreezeApplicationLogo class="img-fluid" />
          </a>
        </div>
      </div>
      <div class="row justify-content-center mt-3">
        <div class="col-md-4">
          <div class="card p-4">
            <slot />
          </div>
        </div>
      </div>
      <slot name="outside" />
    </div>
  </div>
</template>

<script>
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    BreezeApplicationLogo,
    Link,
  },
};
</script>

<style scoped>
    .bg-gray {
        background: #e9ecef;
    }

    .full-height {
        min-height: 100vh;
    }
</style>
