<template>
  <form @submit.prevent="submit()">
    <div>
      <BreezeLabel for="fullname" value="Name" />
      <BreezeInput
        id="fullname"
        type="text"
        class="mt-1 block w-full"
        v-model="form.name"
        required
        autofocus
        autocomplete="fullname"
      />
    </div>
    <div class="mt-4">
      <BreezeLabel for="email" value="Email" />
      <BreezeInput
        id="email"
        type="email"
        class="mt-1 block w-full"
        v-model="form.email"
        required
        autofocus
        autocomplete="username"
      />
    </div>

    <div class="mt-4">
      <BreezeLabel for="phone_number" value="No HP" />
      <BreezeInput
        id="phone_number"
        type="text"
        class="mt-1 block w-full"
        v-model="form.phone_number"
        autocomplete="phone_number"
      />
    </div>

    <div class="mt-4">
      <BreezeLabel for="id_number" value="NIK" />
      <BreezeInput
        id="id_number"
        type="text"
        class="mt-1 block w-full"
        v-model="form.id_number"
        autocomplete="id_number"
      />
    </div>

    <div class="flex items-center justify-end mt-4">
      <BreezeButton
        class="ml-4"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Simpan
      </BreezeButton>
    </div>
  </form>
</template>

<script>
import BreezeButton from "@/Components/Button.vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";

export default {
  props: {
    user: Object,
    submitRoute: String,
  },
  components: {
    BreezeButton,
    BreezeCheckbox,
    BreezeInput,
    BreezeLabel,
    BreezeValidationErrors,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: this.user.name,
        email: this.user.email,
        id_number: this.user.id_number,
        phone_number: this.user.phone_number
      }),
    };
  },
  methods: {
    submit() {
      this.form.put(this.submitRoute, {
          onSuccess: () => this.$emit('success')
      });
    },
  },
};
</script>

<style>
</style>
