import Axios from 'axios';

export default {
    get dependencies() {
        return Axios.get('getDependencies');
    },

    get categories() {
        return Axios.get('getCategories');
    },

    getArticlesPageByShopCategory(shop, category, lastArticle) {
        let config = {
            params: {
                shop: shop,
                category: category
            }
        };

        if (lastArticle) {
            config.params.last_article = lastArticle;
        }

        return Axios.get('getArticlesByShopCategory', config);
    },

    getArticlesByShopCategory(shop, category, operation) {
        let fetch = lastArticle => {
            return this.getArticlesPageByShopCategory(shop, category, lastArticle)
                .then(p => {
                    operation(p.data);
                    return p.data.data && p.data.data.length ? fetch(p.data.data.slice(-1)[0].id) : p;
                });
        };

        return fetch(null);
    }
}