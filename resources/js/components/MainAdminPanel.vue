<template>
    <navigation></navigation>
    <div class="content-wrapper" style="min-height: 384.4px;">
        <div class="content">
            <div class="container-fluid routerView">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import Navigation from "./Navigation";
export default {
    name: "MainAdminPanel",
    components:{
        Navigation
    }
}
</script>

<style scoped>

</style>
