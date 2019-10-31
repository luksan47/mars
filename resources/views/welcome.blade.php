@extends('layouts.app')

@section('headextra')
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="content">
                <div class="title m-b-md">
                    Urán 2.0
                </div>

                <div class="links">
                    <a href="">
                    @lang('main.better')</a><br/>
                    <a href="">
                    @lang('main.faster')</a><br/>
                    <a href="">
                    @lang('main.brilliant')</a><br/>
                    <a href="">
                    @lang('main.essential')</a><br/>
                    <a href="">
                    @lang('main.modern')</a><br/>
                    <a href="">
                    @lang('main.open')</a><br/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
