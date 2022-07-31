{{--@foreach ($hire_devs as $row)--}}
{{--    <option value="{{ $row->name }}">{{ $row->name }}</option>--}}
{{--@endforeach--}}


    <select name="names[]" class="form-control" multiple="multiple"
            aria-label="multiple select example">
        @foreach ($hire_devs as $row)
            <option value="{{ $row->name }}">{{ $row->name }}</option>
        @endforeach
        {{--                @extends('hired_dev')--}}
    </select>
