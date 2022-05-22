<template>
  <div>
    <Head title="Form rilis produk"></Head>

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
        Form produk
      </template>

      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card card-body p-4">
            <h3 class="text-primary font-bold">
              Formulir Rilis Produk Kedelai
            </h3>
            <div>
              <div>Lahan #{{ planting.field.id }}</div>
              <div>Pemilik: {{ planting.field.user.name }}</div>
              <div>
                Tanggal tanam:
                {{
                  format(new Date(planting.started_at), "d MMMM yyyy", {
                    locale: id,
                  })
                }}
              </div>
              <div>LOT RM: {{ planting.harvest_batch }}</div>
            </div>

            <form class="mt-3" @submit.prevent="submit()">
              <div class="form-group">
                <label>Tanggal produksi</label>
                <date-picker
                  v-model="form.production_date"
                  format="yyyy-MM-dd"
                  locale="in-ID"
                  :enable-time-picker="false"
                  :monthChangeOnScroll="false"
                  :autoApply="true"
                  :inputClassName="`form-control ${
                    form.errors.production_date ? 'is-invalid' : ''
                  }`"
                ></date-picker>
              </div>
              <div class="form-group">
                <label>Tanggal kadaluarsa</label>
                <date-picker
                  v-model="form.expired_date"
                  format="yyyy-MM-dd"
                  locale="in-ID"
                  :enable-time-picker="false"
                  :monthChangeOnScroll="false"
                  :autoApply="true"
                  :inputClassName="`form-control ${
                    form.errors.expired_date ? 'is-invalid' : ''
                  }`"
                ></date-picker>
              </div>
              <div class="form-group">
                <label>Batch</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="form.product_batch"
                  :class="{
                    'is-invalid': form.errors.product_batch,
                  }"
                />
                <span class="invalid-feedback">{{
                  form.errors.product_batch
                }}</span>
              </div>
              <div class="form-group">
                <label>Petugas</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="form.product_processor"
                  :class="{
                    'is-invalid': form.errors.product_processor,
                  }"
                />
                <span class="invalid-feedback">{{
                  form.errors.product_processor
                }}</span>
              </div>

              <div class="mt-4">
                <h4 class="text-primary font-bold">Mutu kedelai</h4>
              </div>
              <!-- WATER CONTENT -->
              <div class="form-group">
                <label for="">Kadar air</label>
                <div class="input-group">
                  <input
                    type="number"
                    step="0.1"
                    class="form-control"
                    v-model="form.water_content"
                    :class="{
                      'is-invalid': form.errors.water_content,
                    }"
                  />
                  <span class="input-group-text" id="basic-addon2">%</span>
                  <span class="invalid-feedback">{{
                    form.errors.water_content
                  }}</span>
                </div>
              </div>
              <!-- END WATER CONTENT -->
              <!-- dirts -->
              <div class="form-group">
                <label for="">Kotoran</label>
                <div class="input-group">
                  <input
                    type="number"
                    step="0.1"
                    class="form-control"
                    v-model="form.dirts"
                    :class="{
                      'is-invalid': form.errors.dirts,
                    }"
                  />
                  <span class="input-group-text" id="basic-addon2">%</span>
                  <span class="invalid-feedback">{{ form.errors.dirts }}</span>
                </div>
              </div>
              <!-- END dirts -->
              <!-- DISCOLOUR -->
              <div class="form-group">
                <label for="">Discolors</label>
                <div class="input-group">
                  <input
                    type="number"
                    step="0.1"
                    class="form-control"
                    v-model="form.discolors"
                    :class="{
                      'is-invalid': form.errors.discolors,
                    }"
                  />
                  <span class="input-group-text" id="basic-addon2">%</span>
                  <span class="invalid-feedback">{{
                    form.errors.discolors
                  }}</span>
                </div>
              </div>
              <!-- END DISCOLOUR -->
              <!-- SPLIT -->
              <div class="form-group">
                <label for="">Split</label>
                <div class="input-group">
                  <input
                    type="number"
                    step="0.1"
                    class="form-control"
                    v-model="form.splits"
                    :class="{
                      'is-invalid': form.errors.splits,
                    }"
                  />
                  <span class="input-group-text" id="basic-addon2">%</span>
                  <span class="invalid-feedback">{{ form.errors.splits }}</span>
                </div>
              </div>
              <!-- END SPLIT -->
              <!-- damaged -->
              <div class="form-group">
                <label for="">Rusak</label>
                <div class="input-group">
                  <input
                    type="number"
                    step="0.1"
                    class="form-control"
                    v-model="form.damaged"
                    :class="{
                      'is-invalid': form.errors.damaged,
                    }"
                  />
                  <span class="input-group-text" id="basic-addon2">%</span>
                  <span class="invalid-feedback">{{
                    form.errors.damaged
                  }}</span>
                </div>
              </div>
              <!-- END damaged -->
              <!-- FUNGAL -->
              <div class="form-group">
                <label for="">Jamur</label>
                <div class="input-group">
                  <input
                    type="number"
                    step="0.1"
                    class="form-control"
                    v-model="form.fungal"
                    :class="{
                      'is-invalid': form.errors.fungal,
                    }"
                  />
                  <span class="input-group-text" id="basic-addon2">%</span>
                  <span class="invalid-feedback">{{ form.errors.fungal }}</span>
                </div>
              </div>
              <!-- END FUNGAL -->
              <!-- BUGS -->
              <div class="form-group">
                <label for="">Kutu</label>
                <div class="input-group">
                  <input
                    type="number"
                    step="0.1"
                    class="form-control"
                    v-model="form.bugs"
                    :class="{
                      'is-invalid': form.errors.bugs,
                    }"
                  />
                  <span class="input-group-text" id="basic-addon2">%</span>
                  <span class="invalid-feedback">{{ form.errors.bugs }}</span>
                </div>
              </div>

              <div class="form-group text-end pt-3">
                <button type="submit" class="btn btn-success">Simpan</button>
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
import "vue3-date-time-picker/dist/main.css";

export default {
  props: {
    planting: {
      type: Object,
      default: null,
    },
  },
  components: {
    Head,
    InertiaLink,
    Auth,
    DatePicker,
  },
  data() {
    return {
      form: this.$inertia.form({
        production_date: this.planting.production_date,
        expired_date: this.planting.expired_date,
        product_batch: this.planting.product_batch,
        product_processor: this.planting.product_processor,
        water_content: this.planting.product_quality?.water_content,
        dirts: this.planting.product_quality?.dirts,
        discolors: this.planting.product_quality?.discolors,
        splits: this.planting.product_quality?.splits,
        damaged: this.planting.product_quality?.damaged,
        fungal: this.planting.product_quality?.fungal,
        bugs: this.planting.product_quality?.bugs,
      }),
      format,
      id,
    };
  },
  methods: {
    submit() {
      this.form.post(route("planting.product.store", this.planting.id));
    },
  },
};
</script>

<style>
</style>
