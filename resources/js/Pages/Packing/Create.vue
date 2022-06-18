<template>
  <div>
    <Head title="Form pengemasan produk"></Head>

    <Auth>
      <template #header>
        ...
        <i class="fa fa-chevron-right mx-2"></i>
        <InertiaLink
          class="text-primary"
          :href="route('field.planting.show', [planting.field_id, planting.id])"
          >Detail penanaman</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        <InertiaLink
          class="text-primary"
          :href="
            route('field.planting.product', [planting.field_id, planting.id])
          "
          >Produk</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        Formulir pengemasan
      </template>

      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card card-body p-4">
            <h3 class="text-primary font-bold">Formulir pengemasan</h3>
            <div>
              <div>Lahan #{{ planting.field.id }}</div>
              <div>Pemilik: {{ planting.field.user.name }}</div>
              <div>Batch produk: {{ planting.product_batch }}</div>
            </div>
            <form @submit.prevent="submit()" class="mt-3">
              <div class="form-group">
                <label for="">Grade kedelai</label>
                <div>
                  <div
                    class="form-check form-check-inline"
                    v-for="grade in grades"
                    :key="grade"
                  >
                    <input
                      v-model="form.grade"
                      class="form-check-input"
                      :class="{
                        'is-invalid': form.errors.grade,
                      }"
                      type="radio"
                      name="inlineRadioOptions"
                      :id="grade"
                      :value="grade"
                    />
                    <label class="form-check-label" :for="grade"
                      >Grade {{ grade }}</label
                    >
                  </div>
                  <div class="text-danger">
                    {{ form.errors.grade }}
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="">Ukuran karung</label>
                <div class="input-group">
                  <input
                    type="number"
                    class="form-control"
                    v-model="form.bag_size"
                    :class="{
                      'is-invalid': form.errors.bag_size,
                    }"
                  />
                  <span class="input-group-text" id="basic-addon1">Kg</span>
                  <span class="invalid-feedback">
                    {{ form.errors.bag_size }}
                  </span>
                </div>
              </div>
              <div class="form-group">
                <label for="">Jumlah karung</label>
                <div class="input-group">
                  <input
                    type="number"
                    class="form-control"
                    v-model="form.initial_quantity"
                    :class="{
                      'is-invalid': form.errors.initial_quantity,
                    }"
                  />
                  <span class="invalid-feedback">
                    {{ form.errors.initial_quantity }}
                  </span>
                </div>
              </div>
              <div
                class="
                  form-group
                  d-flex
                  justify-content-between
                  align-items-center
                  pt-3
                "
              >
                <div>
                  Total berat kedelai:
                  {{ form.initial_quantity * form.bag_size }}Kg
                </div>
                <button class="btn btn-success" type="submit">Simpan</button>
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
import DatePicker from "vue3-date-time-picker";
import { format } from "date-fns";
import { id } from "date-fns/locale";

export default {
  props: {
    planting: {
      type: Object,
      default: null,
    },
    grades: Array,
  },
  components: {
    Auth,
    Head,
    InertiaLink,
  },
  data() {
    return {
      form: this.$inertia.form({
        initial_quantity: null,
        bag_size: null,
        grade: null,
      }),
    };
  },
  methods: {
    submit() {
      this.form.post(route("planting.packing.store", this.planting.id));
    },
  },
};
</script>

<style>
</style>
