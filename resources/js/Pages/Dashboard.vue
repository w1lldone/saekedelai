<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <div class="row">
            <div class="col-12 text-center py-auto">
                <h1 class="font-bold text-muted">
                    Dashboard dalam pengembangan
                </h1>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Auth.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
}
</script>
