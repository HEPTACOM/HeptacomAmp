<template>
    <div class="uk-flex uk-flex-center uk-flex-stretch uk-flex-row">
        <div class="uk-flex-first">
            <slot name="left"></slot>
        </div>
        <div class="uk-flex-1">
            <slot></slot>
        </div>
        <div class="uk-flex-last">
            <slot name="right"></slot>
        </div>
    </div>
</template>
