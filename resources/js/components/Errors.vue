<template>
    <ul class="list-group">
        <li class="list-group"  v-for="error in errors">
            <ul class="list-group">
                <li class="list-group-item list-group-item-danger mb-2 mt-2" :key="errorItem" v-for="errorItem in error">{{errorItem}}</li>
            </ul>
        </li>
    </ul>
</template>

<script>
export default {
    name: "Errors",
    props: ['errors']
}
</script>

<style scoped>

</style>
