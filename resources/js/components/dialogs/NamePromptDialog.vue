<template>
    <v-dialog v-model="_namePrompt.show" max-width="420">
        <v-card>
            <v-card-title>{{ _namePrompt.title }}</v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-text-field
                    v-model="_namePrompt.name"
                    :label="_namePrompt.label"
                    density="comfortable"
                    autofocus
                    @keyup.enter="submit"
                ></v-text-field>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="closeNamePrompt">Batal</v-btn>
                <v-btn color="deep-orange" :disabled="!_namePrompt.name" @click="submit">
                    {{ _namePrompt.confirmText }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { _namePrompt, closeNamePrompt } from '../../utils/name_prompt_dialog';

const submit = () => {
    const name = (_namePrompt.value.name || '').trim();
    if (!name) return;
    const cb = _namePrompt.value.onSubmit;
    closeNamePrompt();
    if (cb) cb(name);
};
</script>
