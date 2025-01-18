<template>
    <v-dialog v-model="show" persistent max-width="fit-content" app>
        <v-card color="deep-orange" elevation="0" class="pa-3" dark>
            <v-progress-circular indeterminate width="7" color="white" />
        </v-card>
    </v-dialog>
</template>

<script setup>
import { show } from "../../utils/loading_dialog";
</script>
