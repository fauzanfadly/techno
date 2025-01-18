import { ref } from "vue";
import { getStorageFile } from "./storage";


export const _props = ref({
    show: false,
    imageSrc: "",
    imagePath: "",
    imageHeight: null,
    imageWidth: null,
});

export const openImageFullscreen = (image) => {
    _props.value.imagePath = image.image_path || image.path || image;
    _props.value.imageSrc = getStorageFile(_props.value.imagePath);

    const _image = new Image();
    _image.src = _props.value.imageSrc;

    _image.onload = () => {
        _props.value.imageHeight = _image.naturalHeight;
        _props.value.imageWidth = _image.naturalWidth;
    };

    _props.value.show = true;
}
