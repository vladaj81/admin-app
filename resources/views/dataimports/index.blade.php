@extends('layouts.app')

@section('plugins.BsCustomFileInput', true)

@section('content')

<div class="row">
    <div class="col-md-6 offset-md-3 mt-5">

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There are the following errors while importing.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @session('error')
        <div class="alert alert-danger" role="alert"> 
            {{ $value }}
        </div>
    @endsession

        <form method="POST" enctype="multipart/form-data" action="{{ route('import-files') }}">
            @csrf

            <div class="form-group">
                <label for="import-type-select">Import Type</label>
                <select class="form-control" id="import-type-select" name="import_type">
                        <option value="" selected disabled>Select Import Type</option>

                        @foreach ($types as $key => $type)
                            <option value="{{ $key }}">{{ $type['label'] }}</option>
                        @endforeach
                </select>
            </div>

            <div class="form-group">
                <x-adminlte-input-file id="upload-files" name="uploadFiles[]" label="Upload files"
                    placeholder="Choose multiple files..." igroup-size="lg" legend="Choose" multiple>
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-file-upload"></i>
                        </div>
                    </x-slot>
                    <x-slot name="infoSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-file-upload"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
            </div>

            <div class="form-group" id="required-headers">

            </div>

            <div class="form-group">
                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Select import type first">
                    <button type="submit" id="import-button" class="btn btn-primary" disabled>Import</button>
                </span>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>

$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#import-type-select').on('change', function () {
        console.log($(this).val());

        let import_type = $(this).val();
        let required_headers = 'Required headers: ';

        if (import_type !== -1) {

            $('#import-button').attr('disabled', false);

            $.ajax({
                data: { import_type : import_type },
                url: '{{ route("get-required-headers") }}',
                type: 'GET',
                dataType: 'json',

                success: function (data) {
                    console.log(data);
                    console.log(data.required_headers);

                    if (data.required_headers.length > 0) {
                        required_headers += data.required_headers.join(', ');

                    } else {
                        required_headers += 'Not Defined In Config';
                    }

                    $('#required-headers').html(required_headers);
                },

                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });
})

</script>
@endpush