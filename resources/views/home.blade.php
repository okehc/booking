@extends('layouts.app')

<script>

  window.location = "http://10.30.42.27/booking/public/admin/reservacions";
</script>

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('quickadmin.qa_dashboard')</div>

            </div>
        </div>
    </div>
@endsection
