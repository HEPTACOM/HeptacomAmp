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
            <p class="uk-text-meta uk-margin-remove-top">
                <progress class="uk-progress uk-text-success" value="0" v-bind:max="items.length"></progress>
            </p>
        </div>
        <div class="uk-card-footer uk-text-center">
            <button class="uk-button uk-button-primary" v-bind:disabled="loading || processing" v-on:click="startProcessing">
                Start
            </button>
        </div>
    </div>
</template>

<script type="application/javascript">
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
            selectedIndex: 0,
        }),
        methods: {
            startProcessing() {
                this.processing = true;
                this.processed = [];
                this.selectedIndex = 0;
            }
        }
    }
</script>
