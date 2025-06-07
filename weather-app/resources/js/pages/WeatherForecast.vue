<template>
  <div class="p-8 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">5-Day Weather Forecast</h1>

    <select v-model="selectedCity" class="border p-2 rounded">
      <option disabled value="">Select a city</option>
      <option v-for="city in cities" :key="city" :value="city">
        {{ city }}
      </option>
    </select>

    <div v-if="forecast.length" class="mt-4">
      <h2 class="font-semibold mb-2">Forecast for {{ selectedCity }}</h2>
      <ul>
        <li v-for="day in forecast" :key="day.date">
          {{ day.date }} – Avg: {{ day.avg }}°C, Max: {{ day.max }}°C, Min: {{ day.min }}°C
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Forecast',
  data() {
    return {
      cities: ['Brisbane', 'Gold Coast', 'Sunshine Coast'],
      selectedCity: '',
      forecast: []
    };
  },
  watch: {
    selectedCity(newCity) {
      if (newCity) this.fetchForecast(newCity);
    }
  },
  methods: {
    async fetchForecast(city) {
      try {
        const response = await axios.get('http://localhost:8000/api/forecast/' + city);
        this.forecast = response.data;
      } catch (error) {
        console.error("Forecast load error:", error);
        alert("Failed to load forecast.");
      }
    }
  }
};
</script>