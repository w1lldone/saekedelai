<template>
  <form @submit.prevent="submit">
    <label class="btn btn-file btn-outline-info" v-if="!form.progress">
      <i class="fa fa-image"></i> Unggah foto
      <div id="uploadMediaForm">
        <input
          type="file"
          ref="file"
          name="file"
          style="display: none"
          @input="form.media = $event.target.files[0]"
          @change="submit()"
        />
      </div>
    </label>
    <button v-if="form.progress" class="btn btn-seconry disabled">
      Mengunggah {{ form.progress.percentage }} %
    </button>
  </form>
</template>

<script>
export default {
  props: {
    submitUrl: String,
  },
  data() {
    return {
      form: this.$inertia.form({
        media: null,
        collection: "galery",
      }),
    };
  },
  methods: {
    async submit() {
      this.form.post(this.submitUrl, {
        preserveScroll: true,
      });
    },
  },
};
</script>

<style>
</style>
