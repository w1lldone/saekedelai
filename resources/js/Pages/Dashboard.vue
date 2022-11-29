<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <div class="row">
            <div class="col-12 text-center py-auto">
                <h1 class="font-bold text-muted">
                    Selamat datang di Saekedelai!
                </h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-body p-4">
                    <p>
                        Software Traceability System dalam Smart Agricultural Enterprise (SAE) kedelai merupakan aplikasi yang digunakan dalam melakukan pendataan secara realtime penanaman kemitraan petani yang menerapkan standart budidaya tanam kedelai  dari  lokasi lahan,  luasan lahan, kelompok petani mitra,  penjadwalan dan pengolahan budidaya dari menanam, pemeliharaan, panen dan pasca panen.  Hasil pasca panen dilakukan proses hingga kedelai di kemas untuk di kirimkan ke Industri.
                    </p>
                    <p>
                        Dalam aplikasi terdapat fitur: manajemen kelompok petani,  manajemen lahan, manajemen penanaman dan pemeliharaan, panen, pasca panen, dan pengemasan akhir.
                    </p>
                    <p>
                        Fitur traceability memudahkan pengelolaan budidaya kedelai menggunakan IPTEKs SAE Kedelai dan monitoring dan pengukuran untuk pemenuhhan standart mutu hasil panen kedelai.
                    </p>
                    <p>
                        Disamping itu terdapat juga fitur Field Monitoring System (FMS) yang di tempatkan di lahan sentra produksi kedelai untuk pengamatan suhu dan iklim, baik mikro didalam tanah dan makro kondisi lingkungan lahan.
                    </p>
                </div>
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
