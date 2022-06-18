<template>
  <VueSelect
    :loading="loading"
    :options="options"
    label="name"
    v-model="selected"
    @search="
      (keyword) => {
        params.keyword = keyword;
      }
    "
    @option:selected="$emit('update:modelValue', selected.id)"
  ></VueSelect>
</template>

<script>
import VueSelect from "vue-select";

export default {
  props: {
    modelValue: {
      default: null,
    },
    initialSelected: {
      default: {
          id: null,
          name: null
      },
    },
  },
  components: {
    VueSelect,
  },
  data() {
    return {
      options: [],
      selected: this.initialSelected,
      params: {
        keyword: null,
      },
      loading: false,
    };
  },
  watch: {
    params: {
      deep: true,
      handler(newValue, oldValue) {
        this.fetch();
      },
    },
  },
  mounted() {
    this.fetch();
  },
  methods: {
    fetch: _.debounce(async function () {
      this.loading = true;
      let response = await axios.get(route("organization.index"), {
        params: this.params,
      });

      this.options = response.data.data;
      this.loading = false;
    }, 350),
  },
};
</script>

<style>
</style>
