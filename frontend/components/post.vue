<template>
    <div class="bg-grey-lighter border m-5">
        <div class="flex flex-row">
            <div class="flex-1 bg-white px-8 py-2 m-2">
                <span class="text-red-lighter">
                    Заголовок
                </span>
                {{post.title}}
            </div>
        </div>
        <div class="flex flex-row">
            <div class="flex-2 text-grey-darker text-center bg-grey-light px-4 py-2 m-2 mt-0">
                  <span class="text-red-lighter">
                    Описание
                </span>
                {{post.description}}
            </div>
            <div class="flex-2 text-grey-darker text-center bg-grey-light px-4 py-2 m-2 mt-0">
                  <span class="text-red-lighter">
                    Подрезанная новость
                </span>
                {{post.short_content}}
            </div>
            <div class="flex-2 text-grey-darker text-center bg-grey-light px-4 py-2 m-2 mt-0">
                <nuxt-link v-bind:to="'/posts/' + post.id" class="text-grey-darker">Подробнее</nuxt-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            post: {
                type: Object
            }
        }
    }
</script>