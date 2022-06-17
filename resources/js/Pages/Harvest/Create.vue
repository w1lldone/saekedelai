<template>
  <div>
    <Head title="Formulir panen"></Head>
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
          :href="route('field.planting.postharvest', [planting.field_id, planting.id])"
          >Pasca panen</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>
        Formulir panen
      </template>

      <!-- CARD -->
      <div class="row justify-content-center">
        <div class="col-md-7">
          <div class="card card-body p-4">
            <h3 class="text-primary font-bold">
              Formulir panen dan pasca panen
            </h3>
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
            <form class="mt-3" @submit.prevent="submit()">
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
                    <label for="">Total hasil panen</label>
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
                      <span class="invalid-feedback">{{
                        form.errors.yield
                      }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END YIELD -->
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <label for="">Tanggal penerimaan</label>
                    <date-picker
                      v-model="form.received_at"
                      format="yyyy-MM-dd"
                      locale="in-ID"
                      :enable-time-picker="false"
                      :monthChangeOnScroll="false"
                      :autoApply="true"
                      :inputClassName="`form-control ${
                        form.errors.received_at ? 'is-invalid' : ''
                      }`"
                    ></date-picker>
                    <span class="text-danger">{{
                      form.errors.received_at
                    }}</span>
                  </div>
                </div>
              </div>
              <!-- HARVEST BATCH -->
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <label for="">LOT RM</label>
                    <div class="input-group">
                      <input
                        type="text"
                        class="form-control"
                        v-model="form.harvest_batch"
                        :class="{
                          'is-invalid': form.errors.harvest_batch,
                        }"
                      />
                      <span class="invalid-feedback">{{
                        form.errors.harvest_batch
                      }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END RELEASED VOLUME -->
              <!-- RELEASED VOLUME -->
              <!-- <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <label for="">Released Volume</label>
                    <div class="input-group">
                      <input
                        type="number"
                        class="form-control"
                        v-model="form.released_quantity"
                        :class="{
                          'is-invalid': form.errors.released_quantity,
                        }"
                      />
                      <span class="input-group-text" id="basic-addon2">Kg</span>
                      <span class="invalid-feedback">{{
                        form.errors.released_quantity
                      }}</span>
                    </div>
                  </div>
                </div>
              </div> -->
              <!-- END RELEASED VOLUME -->
              <!-- URELEASED VOLUME -->
              <!-- <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <label for="">Unreleased Volume</label>
                    <div class="input-group">
                      <input
                        type="number"
                        class="form-control"
                        v-model="form.unreleased_quantity"
                        :class="{
                          'is-invalid': form.errors.unreleased_quantity,
                        }"
                      />
                      <span class="input-group-text" id="basic-addon2">Kg</span>
                      <span class="invalid-feedback">{{
                        form.errors.unreleased_quantity
                      }}</span>
                    </div>
                  </div>
                </div>
              </div> -->
              <!-- END URELEASED VOLUME -->
              <div class="mt-4">
                <h4 class="text-primary font-bold">Mutu kedelai saat penerimaan</h4>
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
              <!-- END BUGS -->
              <!-- COSTS -->
              <div class="form-group mt-4">
                <h4 class="text-primary font-bold">Biaya panen dan pasca panen</h4>
                <div
                  class="row mt-2"
                  v-for="(cost, index) in form.harvest_costs"
                  :key="index"
                >
                  <div class="col-md-6">
                    <label for="">Deskripsi biaya</label>
                    <input
                      class="form-control"
                      type="text"
                      v-model="form.harvest_costs[index].description"
                      :class="{
                        'is-invalid':
                          form.errors[`harvest_costs.${index}.description`],
                      }"
                    />
                    <span class="invalid-feedback">{{
                      form.errors[`harvest_costs.${index}.description`]
                    }}</span>
                  </div>
                  <div class="col-md-5">
                    <label for="">Jumlah</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1">Rp</span>
                      <input
                        class="form-control"
                        type="number"
                        step="1"
                        v-model="form.harvest_costs[index].value"
                        :class="{
                          'is-invalid':
                            form.errors[`harvest_costs.${index}.value`],
                        }"
                      />
                      <span class="invalid-feedback">{{
                        form.errors[`harvest_costs.${index}.value`]
                      }}</span>
                    </div>
                  </div>
                  <div class="col align-self-end pb-4">
                    <button
                      type="button"
                      @click="removeCost(index)"
                      class="btn btn-outline-danger btn-sm"
                    >
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="mt-2 text-right">
                  <button
                    type="button"
                    @click="addCost()"
                    class="btn btn-outline-primary"
                  >
                    <i class="fa fa-plus"></i> tambah biaya
                  </button>
                </div>
              </div>
              <!-- END of COST -->
              <div class="form-group text-end mt-4">
                <button class="btn btn-success">Simpan</button>
              </div>
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
    var costs = this.planting.harvest_costs ? this.planting.harvest_costs : [];

    return {
      form: this.$inertia.form({
        harvested_at: this.planting.harvested_at,
        yield: this.planting.yield,
        harvest_batch: this.planting.harvest_batch,
        received_at: this.planting.received_at,
        // released_quantity: this.planting.released_quantity,
        // unreleased_quantity: this.planting.unreleased_quantity,
        water_content: this.planting.harvest_quality?.water_content,
        dirts: this.planting.harvest_quality?.dirts,
        discolors: this.planting.harvest_quality?.discolors,
        splits: this.planting.harvest_quality?.splits,
        damaged: this.planting.harvest_quality?.damaged,
        fungal: this.planting.harvest_quality?.fungal,
        bugs: this.planting.harvest_quality?.bugs,
        harvest_costs: costs,
      }),
      format,
      id,
    };
  },
  methods: {
    addCost() {
      this.form.harvest_costs.push({
        description: "",
        value: null,
      });
    },
    removeCost(index) {
      this.form.harvest_costs.splice(index, 1);
    },
    submit() {
      this.form.post(route("planting.harvest.store", this.planting.id));
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
