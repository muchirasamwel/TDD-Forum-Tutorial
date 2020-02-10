<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"/>
            <br>
        </div>
        <paginator :dataSet="dataSet"  @pageChanged="fetchReplies"/>

        <new-reply @created="add"/>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';
    import collection from "../mixins/collection";

    export default {
        components: {Reply, NewReply},
        mixins:[collection],
        data() {
            return {
                dataSet:false,
            }
        },
        created() {
            this.fetchReplies();
        },
        methods: {
            fetchReplies(page) {
                if(!page)
                {
                    let query=location.search.match(/page=(\d+)/);
                    page=query ? query[1] : 1;
                }
                axios.get(this.url(page))
                    .then(this.refresh);
            },
            url(page) {
                return `${location.pathname}/replies?page=${page}`;
            },
            refresh({data}) {
                this.dataSet=data;
                this.items=data.data;
            },
        }
    }
</script>
