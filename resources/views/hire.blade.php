@extends('layout')
@section('content')
@extends('components.header')

<div class="form-group col-12">
    <form class="col-6 container" method="POST" action="{{ route('hire.store') }}" enctype="multipart/form-data">
        @csrf
        <h4>Hire Available Developers</h4>
        Start Date: <input type="date" name="start_date" value="{{ old('start_date') }}"/>
        End Date: <input type="date" name="end_date" value="{{ old('end_date') }}"/>
        <div class="row">
            <!--Show all existing developers from db in a select field-->
            <select name="names[]" class="form-control" multiple="multiple"
                    aria-label="multiple select example">
                @foreach ($hire_devs as $row)
                    <option value="{{ $row->name }}">{{ $row->name }}</option>
                @endforeach
{{--                @extends('components.hired_dev')--}}
{{--            </select>--}}
            <input class="form-group col-12" type="submit" name="submit" value="Submit">
        </div>
    </form>
</div>

<br>
<table class='table center col-10 mt-5 mb-5'>
    <thead>
    <tr>
        <th scope='col'>Names</th>
        <th scope='col'>Profile Picture</th>
        <th scope='col'>Start Date</th>
        <th scope='col'>End Date</th>
        <th scope='col'>Delete</th>
    </tr>
    </thead>
    @foreach($hired as $hired_devs)
    <tbody>
    <tr>
        <td> {{ e($hired_devs->names) }} </td>
        <td> <img src="{{ url('storage/developer/'.$hired_devs->profile_picture) }}"
                  style="height: 100px; width: 150px;"></td>
        <td> {{ $hired_devs->start_date }} </td>
        <td> {{ $hired_devs->end_date }} </td>
        <td> <form action="{{ route('hire.destroy', $hired_devs->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">Delete</button>
            </form> </td>
    </tr>
    </tbody>
    @endforeach

</table>

@endsection
