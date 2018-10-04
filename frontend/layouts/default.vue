<template>
    <div class="font-sans text-black h-full">
        <section class="bg-blue-lightest h-full py-8">
            <div class="w-5/6 max-w-lg ml-auto mr-auto h-full">
                <div class="flex items-center justify-center text-center h-full">
                    <div>
                        <h1 class="text-4xl sm:text-5xl font-semibold leading-none tracking-tight mb-4">
                            Тестовое задание на VUE.js
                        </h1>

                        <div class="flex flex-col sm:flex-row justify-center pt-8">

                            <nuxt-link to="/parser"
                                       class="self-end flex-1 text-center px-4 py-2 px-8 bg-blue hover:bg-blue-dark text-2xl leading-none text-white font-semibold h-12 px-8
                           rounded-full whitespace-no-wrap mb-2 sm:mb-0 sm:mr-2">
                                PHP part
                            </nuxt-link>
                            <nuxt-link to="/goods"
                                       class="self-end flex-1 text-center px-4 py-2 px-8 border border-blue-lighter hover:border-blue-light rounded-full
                           whitespace-no-wrap mt-2 sm:mt-0 sm:ml-2 bg-transparent text-2xl leading-none text-blue font-semibold
                           hover:text-blue-dark h-12">
                                JS part
                            </nuxt-link>


                        </div>
                    </div>
                </div>
            </div>
        </section>
        <nuxt/>
        <section class="bg-grey-lightest py-8">
            <div class="w-5/6 max-w-ldiv>
 uto mr-auto mt-8 mb-8">
            </div>
        </section>
    </div>
</template>
