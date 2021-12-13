<template>
    <Head title="Users List"></Head>
    <authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users List
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                    <tr>
                                        <th class="text-left p-2">Nama</th>
                                        <th class="text-left p-2">Email</th>
                                        <th class="text-left p-2">Role</th>
                                        <th class="text-left p-2">Action</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100">
                                    <tr v-for="user in users.data" :key="user.id">
                                        <td class="p-2 py-4">
                                            <Link
                                            class="underline text-blue-600"
                                            :href="route('user.show', user.id)"
                                            >
                                                {{ user.name }}
                                            </Link>
                                        </td>
                                        <td class="p-2 py-4">{{ user.email }}</td>
                                        <td class="p-2 py-4">
                                            <span v-if="user.is_superadmin">Admin</span>
                                            <span v-else>Member</span>
                                        </td>
                                        <td class="p-2 py-4"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <div class="mt-2 flex items-center justify-center">
                <pagination :links="users.links"></pagination>
            </div>
            </div>
        </div>
    </authenticated-layout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from "@inertiajs/inertia-vue3";
import Pagination from '@/Components/Pagination.vue';

export default {
    components: {
        Head,
        AuthenticatedLayout,
        Pagination,
        Link
    },
    props: {
        users: Object
    }
}
</script>

<style lang="scss" scoped>

</style>
