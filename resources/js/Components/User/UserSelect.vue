<template>
  <VueSelect
    :multiple="multiple"
    label="name"
    :options="users"
    v-model="selected"
    @search="handleSearch"
    @option:selected="handleSelected"
    placeholder="Cari nama, email atau NIK pengguna"
  >
    <template #option="{ name, address, organizations }">
      <b style="margin: 0">{{ name }}</b
      ><br />
      <span v-if="organizations.length">
          Poktan <span v-for="organization in organizations" :key="organization.id">{{ organization.name }}</span>
      </span>
      <span v-else
        >{{ address.province }} {{ address.city }} {{ address.district }}</span
      >
    </template></VueSelect
  >
</template>

<script>
import VueSelect from "vue-select";

export default {
  props: {
    modelValue: {
      default: null,
    },
    queries: Object,
    multiple: Boolean,
  },
  data() {
    return {
      users: [
        {
          name: "",
        },
      ],
      selected: null,
      params: {
        keyword: "",
      },
    };
  },
  components: {
    VueSelect,
  },
  mounted() {
    this.fetch();
    this.params = { ...this.params, ...this.queries };
  },
  methods: {
    async fetch() {
      let response = await axios.get(route("user.index"), {
        params: this.params,
      });

      this.users = response.data.data;
    },
    handleSearch(search) {
      this.params.keyword = search;
      this.debouncedFetch();
    },
    debouncedFetch: _.debounce(function () {
      this.fetch();
    }, 350),
    handleSelected() {
      if (Array.isArray(this.selected)) {
        return this.$emit(
          "update:modelValue",
          this.selected.map((item) => item.id)
        );
      }

      return this.$emit("update:modelValue", this.selected.id);
    },
  },
};
</script>

<style>
</style>
