<template>
  <div>
    <button class="btn btn-outline-info">
      <i class="fa fa-plus"></i> Unggah foto
    </button>
  </div>
</template>

<script>
export default {
  props: {
    submitUrl: String,
  },
  data() {
    return {
      form: this.$inertia.form({}),
    };
  },
};
</script>

<style>
</style>
