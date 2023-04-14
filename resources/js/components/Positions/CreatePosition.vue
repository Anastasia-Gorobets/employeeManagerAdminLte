<template>
    <div>
        <h1>Create position</h1>
        <form @submit.prevent="savePosition" method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input v-model="form.name"  type="text" class="form-control" id="name" name="name">
            </div>
            <div>
                <input  class="btn btn-primary btn-block" type="submit" value="Create">
            </div>
        </form>
        <errors :errors="errors"></errors>
    </div>
</template>
<script>

export default {
    name: "CreatePosition",
    data(){
        return {

        }
    },
    computed:{
        form(){
            return  this.$store.getters['employees/form'];
        },

        errors(){
            return  this.$store.getters['errors/errors'];
        },

        hasErrors(){
            return  this.$store.getters['errors/hasErrors'];
        }
    },
    methods:{
        async savePosition(){
            await this.$store.dispatch('positions/savePosition',this.form);
            if(!this.hasErrors){
                this.$router.push('/positions');
            }
        },
    }
}
</script>

<style scoped>

</style>
