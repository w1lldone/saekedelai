<template>
  <div>
    <Head title="Formulir panen"></Head>
    <Auth>
      <template #header>
        ...
        <i class="fa fa-chevron-right mx-2"></i>
        <InertiaLink
          class="text-primary"
          :href="route('field.planting.index', planting.field_id)"
          >Penanaman</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        <InertiaLink
          class="text-primary"
          :href="route('field.planting.show', [planting.field_id, planting.id])"
          >Detail penanaman</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        Formulir panen
      </template>

      <!-- CARD -->
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card card-body p-4">
            <h3 class="text-primary font-bold">Formulir panen</h3>
            <div>
              <div>Lahan #{{ planting.field_id }}</div>
              <div>Lokasi: {{ planting.field.address.formatted_address }}</div>
              <div>Pemilik: {{ planting.field.user.name }}</div>
              <div>
                Tanggal tanam:
                {{
                  format(new Date(planting.started_at), "d MMMM yyyy", {
                    locale: id,
                  })
                }}
              </div>
            </div>

            <!-- FORM -->
            <form class="mt-3">
              <!-- HARVESTED AT -->
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <label for="">Tanggal panen</label>
                    <date-picker
                      v-model="form.harvested_at"
                      format="yyyy-MM-dd"
                      locale="in-ID"
                      :enable-time-picker="false"
                      :monthChangeOnScroll="false"
                      :autoApply="true"
                      :inputClassName="`form-control ${
                        form.errors.harvested_at ? 'is-invalid' : ''
                      }`"
                    ></date-picker>
                    <span class="text-danger">{{
                      form.errors.harvested_at
                    }}</span>
                  </div>
                </div>
              </div>
              <!-- END HARVESTED AT -->
              <!-- YIELD -->
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <label for="">Hasil panen total</label>
                    <div class="input-group">
                      <input
                        type="number"
                        class="form-control"
                        v-model="form.yield"
                        :class="{
                          'is-invalid': form.errors.yield,
                        }"
                      />
                      <span class="input-group-text" id="basic-addon2">Kg</span>
                    </div>
                    <span class="invalid-feedback">{{
                      form.errors.yield
                    }}</span>
                  </div>
                </div>
              </div>
              <!-- END YIELD -->
              <!-- WATER CONTENT -->
              <div class="form-group">
                <label for="">Kadar air kedelai</label>
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
                </div>
                <span class="invalid-feedback">{{
                  form.errors.water_content
                }}</span>
              </div>
              <!-- END WATER CONTENT -->
              <!-- HARVERSTING METHOD -->

              <!-- END HARVERSTING METHOD -->
            </form>
          </div>
        </div>
      </div>
    </Auth>
  </div>
</template>

<script>
import { InertiaLink, Head } from "@inertiajs/inertia-vue3";
import Auth from "@/Layouts/Auth.vue";
import { format } from "date-fns";
import { id } from "date-fns/locale";
import DatePicker from "vue3-date-time-picker";
import "vue3-date-time-picker/dist/main.css";

export default {
  props: {
    planting: Object,
  },
  components: {
    Auth,
    Head,
    InertiaLink,
    DatePicker,
  },
  data() {
    return {
      form: this.$inertia.form({
        harvested_at: null,
        yield: null,
        water_content: null,
        value: null,
        harvesting_method: null,
        costs: [
          {
            description: "",
            value: "",
          },
        ],
      }),
      format,
      id,
    };
  },
};
</script>

<style lang="scss" scoped>
</style>
