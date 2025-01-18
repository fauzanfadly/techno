const baseUrl = window.location.origin;

export const getStorageFile = (filePath) => {
    return `${baseUrl}/storage/${filePath}`;
}

const checkPathExist = (imgPath, fullPath) => {
    return new Promise((resolve, reject) => {
        const acceptedExt = ['png', 'jpg', 'jpeg'];
        let _result = null;

        acceptedExt.map(async (ext) => {
            if (!_result) {
                const _img = new Image();
                _img.src = `${fullPath}.${ext}`;

                _img.onload = () => {
                    _result = `${fullPath}.${ext}`;
                }
            }
        });

        if (!_result) {
            const _msg = `Image with path "${imgPath}" not found`;
            // console.error(_msg);
            reject(_msg);
        } else {
            console.log(`Image "${imgPath}" loaded`);
            resolve(_result);
        }
    });
}

export const manufactureImg = ({ manufactureId }) => {
    let _imagePath = `manufacture_type_${manufactureId}_img`;
    let _fullPath = `${baseUrl}/images/manufacture_type_${manufactureId}/${_imagePath}`;

    return `${_fullPath}`;
}

export const vendorImg = ({ manufactureId, vendorId }) => {
    let _imagePath = `vendor_${vendorId}_img`;
    let _fullPath = `${baseUrl}/images/manufacture_type_${manufactureId}/vendor_${vendorId}/${_imagePath}`;

    return `${_fullPath}`;
}

export const categoryImg = ({ manufactureId, vendorId, categoryId }) => {
    let _imagePath = `category_${categoryId}_img`;
    let _fullPath = `${baseUrl}/images/manufacture_type_${manufactureId}/vendor_${vendorId}/category_${categoryId}/${_imagePath}`;

    return `${_fullPath}`;
}

export const seriesImg = ({ manufactureId, vendorId, categoryId, seriesId }) => {
    let _imagePath = `series_${seriesId}_img`;
    let _fullPath = `${baseUrl}/images/manufacture_type_${manufactureId}/vendor_${vendorId}/category_${categoryId}/series/${_imagePath}`;

    return `${_fullPath}`;
}

export const productImg = ({ manufactureId, vendorId, categoryId, seriesId, productId }) => {
    let _imagePath = `series_${seriesId}_product_${productId}_img`;
    let _fullPath = `${baseUrl}/images/manufacture_type_${manufactureId}/vendor_${vendorId}/category_${categoryId}/series/product/${_imagePath}`;

    return `${_fullPath}`;
}

export const seriesPdf = ({ manufactureId, vendorId, categoryId, seriesId }) => {
    let _imagePath = `series_${seriesId}_pdf`;
    let _fullPath = `${baseUrl}/pdf/manufacture_type_${manufactureId}/vendor_${vendorId}/category_${categoryId}/series/${_imagePath}`;

    return `${_fullPath}`;
}

export const productPdf = ({ manufactureId, vendorId, categoryId, seriesId, productId }) => {
    let _imagePath = `series_${seriesId}_product_${productId}_pdf`;
    let _fullPath = `${baseUrl}/pdf/manufacture_type_${manufactureId}/vendor_${vendorId}/category_${categoryId}/series/product/${_imagePath}`;

    return `${_fullPath}`;
}

export const rawStorage = {
    manufactureImg,
    vendorImg,
    categoryImg,
    seriesImg,
    productImg,
    seriesPdf,
    productPdf,
}
