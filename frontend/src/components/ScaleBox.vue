<template>
    <div class="scale-box">
        <button class="zoom" v-bind:style="zoomInCursor" v-bind:disabled="zoomInDisable" v-on:click="zoomIn()">
            <i class="fa fa-search-plus fa-lg" v-bind:style="zoomInCursor" aria-hidden="true"></i>
        </button>
        <button class="zoom" v-bind:style="zoomOutCursor" v-bind:disabled="zoomOutDisable" v-on:click="zoomOut()">
            <i class="fa fa-search-minus fa-lg" v-bind:style="zoomOutCursor" aria-hidden="true" ></i>
        </button>
        <button class="zoom" v-on:click="expandSchema()">
            <i class="fa fa-expand fa-lg" aria-hidden="true"></i>
        </button>
        <button class="zoom" v-on:click="constrictSchema()">
            <i class="fa fa-compress fa-lg" aria-hidden="true"></i>
        </button>
        <div class="separator"></div>
        <button class="zoom" v-on:click="fullscreen()">
            <i class="fa fa-arrows-alt fa-lg" aria-hidden="true"></i>
        </button>
        <div class="separator"></div>
        <button class="zoom" v-on:click="resetSchema()">
            <i class="fa fa-undo fa-lg" aria-hidden="true"></i>
        </button>
        <div class="separator"></div>
    </div>
</template>

<script>
    export default {
        name: 'scale-box',
        data: function() {
            return {
                countZoomIn: 0,
                countZoomOut: 0,
                maxCount: 5,
                deltaWidth: 0,
                deltaHeight: 0,
                fullScreenFlag: false,
            };
        },
        mounted() {
            this.countZoomIn = this.maxCount;
            this.countZoomOut = this.maxCount;
        },
        computed : {
            zoomInDisable: function () {
                return this.$root.schema.width === this.$root.initSchema.width &&
                    this.$root.schema.height === this.$root.initSchema.height;
            },
            zoomInCursor: function () {
                if (this.$root.schema.width === this.$root.initSchema.width &&
                    this.$root.schema.height === this.$root.initSchema.height
                ) {
                    return {cursor: 'not-allowed'};
                }
                else {
                    return  {cursor: 'pointer'};
                }
            },
            zoomOutDisable: function () {
                return this.$root.schema.width === this.$root.window.width &&
                    this.$root.schema.height === this.$root.window.height;
            },
            zoomOutCursor: function () {
                if (this.$root.schema.width === this.$root.window.width &&
                    this.$root.schema.height === this.$root.window.height
                ) {
                    return {cursor: 'not-allowed'};
                }
                else {
                    return {cursor: 'pointer'};
                }
            }
        },
        methods: {
            zoomIn: function() {
                this.deltaWidth = (this.$root.initSchema.width - this.$root.schema.width)/this.countZoomIn;
                this.deltaHeight = (this.$root.initSchema.height - this.$root.schema.height)/this.countZoomIn;
                this.$root.schema.width = this.$root.schema.width + this.deltaWidth;
                this.$root.schema.height = this.$root.schema.height + this.deltaHeight;

                if (this.countZoomIn !== 1) {
                    this.countZoomIn--;
                }

                if (this.countZoomOut < this.maxCount) {
                    this.countZoomOut++;
                }
            },
            zoomOut: function() {
                this.deltaWidth = (this.$root.schema.width - this.$root.window.width)/this.countZoomOut;
                this.deltaHeight = (this.$root.schema.height - this.$root.window.height)/this.countZoomOut;
                this.$root.schema.width = this.$root.schema.width - this.deltaWidth;
                this.$root.schema.height = this.$root.schema.height - this.deltaHeight;

                if (this.countZoomOut !== 1) {
                    this.countZoomOut--;
                }

                if (this.countZoomIn < this.maxCount) {
                    this.countZoomIn++;
                }
            },
            expandSchema: function() {
                this.$root.schema.width = this.$root.initSchema.width;
                this.$root.schema.height = this.$root.initSchema.height;
            },
            constrictSchema: function() {
                this.$root.schema.width = this.$root.window.width;
                this.$root.schema.height = this.$root.window.height;
            },
            fullscreen: function () {
                if (!this.fullScreenFlag) {
                    if (screenfull.isEnabled) {
                        screenfull.request();
                        this.fullScreenFlag = true;
                    } else {
                        Swal.fire('full screen is unavailable')
                    }
                }
                else {
                    screenfull.exit();
                    this.fullScreenFlag = false;
                }
            },
            resetSchema: function () {
                this.$root.schema.width = this.$root.window.width;
                this.$root.schema.height = this.$root.window.height;
                this.$root.setViewbox(
                    this.$root.initSchema.vbX,
                    this.$root.initSchema.vbY,
                    this.$root.initSchema.vbWidth,
                    this.$root.initSchema.vbHeight,
                )
            },
        },
    };
</script>

<style>
    .scale-box {
        display: flex;
        flex-direction: row;
        justify-content: space-between;

        width: 400px;
        height: 32px;
        position: fixed;  z-index: 2000;
        margin: 10px 0 0 150px;
    }
    .zoom {
        flex-shrink: 1;
        flex-grow:1;
    }
    .separator {
        width: 5px;
    }
    .zoom:hover {
        box-shadow: 1px 1px 10px #607d8b;
    }
</style>