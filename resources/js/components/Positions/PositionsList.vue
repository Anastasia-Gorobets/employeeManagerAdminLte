<template>
    <div>
        <h1>Positions</h1>

        <div class="row mb-2">
            <div class="col-12">
                <router-link class="btn btn-primary" to="/create-position">Add item</router-link>
            </div>
        </div>
        <table id="positionsTable" class="table table-bordered yajra-datatable" ref="positionsTable">
            <thead>
            <tr>
                <th>Name</th>
                <th>Last updated</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "PositionsList",
    data(){
        return {
        }
    },

    mounted() {
        this.getPositions();
    },

    methods:{
        handleEditClick(event){
            event.preventDefault();
            this.$router.push(event.target.pathname);
        },

        handleDeleteClick(event){
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(async(result) => {
                if (result.isConfirmed) {
                    const id = event.target.getAttribute('data-id');
                    await this.$store.dispatch('positions/deletePosition',id);
                    this.getPositions();
                }
            });
        },

       async getPositions(){
           await this.$store.dispatch('positions/getPositionsList');

           const editLinks = document.querySelectorAll('.editPositionLink');
           editLinks.forEach(link => {
               link.addEventListener('click', this.handleEditClick);
           });

           const deleteLinks = document.querySelectorAll('.deletePositionForm');
           deleteLinks.forEach(link => {
               link.addEventListener('click', this.handleDeleteClick);
           });
        }
    }
}
</script>

<style scoped>

</style>
