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
        <InertiaLink
          class="text-primary"
          :href="route('field.planting.index', field.id)"
          >Penanaman</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        Tambah penanaman
      </template>

      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card card-body p-4">
            <h3 class="text-primary font-bold">Formulir Penanaman Kedelai</h3>
            <b>Lahan #{{ field.id }}</b>
            <b>Pemilik: {{ field.user.name }}</b>

            <div class="form-group mt-3">
              <label for="" class="form-label">Tanggal Tanam</label>
              <div>
                <date-picker
                  v-model:value="form.started_at"
                  value-type="YYYY-MM-DD"
                  :input-class="`form-control ${
                    form.errors.started_at ? '' : 'is_invalid'
                  }`"
                ></date-picker>
              </div>
              <span class="invalid-feedback">{{ form.errors.started_at }}</span>
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
                  :id="variety"
                />
                <label class="form-check-label" :for="variety">
                  {{ variety }}
                </label>
              </div>
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
              </div>
              <span class="invalid-feedback">
                {{ form.errors.seed_quantity }}
              </span>
            </div>

            <div class="form-group">
              <label for="">Biaya pengolahan lahan</label>
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Rp</span>
                <input
                  type="number"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.activity_cost }"
                  v-model="form.activity_cost"
                />
              </div>
              <span class="invalid-feedback">
                {{ form.errors.activity_cost }}
              </span>
            </div>

            <div class="form-group">
              <label for="">Pupuk yang digunakan</label>
              <input
                type="text"
                class="form-control"
                v-model="form.fertilizer"
                :class="{ 'is-invalid': form.errors.fertilizer }"
              />
              <span class="invalid-feedback">
                {{ form.errors.fertilizer }}
              </span>
            </div>

            <div class="form-group">
              <label for="">Biaya pemakaian pupuk</label>
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Rp</span>
                <input
                  type="number"
                  class="form-control"
                  v-model="form.seed_cost"
                  :class="{ 'is-invalid': form.errors.seed_cost }"
                />
                <span class="invalid-feedback">
                {{ form.errors.seed_cost }}
              </span>
              </div>
            </div>

            <div class="form-group">
              <label for="formFile" class="form-label"
                >Foto benih <span class="text-muted">(opsional)</span></label
              >
              <input
                class="form-control"
                :class="{ 'is-invalid': form.errors.seed_photo }"
                type="file"
                id="formFile"
                accept="image/*"
                @input="form.seed_photo = $event.target.files[0]"
              />
              <span class="invalid-feedback">{{ form.errors.seed_photo }}</span>
            </div>

            <div class="form-group">
              <label for="formFile" class="form-label"
                >Foto penanaman
                <span class="text-muted">(opsional)</span></label
              >
              <input
                class="form-control"
                :class="{ 'is-invalid': form.errors.activity_photo }"
                type="file"
                id="formFile"
                accept="image/*"
                @input="form.activity_photo = $event.target.files[0]"
              />
              <span class="invalid-feedback">{{
                form.errors.activity_photo
              }}</span>
            </div>

            <div class="form-group text-end mt-3">
                <button class="btn btn-success">Simpan penanaman</button>
            </div>
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
import DatePicker from "vue-datepicker-next";
import "vue-datepicker-next/index.css";

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
};
</script>

<style>
</style>
