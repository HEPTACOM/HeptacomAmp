import Axios from 'axios';

export default {
    get dependencies() {
        return Axios.get('getDependencies');
    }
}