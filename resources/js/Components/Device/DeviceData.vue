<template>
  <div>
    <!-- FORM -->
    <div>
      <form @submit.prevent="submit()">
        <div class="row">
          <div class="col-md-10">
            <div class="row align-items-end">
              <div class="col-md-4">
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
              <div class="col-md-4">
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
                <button type="submit" class="btn btn-success" :disabled="form.isLoading">Tampilkan</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- END FORM -->

    <!-- DATA TABLE -->
    <div>
      <table class="table table-responsive" v-if="deviceData.length">
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
            <td v-for="(payload, key) in data.payloads" class="text-center">
              {{ payload }}
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

export default {
  props: {
    device: Object,
  },
  components: {
    DatePicker,
  },
  data() {
    return {
      deviceData: [],
      form: {
        start_date: startOfDay(new Date()),
        end_date: null,
        errors: {},
        isLoading: false,
        isNotSubmitted: true,
      },
      format,
      id,
      startOfDay
    };
  },
  computed: {
    emptyDataText() {
        if (this.form.isLoading) {
            return "Loading..."
        }

        if (this.form.isNotSubmitted) {
            return `Klik tombol "Tampilkan" untuk memuat data.`
        }

        return "Data tidak tersedia. Anda bisa mencoba query lain."
    }
  },
  methods: {
    async submit() {
      this.form.isLoading = true;
      this.deviceData = [];
      let response = await axios.get(
        route("losant.device.data.index", this.device.id),
        {
          params: this.form,
        }
      );

      this.form.isLoading = false;
      this.form.isNotSubmitted = false;
      this.deviceData = response.data.data;
    },
  },
};
</script>

<style>
</style>
