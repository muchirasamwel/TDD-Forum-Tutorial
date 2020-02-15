<template>
    <div :class="type" role="alert" v-show="show">
        <strong>Action Successful !!</strong> {{ body }}
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                body: '',
                show: false,
                type:'success'
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
            flash(message) {
                if (message.toLowerCase().indexOf('error') >= 0)
                    this.type = 'flash-error';
                else if (message.toLowerCase().indexOf('success') >= 0)
                    this.type = 'flash-success';
                else
                    this.type = 'flash-neutral';
                this.body = message;
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
