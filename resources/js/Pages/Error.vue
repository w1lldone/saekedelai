<template>
  <Head title="Confirm Password" />

  <div class="text-center">
      <h1 class="text-md font-bold">{{ title }}</h1>
  </div>
  <div class="my-4 text-sm text-center text-gray-600">
    {{ description }}
  </div>
</template>

<script>
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
  layout: BreezeGuestLayout,

  components: {
    Head,
  },

  props: {
    status: Number,
  },
  computed: {
    title() {
      return {
        503: "503: Service Unavailable",
        500: "500: Server Error",
        404: "404: Page Not Found",
        403: "403: Forbidden",
      }[this.status];
    },
    description() {
      return {
        503: "Sorry, we are doing some maintenance. Please check back soon.",
        500: "Whoops, something went wrong on our servers.",
        404: "Sorry, the page you are looking for could not be found.",
        403: "Sorry, you are forbidden from accessing this page.",
      }[this.status];
    },
  },
};
</script>
