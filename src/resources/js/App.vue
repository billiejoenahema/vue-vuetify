<script setup>
import { RouterView } from "vue-router";
import Header from "@/components/Header.vue";
</script>

<template>
  <v-app>
    <Header />
    <RouterView />
  </v-app>
</template>
