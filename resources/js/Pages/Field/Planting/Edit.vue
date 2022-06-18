<template>
  <div>
    <Head title="Edit Penanaman"></Head>
    <Auth>
      <template #header>
        ...
        <i class="fa fa-chevron-right mx-2"></i>
        <InertiaLink class="text-primary" :href="route('field.planting.index', field.id)"
          >Penanaman</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        <InertiaLink
          class="text-primary"
          :href="route('field.planting.show', [planting.field_id, planting.id])"
          >Detail penanaman</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        Edit Penanaman
      </template>

      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card card-body p-4">
            <h3 class="font-bold text-primary">Edit data penanaman</h3>
            <span>Lahan #{{ field.id }}</span>
            <span>Lokasi: {{ field.address.formatted_address }}</span>
            <span>Pemilik: {{ field.user.name }}</span>
            <a class="mt-2" target="_blank" :href="route('field.edit', field.id)">Edit data lahan?</a>

            <form class="mt-3" @submit.prevent="submit()">
              <div class="form-group">
                <label for="">Tanggal tanam</label>
                <div>
                  <date-picker
                    v-model="form.started_at"
                    format="yyyy-MM-dd"
                    :monthChangeOnScroll="false"
                    :autoApply="true"
                    :inputClassName="`form-control ${
                      form.errors.started_at ? 'is-invalid' : ''
                    }`"
                  ></date-picker>
                  <input
                    type="hidden"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.started_at }"
                  />
                  <span class="invalid-feedback">{{
                    form.errors.started_at
                  }}</span>
                </div>
              </div>

              <div class="form-group">
                <label for="">Varietas Benih</label>
                <div
                  class="form-check"
                  v-for="variety in varieties"
                  :key="variety"
                >
                  <input
                    class="form-check-input"
                    :class="{ 'is-invalid': form.errors.seed_variety }"
                    type="radio"
                    name="flexRadioDefault"
                    v-model="form.seed_variety"
                    :value="variety"
                    :id="variety"
                  />
                  <label class="form-check-label" :for="variety">
                    {{ variety }}
                  </label>
                </div>
                <input
                  type="hidden"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.seed_variety }"
                />
                <span class="invalid-feedback">
                  {{ form.errors.seed_variety }}
                </span>
              </div>

              <div class="form-group">
                <label for="">Kuantitas benih</label>
                <div class="input-group mb-3">
                  <input
                    type="number"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.seed_quantity }"
                    v-model="form.seed_quantity"
                  />
                  <span class="input-group-text" id="basic-addon1">Kg</span>
                  <span class="invalid-feedback">
                    {{ form.errors.seed_quantity }}
                  </span>
                </div>
              </div>

              <div class="form-group text-end mt-5">
                <button
                  class="btn btn-success"
                  type="submit"
                  :disabled="form.processing"
                >
                  Simpan penanaman
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </Auth>
  </div>
</template>

<script>
import Auth from "@/Layouts/Auth.vue";
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import DeleteButton from "@/Components/DeleteButton.vue";
import DatePicker from "vue3-date-time-picker";
import "vue3-date-time-picker/dist/main.css";

export default {
  components: {
    Auth,
    Head,
    InertiaLink,
    DeleteButton,
    DatePicker,
  },
  props: {
    planting: Object,
    field: Object,
    varieties: Array,
  },
  data() {
    return {
      form: this.$inertia.form({
        started_at: this.planting.started_at,
        seed_variety: this.planting.seed_variety,
        seed_quantity: this.planting.seed_quantity,
      }),
    };
  },

  methods: {
    submit() {
      this.form.put(
        route("field.planting.update", [this.field.id, this.planting.id])
      );
    },
  },
};
</script>

<style scoped>
</style>
