<template>
  <div>
    <!-- FORM -->
    <div>
      <form @submit.prevent="submit()">
        <div class="row align-items-end">
          <div class="col-md-10">
            <div class="row">
              <div class="col-md-3">
                <label for="">Start date</label>
                <date-picker
                  v-model="form.start_date"
                  format="yyyy-MM-dd HH:mm"
                  :startTime="{ hours: 0, minutes: 0 }"
                  :monthChangeOnScroll="false"
                  :inputClassName="`form-control ${
                    form.errors.start_date ? 'is-invalid' : ''
                  }`"
                ></date-picker>
                <input
                  type="hidden"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.start_date }"
                />
                <span class="invalid-feedback">{{
                  form.errors.start_date
                }}</span>
              </div>
              <div class="col-md-3">
                <label for="">End date</label>
                <date-picker
                  v-model="form.end_date"
                  format="yyyy-MM-dd HH:mm"
                  :startTime="{ hours: 0, minutes: 0 }"
                  :monthChangeOnScroll="false"
                  :inputClassName="`form-control ${
                    form.errors.end_date ? 'is-invalid' : ''
                  }`"
                ></date-picker>
                <input
                  type="hidden"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.end_date }"
                />
                <span class="invalid-feedback">{{ form.errors.end_date }}</span>
              </div>
              <div class="col-md-2">
                <label for="">Agregasi</label>
                <VueSelect
                  :options="aggregations"
                  v-model="form.aggregation"
                ></VueSelect>
                <span class="text-danger">{{ form.errors.aggregation }}</span>
              </div>
              <div class="col-md-2">
                <label for="">Resolusi</label>
                <select class="form-select" v-model="form.resolution">
                  <option></option>
                  <option
                    v-for="(resolution, key) in resolutions"
                    :key="key"
                    :value="resolution"
                  >
                    {{ key }}
                  </option>
                </select>
                <span class="text-danger">{{ form.errors.resolution }}</span>
              </div>
            </div>
          </div>
          <div class="col-md-2 mt-4">
            <button
              type="submit"
              class="btn btn-success"
              :disabled="form.isLoading"
            >
              Tampilkan
            </button>
          </div>
        </div>
      </form>
    </div>
    <!-- END FORM -->

    <!-- DATA TABLE -->
    <div class="table-responsive mt-3">
      <table class="table" v-if="deviceData.length">
        <thead>
          <tr>
            <th>Timestamp</th>
            <th v-for="(value, key) in deviceData[0].payloads" :key="key">
              {{ key }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="data in deviceData" :key="data.time">
            <td>
              {{
                format(new Date(data.time), "d MMMM yyyy HH:mm", {
                  locale: id,
                })
              }}
            </td>
            <td
              v-for="(payload, key) in data.payloads"
              class="text-center"
              :key="key"
            >
              {{ isNaN(payload) ? payload : payload.toFixed(1) }}
            </td>
          </tr>
        </tbody>
      </table>
      <div v-else class="mt-3 p-4 border rounded text-center">
        <h3 class="text-muted">
          {{ emptyDataText }}
        </h3>
      </div>
    </div>
    <!-- END DATA TABLE -->
  </div>
</template>

<script>
import DatePicker from "vue3-date-time-picker";
import "vue3-date-time-picker/dist/main.css";
import { format, startOfDay } from "date-fns";
import { id } from "date-fns/locale";
import VueSelect from "vue-select";

export default {
  props: {
    device: Object,
  },
  components: {
    DatePicker,
    VueSelect,
  },
  data() {
    return {
      deviceData: [],
      aggregations: [
        "FIRST",
        "LAST",
        "COUNT",
        "MAX",
        "MIN",
        "MEDIAN",
        "MEAN",
        "SUM",
        "STD_DEV",
      ],
      resolutions: {
        "30 menit": 30,
        "1 jam": 60,
        "3 jam": 60 * 3,
      },
      form: {
        start_date: startOfDay(new Date()),
        end_date: null,
        errors: {},
        resolution: null,
        aggregation: null,
        isLoading: false,
        isNotSubmitted: true,
      },
      format,
      id,
      startOfDay,
    };
  },
  computed: {
    emptyDataText() {
      if (this.form.isLoading) {
        return "Loading...";
      }

      if (this.form.isNotSubmitted) {
        return `Klik tombol "Tampilkan" untuk memuat data.`;
      }

      return "Data tidak tersedia. Anda bisa mencoba query lain.";
    },
  },
  methods: {
    async submit() {
      this.form.errors = {};
      this.form.isLoading = true;
      this.deviceData = [];
      try {
        let response = await axios.get(
          route("losant.device.data.index", this.device.id),
          {
            params: this.form,
          }
        );
        this.deviceData = response.data.data;
      } catch (error) {
        if (error.response.status == 422) {
          Object.keys(error.response.data.errors).forEach((key) => {
            this.form.errors[key] = error.response.data.errors[key].join(" ");
          });
        }
      }

      this.form.isLoading = false;
      this.form.isNotSubmitted = false;
    },
    toggleAdvanced() {
      this.form.isAdvanced = !this.form.isAdvanced;
      this.form.resolution = null;
      this.form.aggregation = null;
    },
  },
};
</script>

<style>
</style>
