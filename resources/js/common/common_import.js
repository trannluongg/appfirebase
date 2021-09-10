

var Storage = {
    getStorage(name) {
        return JSON.parse(localStorage.getItem(name)) || [];
    },
    setStorage(name, data = []) {
        localStorage.setItem(name, JSON.stringify(data));
    },
    delStorage(name) {
        localStorage.removeItem(name);
    }
};

export  {
    Storage,
}