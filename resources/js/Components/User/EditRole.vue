<template>
  <form @submit.prevent="submit()">
    <div class="mb-3">
      <label for="role">Pilih Role</label>
      <div>
        <div class="form-check" v-for="role in roles" :key="role">
          <input
            v-model="form.role"
            :value="role"
            class="form-check-input"
            type="radio"
            name="flexRadioDefault"
            :id="role"
          />
          <label class="form-check-label" :for="role">
            {{ role }}
          </label>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-end">
        <button class="btn btn-success" type="submit">Simpan Role</button>
    </div>
  </form>
</template>

<script>
export default {
  props: {
    role: String,
    roles: Array,
    submitUrl: String,
  },
  data() {
    return {
      form: this.$inertia.form({
        role: this.role,
      }),
    };
  },
  methods: {
      submit() {
          this.form.put(this.submitUrl)
      }
  }
};
</script>

<style>
</style>
