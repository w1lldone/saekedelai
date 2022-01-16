<template>
  <form @submit.prevent="submit">
    <div class="row align-items-center">
      <div class="col-12">
        <label class="form-label text-primary">Filter pemilik</label>
      </div>
      <div class="col-md-6">
        <UserSelect v-model="form.user_id"></UserSelect>
      </div>
      <div class="col-md-1 d-flex justify-content-end">
        <button class="btn btn-primary" type="submit">Filter</button>
      </div>
      <div class="col-md ms-md-3">
        <div class="mt-1">
          <template v-for="(value, name) in queries" :key="name">
            <span
              @click="
                () => {
                  form.user_id = null;
                  submit();
                }
              "
              v-if="value"
              class="badge rounded-pill bg-secondary"
            >
              {{ name }}: {{ value }} <i class="fa fa-times"></i>
            </span>
          </template>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import UserSelect from "@/Components/User/UserSelect.vue";

export default {
  props: {
    submitUrl: String,
    queries: {
      default: {},
    },
  },
  components: {
    UserSelect,
  },
  data() {
    return {
      form: this.$inertia.form({
        user_id: null,
      }),
    };
  },
  methods: {
    async submit() {
      this.form.get(this.submitUrl);
    },
  },
};
</script>

<style scoped>
.badge {
  cursor: pointer;
  font-size: 0.75rem;
}
</style>
