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
          >Rilis produk</InertiaLink
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
                <label for="">No karung</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="form.packing_number"
                  :class="{
                    'is-invalid': form.errors.packing_number,
                  }"
                />
                <span class="invalid-feedback">
                  {{ form.errors.packing_number }}
                </span>
              </div>
              <div class="form-group">
                <label for="">Berat kedelai</label>
                <div class="input-group">
                  <input
                    type="number"
                    class="form-control"
                    v-model="form.quantity"
                    :class="{
                      'is-invalid': form.errors.quantity,
                    }"
                  />
                  <span class="input-group-text" id="basic-addon1">Kg</span>
                  <span class="invalid-feedback">
                    {{ form.errors.quantity }}
                  </span>
                </div>
              </div>
              <div class="form-group text-end pt-3">
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
  },
  components: {
    Auth,
    Head,
    InertiaLink,
  },
  data() {
    return {
      form: this.$inertia.form({
        packing_number: null,
        quantity: null,
      }),
    };
  },
  methods: {
      submit() {
          this.form.post(route('planting.packing.store', this.planting.id))
      }
  },
};
</script>

<style>
</style>
