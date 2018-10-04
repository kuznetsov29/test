<template>
    <div class="bg-grey-lighter border m-5 w-5/6 max-w-lg ml-auto mr-auto mt-8 mb-8">
        <h1 class="text-grey-darker text-center bg-grey-light px-4 py-2 m-2">
            {{post.title}}
        </h1>
        <div class="bg-white font-bold px-8 py-2 m-2">
            {{post.description}}
        </div>
        <img v-show="image" v-bind:src="image"/>
        <div v-html="post.content" class="bg-white px-8 py-2 m-2">
        </div>
    </div>
</template>
<script>
    import {HTTP} from "../../plugins/http-common";

    export default {
        async asyncData({params}) {
            const response = await HTTP.get(
                'v1/post/' + params.id + '?fields=id,title,description,content&expand=image'
            );

            return {
                post: response.data
            }
        },
        computed: {
            image: function () {
                if (this.post.image === null) {
                    return '';
                }

                return (process.env.BASE_URL || 'http://api.test.ru/') + this.post.image.url;
            }
        }
    }
</script>