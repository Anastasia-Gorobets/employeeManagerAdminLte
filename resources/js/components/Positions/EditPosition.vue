<template>
    <div>
        <h1>Edit position</h1>
        <form @submit.prevent="updatePosition" method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input v-model="form.name"  type="text" class="form-control" id="name" name="name">
            </div>
            <div>
                <input  class="btn btn-primary btn-block" type="submit" value="Update">
            </div>
        </form>
        <errors :errors="errors"></errors>
    </div>
</template>
<script>

export default {
    name: "EditPosition",
    data(){
        return {
        }
    },

    mounted() {
        this.$store.dispatch('positions/setId',this.$route.params.id);
        this.$store.dispatch('positions/getPosition');
    },

    computed:{
        form(){
            return  this.$store.getters['positions/form'];
        },
        errors(){
            return  this.$store.getters['errors/errors'];
        },
        hasErrors(){
            return  this.$store.getters['errors/hasErrors'];
        }
    },

    methods:{
        async updatePosition(){
            await this.$store.dispatch('positions/updatePosition',this.form);
            if(!this.hasErrors){
                this.$router.push('/positions');
            }
        },
    }
}
</script>
