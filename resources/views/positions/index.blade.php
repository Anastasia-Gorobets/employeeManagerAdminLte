@extends('layouts.admin_layout')

@section('content')

    <div class="row mb-2">
        <div class="col-12">
            <a href="{{route('position.create')}}" class="btn btn-primary">Add item</a>
        </div>
    </div>


    <table class="table table-bordered yajra-datatable">
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
                initComplete: function () {
                     // Add the form-control class to the search input
                     $('.dataTables_filter input[type="search"]').addClass('form-control d-inline-block w-auto');
                     $('.dataTables_length select').addClass('form-select d-inline-block w-auto');
                },
                ajax: "{{ route('position.list') }}",
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'updated_at', name: 'updated_at'},
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
