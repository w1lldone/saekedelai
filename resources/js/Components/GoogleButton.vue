<template>
    <a :href="route('auth.google.redirect')" class="btn btn-lg btn-light">
        <img src="/img/google_logo.svg" class="img-fluid me-3" alt="" width="35">
        Sign in with Google
    </a>
</template>

<script>
export default {

}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap');

.btn {
    font-family: 'Roboto', sans-serif;
    color: #6d6d6d;
    font-size: 1.3rem;
}

</style>
