<template>
  <Line
    :chart-options="chartOptions"
    :chart-data="computedData"
    :chart-id="chartId"
    :plugins="plugins"
    :css-classes="cssClasses"
    :styles="styles"
    :width="width"
    :height="height"
  />
</template>

<script>
import { format } from "date-fns";
import { id } from "date-fns/locale";
import { Line } from "vue-chartjs";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  LinearScale,
  PointElement,
  CategoryScale,
  Plugin,
} from "chart.js";

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  LinearScale,
  PointElement,
  CategoryScale
);

export default {
  name: "LineChart",
  components: {
    Line,
  },
  props: {
    chartId: {
      type: String,
      default: "line-chart",
    },
    width: {
      type: Number,
      default: 400,
    },
    height: {
      type: Number,
      default: 150,
    },
    cssClasses: {
      default: "",
      type: String,
    },
    styles: {
      default: () => {},
    },
    plugins: {
      default: () => [],
    },
    deviceData: Array,
  },
  data() {
    return {
      format,
      id,
    };
  },
  computed: {
    computedData() {
      if (!this.deviceData.length) {
        return [];
      }

      var datasets = [];

      Object.keys(this.deviceData[0].payloads).forEach((item, key) => {
        var data = {};
        data.label = item;
        data.data = [];
        var color = this.randomColor()
        data.backgroundColor = color;
        data.borderColor = color;
          this.deviceData.forEach((uplink) => {
            data.data.push({
              x: format(new Date(uplink.time), "d MMMM yyyy HH:mm", {
                locale: id,
              }),
              y: uplink.payloads[item],
            });
          });
        datasets.push(data);
      });

      return {
        datasets: datasets,
      };
    },
  },
  methods: {
    randomColor() {
      var r = Math.floor(Math.random() * 255);
      var g = Math.floor(Math.random() * 255);
      var b = Math.floor(Math.random() * 255);
      return "rgb(" + r + "," + g + "," + b + ")";
    },
  },
};
</script>
