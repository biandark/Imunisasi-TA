<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-white border border-indigo-100 rounded-md font-semibold text-xs text-indigo-300 uppercase tracking-widest shadow-sm hover:text-indigo-300 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-indigo-500 active:bg-indigo-50 transition ease-in-out duration-150">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'button',
            },
        }
    }
</script>
