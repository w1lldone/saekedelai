<template>
  <button
    @click="submit()"
    data-bs-toggle="tooltip"
    class="btn btn-outline-danger"
    :class="{ disabled: form.processing }"
    method="delete"
  >
    <slot></slot>
  </button>
</template>

<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
  props: {
    submitUrl: String,
    entity: String,
    preserveScroll: {
      type: Boolean,
      default: false,
    },
  },
  components: {
    InertiaLink,
  },
  data() {
    return {
      form: this.$inertia.form({}),
    };
  },
  methods: {
    submit() {
      if (!confirm(`Anda akan menghapus ${this.entity} ini, teruskan?`)) {
        return;
      }

      this.form.delete(this.submitUrl, {
        preserveScroll: this.preserveScroll,
      });
    },
  },
};
</script>

<style>
</style>
