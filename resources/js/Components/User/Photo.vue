<template>
  <div class="row">
    <div class="col-md-4">
      <img :src="src" alt="" class="img-fluid" v-if="src" />
      <div v-else class="p-5 border border-secondary rounded text-center">
        <h4 class="m-0 text-muted">Foto tidak tersedia</h4>
      </div>
    </div>
    <div class="col-md-8 d-flex flex-column" v-if="canUpdate">
      <div>
        <h3>Unggah Foto pengguna</h3>
        Resolusi optimal 300px &times; 300px
      </div>
      <div class="mt-auto">
        <form @submit.prevent="submit">
          <label class="btn btn-file btn-primary" v-if="!form.progress">
            Unggah
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
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    submitUrl: String,
    src: String,
    canUpdate: Boolean
  },
  data() {
    return {
      form: this.$inertia.form({
        media: null,
        collection: "profile_picture",
      }),
    };
  },
  methods: {
    submit() {
      this.form.post(this.submitUrl);
    },
  },
};
</script>

<style lang="scss" scoped>
a {
  display: inline !important;
}

label {
  margin-bottom: 0;
}

.btn-file {
  position: relative;
  overflow: hidden;
}
.btn-file input[type="file"] {
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  font-size: 100px;
  text-align: right;
  filter: alpha(opacity=0);
  opacity: 0;
  outline: none;
  background: white;
  cursor: inherit;
  display: block;
}
</style>
