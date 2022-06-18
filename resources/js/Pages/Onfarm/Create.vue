<template>
  <div>
    <Head title="Daftarkan lahan"></Head>
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
        Tambah aktivitas
      </template>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card card-body p-4">
            <h3 class="text-primary font-bold">Form aktivitas tanam</h3>
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

            <form class="mt-3" @submit.prevent="submit()">
              <div class="form-group">
                <label for="">Nama Aktivitas</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="form.name"
                  :class="{ 'is-invalid': form.errors.name }"
                />
                <span class="invalid-feedback">{{ form.errors.name }}</span>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="">Tanggal mulai</label>
                    <date-picker
                      v-model="form.started_at"
                      format="yyyy-MM-dd"
                      locale="in-ID"
                      :enable-time-picker="false"
                      :monthChangeOnScroll="false"
                      :autoApply="true"
                      :inputClassName="`form-control ${
                        form.errors.started_at ? 'is-invalid' : ''
                      }`"
                    ></date-picker>
                    <span class="text-danger">{{
                      form.errors.started_at
                    }}</span>
                  </div>
                  <div class="col-md-6">
                    <label for="">Tanggal selesai (opsional)</label>
                    <date-picker
                      :start-date="form.started_at"
                      :markers="[{date: form.started_at}]"
                      v-model="form.finished_at"
                      locale="in-ID"
                      :enable-time-picker="false"
                      format="yyyy-MM-dd"
                      :monthChangeOnScroll="false"
                      :autoApply="true"
                      :inputClassName="`form-control ${
                        form.errors.finished_at ? 'is-invalid' : ''
                      }`"
                    ></date-picker>
                    <span class="text-danger">{{
                      form.errors.finished_at
                    }}</span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="">Deskripsi kegiatan</label>
                <ckeditor
                  :editor="editor"
                  v-model="form.description"
                  :config="config"
                ></ckeditor>
                <span class="text-danger">{{ form.errors.description }}</span>
              </div>
              <div class="form-group">
                <h4 class="text-primary font-bold">Rincian biaya</h4>
                <div
                  class="row mt-2"
                  v-for="(cost, index) in form.costs"
                  :key="index"
                >
                  <div class="col-md-6">
                    <label for="">Deskripsi biaya</label>
                    <input
                      class="form-control"
                      type="text"
                      v-model="form.costs[index].description"
                      :class="{
                        'is-invalid': form.errors[`costs.${index}.description`],
                      }"
                    />
                    <span class="invalid-feedback">{{
                      form.errors[`costs.${index}.description`]
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
                        v-model="form.costs[index].value"
                        :class="{
                          'is-invalid': form.errors[`costs.${index}.value`],
                        }"
                      />
                      <span class="invalid-feedback">{{
                        form.errors[`costs.${index}.value`]
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
              <div class="d-flex justify-content-end">
                <button class="btn btn-success" type="submit">
                  Simpan aktivitas
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
import { InertiaLink, Head } from "@inertiajs/inertia-vue3";
import Auth from "@/Layouts/Auth.vue";
import DatePicker from "vue3-date-time-picker";
import "vue3-date-time-picker/dist/main.css";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import CKEditor from "@ckeditor/ckeditor5-vue";
import { format } from "date-fns";
import { id } from "date-fns/locale";

export default {
  props: {
    planting: Object,
  },
  components: {
    Auth,
    Head,
    InertiaLink,
    DatePicker,
    ckeditor: CKEditor.component,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: null,
        category: null,
        description: null,
        started_at: null,
        finished_at: null,
        costs: [
          {
            description: "",
            value: "",
          },
        ],
      }),
      editor: ClassicEditor,
      config: {
        toolbar: [
          "heading",
          "|",
          "undo",
          "redo",
          "|",
          "bold",
          "italic",
          "link",
          "bulletedList",
          "numberedList",
          "blockQuote",
        ],
      },
      format,
      id,
    };
  },
  methods: {
    submit() {
      this.form.post(route("planting.onfarm.store", this.planting.id));
    },
    addCost() {
      this.form.costs.push({
        description: "",
        value: null,
      });
    },
    removeCost(index) {
      this.form.costs.splice(index, 1);
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
