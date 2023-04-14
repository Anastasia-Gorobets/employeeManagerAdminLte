<template>
    <div>
        <h1>Edit employee</h1>

        <img :src="currentImage" class="employeeImage">

        <form @submit.prevent="updateEmployee" method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Photo</label>
                <input  ref="fileInput" @change="setImage" type="file" class="form-control" id="image" name="image" value="">
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input v-model="form.name"  type="text" class="form-control" id="name" name="name">
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input v-model="form.phone"  type="text" class="form-control" id="phone" name="phone">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input v-model="form.email" type="email" class="form-control" id="email" name="email">
            </div>

            <div class="form-group">
                <label for="salary">Salary $</label>
                <input v-model="form.salary" type="text" class="form-control" id="salary" name="salary">
            </div>

            <div class="form-group">
                <label for="position">Position</label>
                <select v-model="form.position" id="position" name="position" class="form-select">
                    <option :key="position.id" :value="position.id" v-for="position in positions">{{position.name}}</option>
                </select>
            </div>


            <div class="form-group">
                <label for="boss">Head</label>
                <input ref="boss" v-model="form.boss" autocomplete="off" type="text" class="form-control" id="boss" name="boss">
            </div>

            <div class="form-group">
                <label>Date of employment</label>
                <vue3-datepicker :typeable="true" inputFormat="dd.MM.yy"  class="form-control"  v-model="form.date_start_work" />
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
    name: "EditEmployee",
    data(){
        return {

        }

    },

    mounted(){

        this.$store.dispatch('positions/getPositions')
        this.$store.dispatch('employees/setId',this.$route.params.id);
        this.$store.dispatch('employees/getEmployee');

        this.$store.dispatch('employees/autocomplete', $(this.$refs.boss));

    },

    methods:{
        setImage(event){
            this.$store.dispatch('employees/setImage',event);
        },

        async updateEmployee(){
            await this.$store.dispatch('employees/updateEmployee',this.form);
            if(!this.hasErrors){
                this.$router.push('/employee-list');
            }
        }
    },

    computed:{
        positions(){
            return  this.$store.getters['positions/positions'];
        },
        form(){
            return  this.$store.getters['employees/form'];
        },

        currentImage(){
            return  this.$store.getters['employees/currentImage'];
        },

        errors(){
            return  this.$store.getters['errors/errors'];
        },
    },


}
</script>

<style scoped>

</style>
