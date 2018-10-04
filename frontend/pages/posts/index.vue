<template>
    <div>
        <section class="bg-white py-8">
            <div class="w-5/6 max-w-lg ml-auto mr-auto mt-8 mb-8">
                <div class="flex flex-col md:flex-row items-center justify-center">
                    <p class="text-xl leading-normal mr-6 mb-3 md:mb-0 text-center md:text-left">PHP part</p>
                </div>
            </div>
        </section>
        <div class="flex justify-center">
            <div class="bg-grey-light h-1 w-16 rounded"></div>
        </div>

        <div class="w-5/6 max-w-lg ml-auto mr-auto mt-8 mb-8">
            <Post v-for="(post, index) in posts" v-bind:key="index" :post="post"></Post>
        </div>
    </div>
</template>

<script>
    import {HTTP} from "../../plugins/http-common";
    import Post from "../../components/post";

    export default {
        components: {Post},
        async asyncData({store}) {
            const response = await HTTP.get('v1/post?fields=id,title,description,short_content');

            return {
                posts: response.data
            }
        },
        async fetch({store, params}) {

        },
    }
</script>