<template>
  <div>
    <h3 class="text-primary font-bold m-0">Informasi panen dan penerimaan</h3>
    <div class="text-center p-4 border mt-3" v-if="planting.harvested_at == null">
        <h3 class="text-muted">Tambahkan data pemanenan dan penerimaan</h3>
        <InertiaLink class="btn btn-success" :href="route('planting.harvest.create', planting.id)">
           <i class="fab fa-pagelines"></i> Panen
        </InertiaLink>
    </div>
    <div class="card card-body p-4 mt-3" v-else>
      <div class="row">
        <div class="col-md-6 d-flex align-items-start">
          <div class="me-3">
            <i class="fab fa-pagelines fa-2x text-success"></i>
          </div>
          <div>
            <b>Tanggal panen</b><br />
            <span>{{
              format(new Date(planting.harvested_at), "d MMMM yyyy", {
                locale: id,
              })
            }}</span>
          </div>
        </div>
        <div class="col-md-6 d-flex align-items-start">
          <div class="me-3">
            <i class="fas fa-balance-scale fa-2x text-success"></i>
          </div>
          <div>
            <b>Total hasil panen</b><br />
            <span>{{ planting.yield }} Kg</span>
          </div>
        </div>
      </div>

      <div class="mt-3 row">
        <div class="col-md-6 d-flex align-items-start">
          <div class="me-3">
            <i class="fas fa-balance-scale fa-2x text-success"></i>
          </div>
          <div>
            <b>Released Volume</b><br />
            <span>{{ planting.released_quantity }} Kg</span>
          </div>
        </div>
        <div class="col-md-6 d-flex align-items-start">
          <div class="me-3">
            <i class="fas fa-balance-scale fa-2x text-success"></i>
          </div>
          <div>
            <b>Unreleased Volume</b><br />
            <span>{{ planting.unreleased_quantity }} Kg</span>
          </div>
        </div>
      </div>

      <div class="mt-4" v-if="planting.harvest_quality">
        <table class="table">
          <thead>
            <tr>
              <th>Mutu Kedelai</th>
              <th>Nilai</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Kadar air</td>
              <td>{{ planting.harvest_quality.water_content }} %</td>
            </tr>
            <tr>
              <td>Kotoran</td>
              <td>{{ planting.harvest_quality.dirts }} %</td>
            </tr>
            <tr>
              <td>Discolors</td>
              <td>{{ planting.harvest_quality.discolors }} %</td>
            </tr>
            <tr>
              <td>Split</td>
              <td>{{ planting.harvest_quality.splits }} %</td>
            </tr>
            <tr>
              <td>Rusak</td>
              <td>{{ planting.harvest_quality.damaged }} %</td>
            </tr>
            <tr>
              <td>Jamur</td>
              <td>{{ planting.harvest_quality.fungal }} %</td>
            </tr>
            <tr>
              <td>Kutu</td>
              <td>{{ planting.harvest_quality.bugs }} %</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="border rounded p-3 border-dark">
        <div class="mb-1 font-bold">Rincian biaya</div>
        <div
          v-for="cost in planting.harvest_costs"
          :key="cost.description"
          class="d-flex justify-content-between py-1"
        >
          <div>
            {{ cost.description }}
          </div>
          <div>Rp{{ cost.value }},00</div>
        </div>
        <hr />
        <div class="d-flex justify-content-between font-bold">
          <div>Total biaya</div>
          <div>Rp{{ planting.harvest_total_cost }},00</div>
        </div>
      </div>
    </div>
    <InertiaLink
      v-if="planting.harvested_at"
      class="btn btn-warning"
      :href="route('planting.harvest.create', planting.id)"
    >
      <i class="fa fa-edit"></i> Edit info panen
    </InertiaLink>
  </div>
</template>

<script>
import { format, formatDistanceToNow } from "date-fns";
import { id } from "date-fns/locale";
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
  props: {
    planting: {
      type: Object,
      default: null,
    },
  },
  components: {
    InertiaLink,
  },
  data() {
    return {
      format,
      id,
      formatDistanceToNow,
    };
  },
};
</script>

<style lang="scss" scoped>
</style>
