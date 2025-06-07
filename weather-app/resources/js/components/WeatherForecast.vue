<template>
  <div>
    <h1>5 Day Weather Forecast</h1>
    <select v-model="selectedCity" @change="getForecast">
      <option disabled value="">Select a city</option>
      <option>Brisbane</option>
      <option>Gold Coast</option>
      <option>Sunshine Coast</option>
    </select>

    <div v-if="forecast">
      <h2>Forecast for {{ selectedCity }}</h2>
      <ul>
        <li v-for="day in forecast" :key="day.date">
          {{ day.date }} - Avg: {{ day.avg }}°C, Min: {{ day.min }}°C, Max: {{ day.max }}°C
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      selectedCity: '',
      forecast: null,
    };
  },
  methods: {
    async getForecast() {
      try {
        const response = await axios.get(`/api/forecast/${this.selectedCity}`);
        this.forecast = response.data;
      } catch (error) {
        alert("Failed to load weather data.");
      }
    },
  },
};
</script>