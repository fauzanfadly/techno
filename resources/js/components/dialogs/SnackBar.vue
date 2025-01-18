<template>
  <div>
    <v-snackbar
      v-for="(snackbar, index) in stackSnackbar"
      :key="index"
      elevation="0"
      v-model="snackbar.show"
      :style="{ 'top': calcMargin(index) }"
      :color="snackbar.status.toLowerCase()"
      :timeout="3000"
      location="top right"
    >
      <span
        class="text-white font-weight-medium"
        v-text="snackbar.message"
      />
      <template #actions="{ attrs }">
        <v-btn
          icon
          v-bind="attrs"
          color="white"
          @click="removeSnackbar(index)"
        >
          <v-icon>
            mdi-close
          </v-icon>
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>


<script setup>
import { stackSnackbar, removeSnackbar } from "../../utils/snackbar";


function calcMargin (index) {
  return `${(index * 60)}px`;
}
</script>
