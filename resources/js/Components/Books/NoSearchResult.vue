<template>
    <div id="no-search-result">
        <jet-action-message :on="true">
            Nothing found for this search term: {{ search }}
        </jet-action-message>
    </div>
</template>

<script>
import JetActionMessage from '@/Jetstream/ActionMessage'
export default {
    name: 'NoSearchResult',
    components: { JetActionMessage },
    props: ['search'],
}
</script>

<style lang="less" scoped>
#no-search-result {
    margin-bottom: 25px;
    padding: 15px 1.25rem;
}
</style>