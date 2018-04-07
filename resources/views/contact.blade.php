@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">


                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{$result[0]->name}}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class=" col-md-12 col-lg-12">
                                <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td class=" col-md-7">email:</td>
                                        <td class=" col-md-5 right_column"><input class="form-control"
                                                                                  value="{{$result[0]->email}}" id="user_email"></td>
                                    </tr>
                                    <tr>
                                        <td class=" col-md-7">name:</td>
                                        <td class=" col-md-5 right_column"><input class="form-control"
                                                                                  value="{{$result[0]->name}}" id="telegram_id"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <textarea class="form-control" rows="4" placeholder="Your message..."
                                  name="" id="" style="width: 100%"></textarea>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-md btn-primary" type="submit" id="back_to_previous"
                                value="">Back
                        </button>
                        <span class="pull-right">
                            <button class="btn btn btn-md btn-success" type="submit" id="save_profile">Save
                    </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
    <script type='text/javascript' src="{{asset('js/profile.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/contact.css')}}">
{{--<script type='text/javascript' src="{{asset('js/scheduller.js')}}"></script>--}}
@endsection