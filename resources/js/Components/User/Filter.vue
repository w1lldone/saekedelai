<template>
  <form @submit.prevent="submit()">
    <div class="input-group bg-white">
      <input
        v-model="form.keyword"
        type="search"
        class="form-control bg-white"
        placeholder="Cari nama, email atau NIK"
        aria-label="Cari nama, email atau NIK"
        aria-describedby="button-addon2"
      />
      <button class="btn btn-primary" type="submit" id="button-addon2">
        <i class="fa fa-search"></i>
      </button>
    </div>
  </form>
</template>

<script>
export default {
  props: {
    submitUrl: String,
    query: Object,
  },
  data() {
    return {
      form: this.$inertia.form({
        keyword: null,
      }),
    };
  },
  mounted() {
    this.form = { ...this.form, ...this.query };
  },
  methods: {
    submit() {
      this.form.get(this.submitUrl);
    },
  },
};
</script>

<style scoped>
.bg-white {
  background: white !important;
}
</style>
