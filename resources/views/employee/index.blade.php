@extends('layouts.admin_layout')

@section('content')

    <a href="{{route('employee.create')}}" class="btn btn-primary">Add item</a>


    <table class="table table-bordered yajra-datatable">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Position</th>
            <th>Date of employment</th>
            <th>Salary</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>



@endsection

@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <script>

        function confirmDelete(e){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.submit(); // submit the form
                }
            });
            return false; // prevent the form from submitting before confirmation
        }



        $(function () {
             $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employee.list') }}",
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'position', name: 'position'},
                    {data: 'date_start_work', name: 'date_start_work'},
                    {data: 'salary', name: 'salary'},
                    {
                        data: 'action',
                        name: 'action',
                    },
                ]
            });





           /*  $(document).on('submit','.deleteEmployeeForm', function (e){
                 e.preventDefault();
                 let form = $(this);

                 Swal.fire({
                     title: 'Are you sure?',
                     text: "You won't be able to revert this!",
                     icon: 'warning',
                     showCancelButton: true,
                     confirmButtonColor: '#3085d6',
                     cancelButtonColor: '#d33',
                     confirmButtonText: 'Yes, delete it!'
                 }).then((result) => {
                     if (result.isConfirmed) {
                         form.submit();
                     }
                 });

                 return false;
             });*/




        });
    </script>
@endsection
