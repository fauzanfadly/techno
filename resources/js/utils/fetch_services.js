import { Request } from "./request";


const listOfValue = async ({
    url,
    data = {},
    titleKey,
    valueKey,
}) => {
    const urlSplit = url.split('/');
    const moduleName = `${urlSplit[urlSplit.length - 1] || 'this module'}`.split('-').join(' ').trim();
    const errorMessage = `Failed when fetching ${moduleName} options`;
    let success = false;
    let result = [];

    await Request.get({
        url,
        data,
        errorMessage,
        useLoading: true,
    })
        .then(({ data }) => {
            success = true;
            const items = data.data || data || [];
            result = generateListOfValue({
                items, valueKey, titleKey,
            });
        })
        .catch((error) => {});

    return new Promise((resolve) => {
        resolve(result);
    });
}

const generateListOfValue = ({
    items,
    valueKey,
    titleKey = '',
}) => {
    const _title = titleKey || valueKey;

    try {
        const _test = !items[0][valueKey];
    } catch (error) {
        return [];
    }

    return items.map(item => {
        return { title: item[_title], value: item[valueKey], data: item };
    });
}


export const fetchServices = {
    listOfValue,
    generateListOfValue,
};
