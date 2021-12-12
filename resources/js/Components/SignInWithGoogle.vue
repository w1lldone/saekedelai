<template>
  <div class="flex justify-center">
    <a :href="route('auth.google.redirect')" class="w-3/5">
      <img src="/img/google_sign_in.png" alt="" />
    </a>
  </div>
</template>

<script>
export default {
  setup() {
    return {};
  },
};
</script>

<style lang="scss" scoped>
</style>
