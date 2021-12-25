<template>
  <div
    v-if="status"
    class="alert alert-success alert-dismissible fade show"
    role="alert"
  >
    <strong>Success!</strong> {{ status }}
    <button
      type="button"
      class="btn-close"
      data-bs-dismiss="alert"
      aria-label="Close"
    ></button>
  </div>
</template>

<script>
export default {
  computed: {
    status: function () {
      return this.$page.props.status;
    },
  },
};
</script>

<style>
</style>
