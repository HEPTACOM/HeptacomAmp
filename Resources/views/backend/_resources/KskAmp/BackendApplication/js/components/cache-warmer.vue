<template>
    <div class="uk-card uk-card-default">
        <div class="uk-card-badge uk-badge">
            {{items.length}}<f-a icon="spinner" class="fa-pulse uk-margin-small-left" v-if="loading"></f-a>
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
            <button class="uk-button uk-button-primary" v-bind:disabled="loading">Start</button>
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
        }
    }
</script>