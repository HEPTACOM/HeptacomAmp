import Axios from 'axios';

export default {
    get dependencies() {
        return Axios.get('getDependencies');
    },

    get categories() {
        return Axios.get('getCategories');
    }
}