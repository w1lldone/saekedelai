<template>
  <form @submit.prevent="submit()" class="form">
    <Status></Status>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" v-model="form.email" />
    </div>
    <div class="mb-3">
      <label for="name" class="form-label">Nama</label>
      <input type="text" class="form-control" v-model="form.name" />
    </div>
    <div class="mb-3">
      <label for="phone_number" class="form-label">No HP</label>
      <input type="text" class="form-control" v-model="form.phone_number" />
    </div>
    <div class="mb-3">
      <label for="id_number" class="form-label">NIK</label>
      <input type="text" class="form-control" v-model="form.id_number" />
    </div>
    <div class="mb-3"></div>
    <div class="d-flex justify-content-end">
      <button
        type="submit"
        class="btn btn-success"
        :class="{ disabled: form.processing }"
      >
        Simpan
      </button>
    </div>
  </form>
</template>

<script>
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import Status from "@/Components/Status.vue";

export default {
  components: {
    BreezeValidationErrors,
    Status,
  },
  props: {
    user: Object,
    submitRoute: String,
    status: String,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: this.user.name,
        email: this.user.email,
        id_number: this.user.id_number,
        phone_number: this.user.phone_number,
      }),
    };
  },
  methods: {
    submit() {
      this.form.put(this.submitRoute, {
        onSuccess: () => this.$emit("success"),
      });
    },
  },
};
</script>

<style>
</style>
