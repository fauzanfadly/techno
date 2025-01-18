type Collection<T> = {
    where: (key: keyof T, value: any) => Collection<T>;
    find: (key: keyof T, value: any) => T | undefined;
    get: () => T[];
    first: () => T | undefined;
    value: T[];
};

export const collect = <T>(items: T[] = []): Collection<T> => {
    const tempItems: T[] = [ ...items ];

    const filter = (key: keyof T, value: any): T[] => tempItems.filter(item => item[key] === value);
    const where = (key: keyof T, value: any): Collection<T> => collect(filter(key, value));
    const find = (key: keyof T, value: any): T | undefined => tempItems.find(item => item[key] === value);
    const get = (): T[] => tempItems;
    const first = (): T | undefined => tempItems[0];
    const value = tempItems;

    return {
        where,
        find,
        get,
        first,
        value,
    };
};