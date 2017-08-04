<template>
    <div v-if="data && data.length">
        <ul class="uk-nav-sub">
            <li v-for="child in data">
                <a v-on:click="clickItem(child)">{{child[nameProperty]}}</a>
                <sub-tree v-bind:data="child[childrenProperty]" v-bind:childrenProperty="childrenProperty" v-bind:nameProperty="nameProperty" v-on:click-item="clickItem"></sub-tree>
            </li>
        </ul>
    </div>
</template>

<script type="application/javascript">
    export default {
        name: 'sub-tree',
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