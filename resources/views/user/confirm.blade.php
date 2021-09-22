@extends('layouts.user')

@section('content')

<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">My Friends</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <div class="card-block">
                    <div class="col-lg-6 offset-lg-3 ">
                        <div style="width:100%;padding:30px"> 
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    @if ($message = Session::get('success'))
                                    <h4>{!! $message !!}<h4>
                                
                                    <?php Session::forget('success');?>
                                    @endif

                                    @if ($message = Session::get('error'))
                                    <h4>{!! $message !!}<h4>
                                    <?php Session::forget('error');?>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <a href="{{ route('deposit') }}">Back</a>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection