import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
    state: () => ({
        id: null,
        email: null,
        name: null,
        token: null,
        isLoggedIn: false,
    }),

    persist: true,

    actions: {
        login({
            id = this.id,
            email = this.email,
            name = this.name,
            token = this.token,
            isLoggedIn = true,
        }) {
            this.id = id;
            this.email = email;
            this.name = name;
            this.token = token;
            this.isLoggedIn = isLoggedIn;
        },

        logout() {
            this.id = null;
            this.email = null;
            this.name = null;
            this.token = null;
            this.isLoggedIn = false;
        },
    },
});