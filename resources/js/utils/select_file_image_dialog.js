import { ref } from 'vue';


export const _dialogProps = ref({
    show: false,
    contentType: "IMAGE",
    image: null,
});


export const openSelectImageDialog = (value = true) => {
    _dialogProps.value.show = value;
    _dialogProps.value.contentType = "IMAGE";

    return _dialogProps.value.image;
}

export const closeSelectImageDialog = (value = false) => {
    _dialogProps.value.show = value;
    _dialogProps.value.contentType = "IMAGE";
}

export const openSelectFileDialog = (value = true) => {
    _dialogProps.value.show = value;
    _dialogProps.value.contentType = "FILE";

    return _dialogProps.value.image;
}

export const closeSelectFileDialog = (value = false) => {
    _dialogProps.value.show = value;
    _dialogProps.value.contentType = "FILE";
}
