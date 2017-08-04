<template>
    <i v-bind:class="classes"></i>
</template>

<script>
    export default {
        props: {
            icon: String,
            block: {
                type: Boolean,
                required: false,
                'default': false
            }
        },
        computed: {
            classes() {
                let result = {
                    'fa': true,
                    'fa-fw': this.block
                };

                result['fa-' + this.icon] = true;
                return result;
            }
        }
    }
</script>