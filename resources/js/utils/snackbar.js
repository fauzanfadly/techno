import { ref } from "vue";


export const stackSnackbar = ref([]);
const acceptedStatus = {
    success: 'green',
    danger: 'red',
    error: 'red',
    warning: 'orange darken-1',
}


const mobileWidth = () => {
    return window.innerWidth < 960;
};

export const openSnackbar = ({ message, status }) => {
    if (!acceptedStatus[status]) {
        console.error(`Error when opening snackbar, there's no status with "${status}"`);
        return;
    }

    if (mobileWidth()) {
        stackSnackbar.value = [];
    };
    stackSnackbar.value.push({
        message: message,
        status: acceptedStatus[status],
        show: true
    });
    setTimeout(() => {
        removeSnackbar(0);
    }, 3000);
}

export const removeSnackbar = (index) => {
    return stackSnackbar.value.splice(index, 1);
}
