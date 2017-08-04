<template>
    <div>
        <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
            <li v-for="child in data">
                <span v-on:click="clickItem(child)">{{child[nameProperty]}}</span>
                <sub-tree v-bind:data="child[childrenProperty]" v-bind:childrenProperty="childrenProperty" v-bind:nameProperty="nameProperty" v-on:click-item="clickItem"></sub-tree>
            </li>
        </ul>
    </div>
</template>

<script type="application/javascript">
    import SubTree from './subtree.vue'

    export default {
        components: {
            SubTree
        },
        props: {
            data: Array,
            childrenProperty: String,
            nameProperty: String
        },
        methods: {
            clickItem(item) {
                this.$emit('click-item', item);
            }
        }
    }
</script>