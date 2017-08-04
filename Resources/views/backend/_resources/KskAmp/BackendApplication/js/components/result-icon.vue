<template>
    <i v-if="success" class="fa fa-check-circle uk-text-success"></i>
    <i v-else="" class="fa fa-exclamation-triangle uk-text-danger"></i>
</template>

<script type="application/javascript">
    export default {
        props: {
            success: Boolean
        }
    }
</script>