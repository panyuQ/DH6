<template>
  <div>
    <h1>Labs</h1>
    <ul>
      <li v-for="lab in labs" :key="lab.id">{{ lab.name }}</li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      labs: []
    };
  },
  created() {
    this.fetchLabs();
  },
  methods: {
    async fetchLabs() {
      try {
        const response = await axios.get('http://localhost:8081/api/labs');
        this.labs = response.data;
      } catch (error) {
        console.error('Error fetching labs:', error);
      }
    }
  }
};
</script>

<style scoped>
ul {
  list-style-type: none;
  padding: 0;
}
li {
  margin: 10px 0;
}
</style>