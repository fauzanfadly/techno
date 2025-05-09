<template>
  <div id="components-dialogs-messagedialog">
    <v-dialog
      v-model="_dialog"
      max-width="400"
      class="message-dialog"
    >
      <v-card class="pa-5 card-border" width="100%">
        <v-row justify="center">
          <v-col cols="auto" class="pb-3">
            <v-icon
              v-if="_icon !== ''"
              size="100"
              :color="getIconColor()"
            >
              {{ _icon }}
            </v-icon>
          </v-col>
        </v-row>
        <v-row justify="center">
          <v-col cols="auto" class="py-0">
            <p
              class="text-center"
              style="font-size: 24px"
              v-text="_message"
            />
          </v-col>
        </v-row>
        <v-row justify="center">
          <v-col cols="auto" class="py-0">
            <p v-if="_description !== ''" class="text-center">
              {{ _description }}
            </p>
          </v-col>
        </v-row>
        <v-card-actions v-if="_actionButtons.length > 0" class="mt-10">
          <v-row justify="space-between">
            <v-col
              v-for="(button, index) in _actionButtons"
              :key="index"
              :cols="_actionButtons.length === 1 ? '' : 'auto'"
            >
              <v-btn
                :width="_actionButtons.length === 1 ? '100%' : 'auto'"
                :color="button.color ? button.color : 'primary'"
                :class="(button.textColor ? button.textColor : 'white') + '--text'"
                @click="button.action ? customAction(button.action) : _dialog = false"
              >
                {{ button.text }}
              </v-btn>
            </v-col>
          </v-row>
        </v-card-actions>
        <v-card-actions v-else class="mt-10">
          <v-row justify="space-between">
            <v-col>
              <v-btn
                width="100%"
                color="primary"
                class="white--text"
                @click="_dialog = false"
              >
                Okay
              </v-btn>
            </v-col>
          </v-row>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script setup>
import {
  _dialog,
  _message,
  _description,
  _icon,
  _iconColor,
  _actionButtons
} from "../../utils/message_dialog";

const customAction = (action) => {
  action();
  _dialog.value = false;
}

const getIconColor = () => _iconColor.value || 'primary';
</script>
