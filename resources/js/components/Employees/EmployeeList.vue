<template>
<div>
    <h1>Employees</h1>
    <div class="row mb-2">
        <div class="col-12">
            <router-link class="btn btn-primary" to="/create-employee">Add item</router-link>
        </div>
    </div>
    <table id="employeesTable" class="table table-bordered yajra-datatable" ref="employeeTable">
        <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Position</th>
            <th>Date of employment</th>
            <th>Salary</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody ref="employeeTableTbody">
        </tbody>
    </table>
</div>
</template>

<script>
export default {
    name: "EmployeeList",
    data(){
        return {
            employees : []
        }
    },
    mounted() {
        this.getEmployees();
    },

    methods:{
        async getEmployees(){
            await this.$store.dispatch('employees/getEmployees');

            const editLinks = document.querySelectorAll('.editEmployeeLink');
            editLinks.forEach(link => {
                link.addEventListener('click', this.handleEditClick);
            });

            const deleteLinks = document.querySelectorAll('.deleteEmployeeForm');
            deleteLinks.forEach(link => {
                link.addEventListener('click', this.handleDeleteClick);
            });
        },

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
           }).then(async (result) => {
               if (result.isConfirmed) {
                   const id = event.target.getAttribute('data-id');
                   await this.$store.dispatch('employees/deleteEmployee',id);
                   this.getEmployees();
               }
           });
        },




    }
}
</script>
<style scoped>
</style>
