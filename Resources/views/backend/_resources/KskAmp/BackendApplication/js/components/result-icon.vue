<template>
    <f-a v-if="success" icon="check-circle" v-bind:block="true" class="uk-text-success"></f-a>
    <f-a v-else="" icon="exclamation-triangle" v-bind:block="true" class="uk-text-danger"></f-a>
</template>

<script type="application/javascript">
    import FA from './font-awesome.vue';

    export default {
        components: {
            FA
        },
        props: {
            success: Boolean
        }
    }
</script>