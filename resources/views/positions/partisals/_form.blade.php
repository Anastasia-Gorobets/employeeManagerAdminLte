<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name',  optional($position ?? null)->name) }}">
</div>



@include('layouts.partials.errors')

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <script>
        var path = "{{ route('autocomplete.employees') }}";

        $('#boss').typeahead({
            updater: function(item) {
                $('#boss_id').val(item.id);
                return item;
            },
            source: function (query, process) {
                return $.get(path, {
                    query: query
                }, function (data) {
                    console.log(data);
                    return process(data);
                });
            }
        });

        $( "#date_start_work" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat:'dd.mm.y'
        });


    </script>
@endsection

