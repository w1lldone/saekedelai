<template>
  <form @submit.prevent="submit">
    <div class="row">
      <div class="col-md-5">
        <label class="form-label text-primary">Filter pemilik</label>
        <UserSelect v-model="form.user_id"></UserSelect>
      </div>
    </div>
  </form>
</template>

<script>
import UserSelect from "@/Components/User/UserSelect.vue";

export default {
  props: {
    submitUrl: String,
    modelValue: {
      default: null,
    },
  },
  components: {
    UserSelect,
  },
  data() {
    return {
      form: {
        user_id: null,
      },
    };
  },
  watch: {
    form: {
      immediate: true,
      deep: true,
      handler(newValue, oldValue) {
        this.submit();
      },
    },
  },
  methods: {
    async submit() {
      let response = await axios.get(this.submitUrl, {
        params: this.form,
      });

      this.$emit("update:modelValue", response.data);
    },
  },
};
</script>

<style>
</style>
