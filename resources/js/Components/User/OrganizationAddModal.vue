<template>
  <div>
    <button
      class="btn btn-primary"
      data-bs-toggle="modal"
      data-bs-target="#addOrganization"
    >
      <i class="fa fa-plus me-1"></i> Daftarkan anggota
    </button>
    <div
      class="modal fade"
      id="addOrganization"
      tabindex="-1"
      aria-labelledby="addOrganizationLabel"
      aria-hidden="true"
    >
      <form @submit.prevent="submit" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addOrganizationLabel">
              Pilih Kelompok Tani
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
              <label class="form-label">Kelompok tani</label>
              <OrganizationSelect v-model="form.organization_id"></OrganizationSelect>
              <span
                v-if="form.errors.organization_id"
                class="form-text text-danger"
                >{{ form.errors.organization_id }}</span
              >
            </div>
            <div class="mb-3">
              <label for="member_type">Tipe keanggotaan</label>
              <div>
                <div class="form-check form-check-inline">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="inlineRadioOptions"
                    id="member"
                    value="member"
                    v-model="form.member_type"
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
                    v-model="form.member_type"
                  />
                  <label class="form-check-label" for="leader">Ketua</label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn" data-bs-dismiss="modal">
              Close
            </button>
            <button
              type="submit"
              class="btn btn-primary"
              :class="{ disabled: form.processing }"
            >
              Daftarkan anggota
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import VueSelect from "vue-select";
import bootstrap from "bootstrap/dist/js/bootstrap.bundle";
import OrganizationSelect from '@/Components/Organization/OrganizationSelect.vue';

export default {
  props: {
    user: Object,
  },
  components: {
    VueSelect,
    OrganizationSelect
  },
  data() {
    return {
      form: this.$inertia.form({
        organization_id: null,
        member_type: "member",
      }),
    };
  },
  methods: {
    submit() {
      var modal = bootstrap.Modal.getInstance(
        document.getElementById("addOrganization")
      );
      this.form.post(route("user.organization.store", this.user.id), {
        onSuccess: function () {
          modal.hide();
        },
      });
    },
  },
};
</script>

<style>
</style>
