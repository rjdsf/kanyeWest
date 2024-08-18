<script setup>
import Layout from "../Shares/Layout.vue";
</script>

<script>
import {router, useForm} from '@inertiajs/vue3'

export default {

    props: {
        'author': String,
        'quotes': Array
    },
    methods: {
        refresh() {
            router.get('/', {}, {headers: {'cache-control': 'no-cache'}})
        },

    }
}


</script>

<template>
    <Layout>
        <div class=" flex justify-center flex-col  ">
            <div class=" text-right ">
                <h2> Author: {{ author }}</h2>
            </div>
            <div class=" flex justify-center flex-col ">
                <div class="mt-2 pl-3 pr-3 pt-3 pb-3 mb-2 bg-blue-200  shadow-lg shadow-blue-500/500 rounded-lg"
                     v-for="quote of quotes">
                    {{ quote }}
                </div>
            </div>
            <div class="mt-3 flex justify-end">
                <button
                    class=" min-w-56 rounded-lg p-3 bg-blue-200 shadow-lg shadow-blue-500/50 left-0  hover:bg-blue-300 focus:bg-blue-400"
                    @click="refresh">Refresh
                </button>
            </div>
        </div>
    </Layout>
</template>
