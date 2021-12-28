<template>
  <div>
    <button
      class="btn btn-primary"
      data-bs-toggle="modal"
      data-bs-target="#addUser"
    >
      <i class="fa fa-plus"></i> Tambah anggota
    </button>
    <div
      class="modal fade"
      id="addUser"
      tabindex="-1"
      aria-labelledby="addUserLabel"
      aria-hidden="true"
    >
      <form @submit.prevent="submit" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addUserLabel">
              Pilih anggota terdaftar
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="" class="form-label">Cari Anggota</label>
              <VueSelect
                multiple
                :loading="fetching"
                :options="users"
                label="name"
                :reduce="(user) => user.id"
                v-model="form.user_id"
                @search="onSearch"
              >
                <template #option="{ name, address }">
                  <b style="margin: 0">{{ name }}</b
                  ><br />
                  <span
                    >{{ address.province }} {{ address.city }}
                    {{ address.district }}</span
                  >
                </template>
              </VueSelect>
            </div>
            <div class="mb-3">
              <label for="member_type">Tipe keanggotaan</label>
              <div>
                <div class="form-check form-check-inline">
                  <input
                    checked
                    class="form-check-input"
                    type="radio"
                    name="inlineRadioOptions"
                    id="member"
                    value="member"
                    :disabled="form.user_id == null"
                  />
                  <label class="form-check-label" for="member">Member</label>
                </div>
                <div class="form-check form-check-inline">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="inlineRadioOptions"
                    id="leader"
                    value="leader"
                    :disabled="form.user_id == null"
                  />
                  <label class="form-check-label" for="leader">Ketua</label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a
              class="small me-auto"
              :href="route('user.create', { organization_id: organization.id })"
            >
              Anggota tidak terdaftar? Buat anggota baru.
            </a>
            <button type="button" class="btn" data-bs-dismiss="modal">
              Close
            </button>
            <button
              type="submit"
              class="btn btn-primary"
              :class="{ disabled: form.processing }"
            >
              Simpan Anggota
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";
import VueSelect from "vue-select";
import bootstrap from "bootstrap/dist/js/bootstrap.bundle";

export default {
  props: {
    organization: Object,
  },
  components: {
    InertiaLink,
    VueSelect,
  },
  data() {
    return {
      form: this.$inertia.form({
        user_id: [],
        member_type: "member",
      }),
      users: [],
      keyword: null,
      fetching: false,
    };
  },
  created() {
    this.debouncedFetchUsers = _.debounce(this.fetchUsers, 300);
  },
  mounted() {
    this.fetchUsers();
  },
  methods: {
    submit() {
      var modal = bootstrap.Modal.getInstance(
        document.getElementById("addUser")
      );

      var form = this.form;

      form.post(route("organization.user.store", this.organization.id), {
        onSuccess: function () {
          modal.hide();
          form.reset();
        },
      });
    },
    onSearch(keyword) {
      this.keyword = keyword;
      this.debouncedFetchUsers();
    },
    fetchUsers: async function () {
      this.fetching = true;
      let response = await axios.get(
        route("user.index", {
          keyword: this.keyword,
        })
      );

      this.users = response.data.data;

      this.fetching = false;
    },
  },
};
</script>

<style>
</style>
