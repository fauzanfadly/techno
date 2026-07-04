<template>
    <v-dialog v-model="show" persistent max-width="fit-content" app>
        <v-card color="primary" elevation="0" class="pa-3">
            <v-progress-circular indeterminate width="7" color="white" />
        </v-card>
    </v-dialog>
</template>

<script setup>
import { show } from "../../utils/loading_dialog";
</script>
