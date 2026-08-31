const baseUrl = window.location.origin;

export const getStorageFile = (filePath) => {
    return `${baseUrl}/storage/${filePath}`;
}
