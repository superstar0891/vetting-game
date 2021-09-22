@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-sm-7 col-6">
            <h4 class="page-title">My Profile</h4>
        </div>

        <div class="col-sm-5 col-6 text-right m-b-30">
            <button class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#profile_modal"><i class="fa fa-plus"></i> Edit Profile</button>
        </div>
    </div>
    <div class="card-box profile-header">
        <div class="row">
            <div class="col-md-12">
                <div class="profile-view">
                    <div class="profile-img-wrap">
                        <div class="profile-img">
                                    @if($user->avatar == null)
                                    <a href="#"><img class="avatar" src="{{asset('assets/img/user.jpg')}}" alt=""></a>
                                    @else
                                    <a href="#"><img class="avatar" src="{{asset($user->avatar)}}" alt=""></a>
                                    @endif
                            
                        </div>
                    </div>
                    <div class="profile-basic" style=" height: 150px; margin-left: 400px;padding:30px;">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="profile-info-left">
                                    <h3 class="user-name m-t-0 mb-0">{{$user->first_name}} {{$user->last_name}}</h3>
                                    <small class="text-muted">{{$user->email}}</small>
                                    <div class="staff-id">Balance : {{$user->balance}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                        
            </div>
        </div>
    </div>
</div>
<div id="profile_modal" class="modal fade delete-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <form method="POST" action="/admin/updateProfile" enctype="multipart/form-data">
                    @csrf
                    <div class="card-box">
                        <h3 class="card-title">Basic Informations</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-img-wrap">
                                    @if($user->avatar == null)
                                    <img class="inline-block" src="{{asset('assets/img/user.jpg')}}" alt="user">
                                    @else
                                    <img class="inline-block" src="{{asset($user->avatar)}}" alt="user">
                                    @endif
                                    <div class="fileupload btn">
                                        <span class="btn-text">edit</span>
                                        <input class="upload" name="avatar"  type="file">
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <input type="hidden" name="id"   value="{{$user->id}}">
                                        <div class="col-md-12">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Email</label>
                                                <input type="text" name="user_email" class="form-control floating" readonly value="{{$user->email}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">First Name</label>
                                                <input type="text" name="first_name" class="form-control floating" required value="{{$user->first_name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Last Name</label>
                                                <input type="text" name="last_name" class="form-control floating" required value="{{$user->last_name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" style="width:100%" type="submit">Update Profile</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection			