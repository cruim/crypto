@extends('layouts.app')

@section('content')
    <div class="container1" id="pie">
        <div class="pie-ui">
            <div class="pie-slice top scale bg-color" id="user_home"><i class="fa fa-user"></i></div>
            <div class="pie-slice right scale bg-color"id="scheduller_home"><i class="fa fa-calendar"></i></div>
            <div class="pie-slice left scale bg-color" id="target_home"><i class="fa fa-crosshairs"></i></div>
            <div class="pie-slice bottom scale bg-color" id="faq_home"><i class="fa fa-question"></i></div>
        </div>
    </div>
    <link rel="stylesheet" href="{{asset('css/home2.css')}}">
    <script type='text/javascript' src="{{asset('js/home2.js')}}"></script>
@endsection

