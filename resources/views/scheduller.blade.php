@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-info alert-dismissable page-alert scheduller_note">
            @if (\Session::get('locale') == 'ru')
                Заметка: Для корректной работы, привяжите свой telegram аккаунт к приложению
                <a href="/faq" title="кликни,чтобы узнать как">
                    <span class="glyphicon glyphicon-question-sign"></span>
                </a>
            @else
                Note: For correctly sheduller work, enter your telegram_id in your profile
                <a href="/faq" title="click to learn how">
                    <span class="glyphicon glyphicon-question-sign"></span>
                </a>
            @endif
        </div>
    </div>
    <div class="create_record container">
        <div class="col-lg-4 col-lg-offset-4 col-sm-4 col-sm-offset-4 col-xs-12 col-xs-offset-0 tb_response">
            <div class="form-group">
                <div class="col-lg-4 col-xs-5">
                    <select id="add_currency" class="selectpicker form-control" data-live-search="true">
                        @foreach($cross_currency as $value)
                            <option value="{{$value->currency}}">{{$value->currency}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 input-group">


                    <select id="add_record" class="selectpicker form-control" data-live-search="true">
                        @foreach($tokens as $value)
                            <option value="{{$value->name}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                    <span class="input-group-btn">
                    @if (\Session::get('locale') == 'ru')
                            <button class="btn btn-primary" type="submit" id="add_record_btn"
                                    value="{{$record_count}}">Добавить</button>
                        @else
                            <button class="btn btn-primary" type="submit" id="add_record_btn"
                                    value="{{$record_count}}">Add</button>
                        @endif
  </span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        <div class="row">


            <div class="col-md-12">
                @if (\Session::get('locale') == 'ru')
                    <h4>Планировщик</h4>
                @else
                    <h4>Scheduller</h4>
                @endif
                <div class="table-responsive table-bordred main">


                    <table id="mytable" class="table table-bordred table-striped table-hover table-condensed">
                        @if (\Session::get('locale') == 'ru')
                            <thead>
                            <th>Имя</th>
                            <th>Кросс-валюта</th>
                            <th class="th_snd_time">Время Отправки</th>
                            <th>Активен</th>
                            <th>Удалить</th>
                            </thead>
                        @else
                            <thead>
                            <th>Title</th>
                            <th>Cross-currency</th>
                            <th class="th_snd_time">Sending Time</th>
                            <th>Active</th>
                            <th>Delete</th>
                            </thead>
                        @endif
                        <tbody>
                        @foreach($result as $value)
                            <tr data-active="{{$value->id}}">
                                <td class="coin_title col-md-2">{{$value->name}}</td>
                                <td class="cross_currency col-md-1">{{$value->cross_currency}}</td>
                                <td class="sending_time col-md-3">
                                    <div class="input-group col-md-9 col-xs-12">
                                        <div class="input-group-addon currency-symbol hidden-xs">
                                            &#128338;</div>
                                        <input type="text" class="form-control"
                                               id="sending_time"
                                               value="{{$value->sending_time}}">
                                    </div>
                                </td>
                                <td class="col-md-2">
                                    <div class="checkbox checbox-switch switch-info">
                                        <label>
                                            @if ($value->active == '1')
                                                <input type="checkbox" name="play" checked="">
                                                <span></span>
                                            @else
                                                <input type="checkbox" name="play">
                                                <span></span>
                                            @endif
                                        </label>
                                    </div>
                                </td>

                                <td class="col-md-1">
                                    <button type="submit" class="btn btn-danger delete" name="remove_levels"
                                            value="delete">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </td>
                            </tr>

                        @endforeach


                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header alert-warning">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Are you sure?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="modal-btn-si">Yes
                    </button>
                    <button type="button" class="btn btn-primary" id="modal-btn-no">No
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header alert alert-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">You can't add more then 5 records</h4>
                </div>
                <div class="modal-body">
                    <p id="error"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="alert" role="alert" id="result"></div>
    <link rel="stylesheet" href="{{asset('css/scheduller.css')}}">
    <script type='text/javascript' src="{{asset('js/scheduller.js')}}"></script>
@endsection
