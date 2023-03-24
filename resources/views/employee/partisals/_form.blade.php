@if ($employee ?? false && $employee->image)
    @if ($employee->image && $employee->image->path)
        <img class="employeeImage" src="{{ Storage::url($employee->image->path) }}">
    @endif
@endif



<div class="form-group">
    <label for="image">Photo</label>
    <input type="file" class="form-control" id="image" name="image" value="">
</div>


<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name',  optional($employee ?? null)->name) }}">
</div>

<div class="form-group">
    <label for="phone">Phone</label>
    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone',  optional($employee ?? null)->phone) }}">
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email',  optional($employee ?? null)->email) }}">
</div>

<div class="form-group">
    <label for="salary">Salary $</label>
    <input type="text" class="form-control" id="salary" name="salary" value="{{ old('salary',  optional($employee ?? null)->salary) }}">
</div>

<div class="form-group">
    <label for="position">Position</label>
    <select id="position" name="position" class="form-select">
        @foreach($positions as $position)
            <option @if(old('position',  optional($employee ?? null)->position ? $employee->position->id : '') == $position->id) selected @endif   value="{{$position->id}}">{{$position->name}}</option>

        @endforeach

    </select>
</div>


<div class="form-group">
    <label for="boss">Head</label>
    <input autocomplete="off" type="text" class="form-control" id="boss" name="boss" value="{{ old('boss',  optional($employee ?? null)->boss ? $employee->boss->name : '') }}">
    <input type="hidden" class="form-control" id="boss_id" name="boss_id" value="{{ old('boss_id',  optional($employee ?? null)->boss ? $employee->boss->id : '') }}">
</div>


<div class="form-group">
    <label for="date_start_work">Date of employment</label>
    <input type="text" class="form-control" id="date_start_work" name="date_start_work" value="{{ old('date_start_work', Carbon\Carbon::createFromDate(optional($employee ?? null)->date_start_work)->format('d.m.y')) }}">
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

