import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import * as VStepperVertical from 'vuetify/labs/VStepperVertical';

import "@mdi/font/css/materialdesignicons.css";

const vuetify = createVuetify({
    components: {
        ...components,
        ...VStepperVertical
    },
    defaults: {
        VTextField: {
            density: "compact",
            variant: "outlined",
        },
        VSelect: {
            density: "compact",
            variant: "outlined",
        },
        VAutocomplete: {
            density: "compact",
            variant: "outlined",
        },
        VFileInput: {
            density: "compact",
            variant: "outlined",
        }
    },
    directives,
    icons: {
        defaultSet: "mdi",
    },
    theme: {
        defaultTheme: "light",
        themes: {
            light: {
                dark: false,
                colors: {
                    primary: "#1565C0",
                    "primary-darken-1": "#0D47A1",
                    "primary-lighten-1": "#42A5F5",
                    accent: "#D32F2F",
                    secondary: "#6B7280",
                    error: "#DC2626",
                    info: "#0EA5E9",
                    success: "#059669",
                    warning: "#D97706",
                    background: "#FAFAFA",
                    surface: "#FFFFFF",
                    "surface-variant": "#F5F5F5",
                    "on-primary": "#FFFFFF",
                    "on-secondary": "#FFFFFF",
                    "on-accent": "#FFFFFF",
                    "on-surface": "#212121",
                    "on-background": "#212121",
                },
            },
            dark: {
                dark: true,
                colors: {
                    primary: "#42A5F5",
                    "primary-darken-1": "#1565C0",
                    "primary-lighten-1": "#90CAF9",
                    accent: "#EF5350",
                    secondary: "#9CA3AF",
                    error: "#F87171",
                    info: "#38BDF8",
                    success: "#34D399",
                    warning: "#FBBF24",
                    background: "#121212",
                    surface: "#1E1E1E",
                    "surface-variant": "#2D2D2D",
                    "on-primary": "#000000",
                    "on-secondary": "#000000",
                    "on-accent": "#000000",
                    "on-surface": "#FAFAFA",
                    "on-background": "#FAFAFA",
                },
            },
        },
    },
});

export default vuetify;
