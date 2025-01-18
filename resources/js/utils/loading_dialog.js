import { ref } from "vue";


export const show = ref(false);

export function openLoading (value = true) {
    show.value = value;
}

export function closeLoading (value = false) {
    show.value = value;
}
