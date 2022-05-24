<template>
  <div>
    <Head title="Penanaman"></Head>

    <Auth>
      <template #header>
        <InertiaLink class="text-primary" :href="route('field.index')"
          >Lahan pertanian</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        <InertiaLink class="text-primary" :href="route('field.show', field.id)"
          >Detail lahan</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        Tambah penanaman
      </template>

      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card card-body p-4">
            <h3 class="text-primary font-bold">Formulir Penanaman Kedelai</h3>
            <span>Lahan #{{ field.id }}</span>
            <span>Lokasi: {{ field.address.formatted_address }}</span>
            <span>Pemilik: {{ field.user.name }}</span>

            <form @submit.prevent="submit()">
              <div class="form-group mt-3">
                <label for="" class="form-label">Tanggal Tanam</label>
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

              <div class="form-group text-end mt-3">
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
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import Auth from "@/Layouts/Auth.vue";
import { format, formatDistanceToNow } from "date-fns";
import { id } from "date-fns/locale";
import DatePicker from "vue3-date-time-picker";
import "vue3-date-time-picker/dist/main.css";

export default {
  props: {
    plantings: Object,
    field: Object,
    varieties: Array,
  },
  components: {
    Head,
    InertiaLink,
    Auth,
    DatePicker,
  },
  setup() {
    return {
      format,
      formatDistanceToNow,
      id,
    };
  },
  data() {
    return {
      form: this.$inertia.form({
        started_at: null,
        seed_variety: null,
        seed_quantity: null,
        activity_cost: null,
        fertilizer: null,
        fertilizer_cost: null,
        seed_photo: null,
        activity_photo: null,
      }),
    };
  },
  methods: {
    submit() {
      this.form.post(route("field.planting.store", this.field.id));
    },
  },
};
</script>

<style>
</style>
