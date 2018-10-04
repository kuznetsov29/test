import createPersistedState from 'vuex-persistedstate';
import * as Cookie from 'js-cookie';

export default ({store}) => {
    createPersistedState({
        key: 'vuex',
        paths: [],
        storage: {
            getItem: key => Cookie.get(key),
            setItem: (key, value) => Cookie.set(key, value, { expires: 3, secure: false }),
            removeItem: key => Cookie.remove(key)
        }
    })(store)
}