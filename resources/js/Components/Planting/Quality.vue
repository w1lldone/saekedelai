<template>
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
        <td>{{ quality.water_content }} %</td>
      </tr>
      <tr>
        <td>Kotoran</td>
        <td>{{ quality.dirts }} %</td>
      </tr>
      <tr>
        <td>Discolors</td>
        <td>{{ quality.discolors }} %</td>
      </tr>
      <tr>
        <td>Split</td>
        <td>{{ quality.splits }} %</td>
      </tr>
      <tr>
        <td>Rusak</td>
        <td>{{ quality.damaged }} %</td>
      </tr>
      <tr>
        <td>Jamur</td>
        <td>{{ quality.fungal }} %</td>
      </tr>
      <tr>
        <td>Kutu</td>
        <td>{{ quality.bugs }} %</td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: {
    quality: {
      type: Object,
      default: null,
    },
  },
};
</script>

<style>
</style>
