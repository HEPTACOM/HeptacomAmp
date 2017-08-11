import Axios from 'axios';

export default {
    get dependencies() {
        return Axios.get('getDependencies');
    },

    get categories() {
        let pullArticlesForCategory = (category) => {
            category.articles = [];
            this.getArticlesByShopCategory(1, category.id, p => category.articles.push(...p.data));

            if (category.categories && category.categories.length) {
                for (let subCategory of category.categories) {
                    pullArticlesForCategory(subCategory);
                }
            }
        };

        let pullArticles = (request) => {
            for (let category of request.data.data) {
                pullArticlesForCategory(category);
            }

            return Promise.resolve(request);
        };

        return Axios.get('getCategories')
            .then(pullArticles);
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
    },

    getArticlesPage(lastArticle) {
        return Axios.get('getArticles', {
            params: {
                last_article: lastArticle
            }
        })
    },

    getArticles(operation) {
        let fetch = lastArticle => this.getArticlesPage(lastArticle).then(p => {
            operation(p);
            return p.data.success && p.data.data && p.data.data.length ? fetch(p.data.data.slice(-1)[0].id) : p;
        });

        return fetch(null);
    }
}