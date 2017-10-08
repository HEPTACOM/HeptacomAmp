<template>
    <div class="uk-card uk-card-default">
        <div class="uk-card-badge uk-badge">
            <span v-if="processing">{{selectedIndex}}&nbsp;/&nbsp;</span>
            {{items.length}}
            <f-a icon="spinner" class="fa-pulse uk-margin-small-left" v-if="loading || processing"></f-a>
        </div>
        <div class="uk-card-header">
            <h3 class="uk-card-title">
                {{header}}
            </h3>
        </div>
        <div class="uk-card-body">
            <p>
                <progress class="uk-progress uk-text-success" v-bind:value="processed.length + errors.length" v-bind:max="items.length"></progress>
            </p>
            <div v-if="errors.length" class="uk-margin-medium-top">
                <h3>
                    Fehler <span class="uk-label">{{errors.length}}</span>
                </h3>
                <ul class="uk-overflow-auto uk-height-medium" uk-accordion="">
                    <li v-for="error in errors">
                        <span class="uk-accordion-title">{{error.item.name}}</span>
                        <div class="uk-accordion-content">
                            <ul class="uk-iconnav">
                                <li class="uk-text-danger" v-on:click="showError(error)"><f-a icon="exclamation-circle" v-bind:block="true"></f-a></li>
                                <template v-for="link in error.item.urls">
                                    <li><a v-bind:href="link.ampUrl" target="_blank"><f-a icon="bolt" v-bind:block="true"></f-a></a></li>
                                    <li><a v-bind:href="link.canonicalUrl" target="_blank"><f-a icon="desktop" v-bind:block="true"></f-a></a></li>
                                </template>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="uk-card-footer uk-text-center">
            <button class="uk-button uk-button-primary" v-bind:disabled="loading || processing" v-on:click="startProcessing">
                Start
            </button>
        </div>
    </div>
</template>

<script type="application/javascript">
    import UIkit from 'uikit';
    import KskAmpBackend from '../lib/KskAmpBackend';
    import FA from './font-awesome.vue';

    export default {
        components: {
            FA,
        },
        props: {
            items: Array,
            header: String,
            loading: Boolean,
        },
        data: () => ({
            processing: false,
            processed: [],
            errors: [],
            selectedIndex: 0,
        }),
        methods: {
            startProcessing() {
                this.processing = true;
                this.processed = [];
                this.errors = [];
                this.selectedIndex = 0;
                this.fetch();
            },
            fetch() {
                if (this.selectedIndex < this.items.length) {
                    KskAmpBackend.callHeadUrls(this.items[this.selectedIndex].urls.map(p => p.ampUrl))
                        .then(
                            this.processed.push(this.items[this.selectedIndex]),
                            p => {
                                this.errors.push({
                                    item: this.items[this.selectedIndex],
                                    exception: p
                                });
                            }
                        ).then(() => {
                            this.selectedIndex++;
                            return this.fetch();
                        });
                } else {
                    this.processing = false;
                }
            },
            showError(item) {
                UIkit.modal.alert(JSON.stringify({
                    config: item.exception.config,
                    headers: item.exception.headers,
                    method: item.exception.method,
                    url: item.exception.url,
                    data: item.exception.data,
                    response: item.exception.response
                }));
            }
        }
    }
</script>
