<template>
  <div>
    <Head title="Pengaturan Atribut Perangkat"></Head>
    <Auth>
      <template #header>
        <InertiaLink class="text-primary" :href="route('device.index')"
          >Perangkat</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i
        ><InertiaLink
          class="text-primary"
          :href="route('device.show', device.id)"
          >Detail perangkat</InertiaLink
        >
        <i class="fa fa-chevron-right mx-2"></i>Pengaturan atribut
      </template>

      <!-- CARD -->
      <div class="row justify-content-center">
        <!-- col-md-8 -->
        <div class="col-md-8">
          <!-- CARD -->
          <div class="card card-body p-4">
            <h3 class="text-primary font-bold">Pengaturan atribut</h3>
            <!-- FORM -->
            <form @submit.prevent="submit()">
              <div class="form-group mb-3">
                <span>Nama perangkat: {{ device.name }}</span
                ><br />
              </div>

              <!--  -->
              <div class="alert alert-info" role="alert">
                <strong>Penggunaan Rumus Konversi</strong><br><br>
                <div>
                    <code class="me-5">x</code>
                    <span>: Nilai sensor</span>
                </div>
                <div>
                    <code class="me-5">*</code>
                    <span>: Perkalian</span>
                </div>
                <div>
                    <code class="me-5">/</code>
                    <span>: Pembagian</span>
                </div>
                <div>
                    <code class="me-5">-</code>
                    <span>: Pengurangan</span>
                </div>
                <div>
                    <code class="me-5">+</code>
                    <span>: Penjumlahan</span>
                </div>
              </div>

              <!-- Attributes Input -->
              <div
                v-for="(attribute, index) in form.payload_attributes"
                :key="attribute.name"
              >
                <h4 class="text-primary font-bold">{{ attribute.name }}</h4>
                <div class="row">
                  <div class="col-md-3">
                    <label for="">Satuan</label>
                    <input
                      v-model="form.payload_attributes[index].unit"
                      type="text"
                      class="form-control"
                      :class="{
                        'is-invalid':
                          form.errors[`payload_attributes.${index}.unit`],
                      }"
                    />
                  </div>
                  <div class="col-md-9">
                    <label for="">Rumus konversi</label>
                    <input
                      v-model="form.payload_attributes[index].conversion"
                      type="text"
                      class="form-control"
                      placeholder="x * 100"
                      :class="{
                        'is-invalid':
                          form.errors[`payload_attributes.${index}.conversion`],
                      }"
                    />
                  </div>
                </div>
                <div class="text-danger mt-2">
                  <span>{{
                    form.errors[`payload_attributes.${index}.unit`]
                  }}</span
                  ><br />
                  <span>{{
                    form.errors[`payload_attributes.${index}.conversion`]
                  }}</span
                  ><br />
                </div>
              </div>
              <!-- END Attributes input -->

              <div class="form-group pt-3 d-flex justify-content-end">
                <button
                  class="btn btn-success"
                  type="submit"
                  :disabled="form.processing"
                >
                  Simpan pengaturan
                </button>
              </div>
            </form>
          </div>
          <!-- END CARD -->
        </div>
        <!-- end col-md-8 -->
      </div>
      <!-- END CARD -->
    </Auth>
  </div>
</template>

<script>
import { InertiaLink, Head } from "@inertiajs/inertia-vue3";
import Auth from "@/Layouts/Auth.vue";

export default {
  props: {
    device: Object,
  },
  components: {
    Auth,
    Head,
    InertiaLink,
  },
  data() {
    return {
      form: this.$inertia.form({
        payload_attributes: this.device.payload_attributes,
      }),
    };
  },
  methods: {
    submit() {
      this.form.put(route("device.updateAttributes", this.device.id), {
        onError: (errors) => {
          alert(
            "Mohon periksa kembali Satuan atau Rumus konversi yang ada masukkan."
          );
        },
      });
    },
  },
};
</script>

<style>
</style>
