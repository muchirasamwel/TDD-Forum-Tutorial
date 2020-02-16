<template>
    <div class="alert alert-flash"
         :class="'alert-'+level"
         role="alert"
         v-show="show"
         v-text="body">
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                body: '',
                show: false,
                level:'success'
            }
        },
        created() {
            if (this.message) {
                this.flash(this.message);
            }
            window.events.$on(
                'flash', message => this.flash(message)
            );
        },
        methods: {
            flash(data) {
                this.body = data.message;
                this.level = data.level;
                this.show = true;
                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 4000);
            }
        }
    };
</script>

<style>
    .alert-flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>
