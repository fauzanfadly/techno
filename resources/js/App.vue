<template>
    <v-app>
        <router-view></router-view>
    </v-app>
</template>

<script setup>
import { ref } from "vue";
import { RouterView } from 'vue-router';

const handleClick = () => {
    alert("Button clicked!");
};
</script>
