@extends('home.master')

@section('title' ,  __('messages.login_user'))
@section('content')
<div class="allAuthIndex2">
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <div class="form authIndex">
                <h1>{{__('messages.login_user')}}</h1>
                <div class="authItems level1">
                    <div class="social-container">
                        @if(\App\Models\Setting::where('key' , 'google')->pluck('value')->first())
                            <a href="/login-social/google" class="social" title="{{__('messages.login_gmail')}}">
                                <i>
                                    <svg class="icon">
                                        <use xlink:href="#google"></use>
                                    </svg>
                                </i>
                            </a>
                        @endif
                        @if(\App\Models\Setting::where('key' , 'github')->pluck('value')->first())
                            <a href="/login-social/github" class="social" title="{{__('messages.login_git')}}">
                                <i>
                                    <svg class="icon">
                                        <use xlink:href="#github"></use>
                                    </svg>
                                </i>
                            </a>
                        @endif
                    </div>
                    <input type="text" name="authData" placeholder="{{__('messages.number_email')}}">
                    @if(\App\Models\Setting::where('key' , 'captchaStatus')->pluck('value')->first())
                        <input type="text" name="captcha" placeholder="{{__('messages.security_code')}}">
                        <div class="captchaQuick">
                            @if(\App\Models\Setting::where('key' , 'captchaType')->pluck('value')->first() == 0)
                                {!! \Mews\Captcha\Facades\Captcha::img('math') !!}
                            @elseif(\App\Models\Setting::where('key' , 'captchaType')->pluck('value')->first() == 1)
                                {!! \Mews\Captcha\Facades\Captcha::img('inverse') !!}
                            @elseif(\App\Models\Setting::where('key' , 'captchaType')->pluck('value')->first() == 2)
                                {!! \Mews\Captcha\Facades\Captcha::img('mini2') !!}
                            @elseif(\App\Models\Setting::where('key' , 'captchaType')->pluck('value')->first() == 3)
                                {!! \Mews\Captcha\Facades\Captcha::img('default') !!}
                            @elseif(\App\Models\Setting::where('key' , 'captchaType')->pluck('value')->first() == 4)
                                {!! \Mews\Captcha\Facades\Captcha::img('mini') !!}
                            @endif
                        </div>
                    @endif
                    <div class="buttons">
                        <button class="continue">{{__('messages.submit')}}</button>
                        <button class="first">{{__('messages.login_once')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <img class="lazyload" src="/img/404Image.png" data-src="{{\App\Models\Setting::where('key' , 'logo')->pluck('value')->first()}}" alt="{{\App\Models\Setting::where('key' , 'title')->pluck('value')->first()}}">
                    <h5>{{__('messages.login_welcome')}}</h5>
                    <p>{{__('messages.login_welcome1')}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptPage')
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
    <script src="/js/jquery.toast.min.js"></script>
<script>
    $(document).ready(function(){
        var submit1 = {!! json_encode(__('messages.submit'), JSON_HEX_TAG) !!};
        var wait1 = {!! json_encode(__('messages.wait'), JSON_HEX_TAG) !!};
        var login_fill1 = {!! json_encode(__('messages.login_fill'), JSON_HEX_TAG) !!};
        var login_attention1 = {!! json_encode(__('messages.login_attention'), JSON_HEX_TAG) !!};
        var login_pass1 = {!! json_encode(__('messages.login_pass'), JSON_HEX_TAG) !!};
        var login_sign1 = {!! json_encode(__('messages.login_sign'), JSON_HEX_TAG) !!};
        var login_forget1 = {!! json_encode(__('messages.login_forget'), JSON_HEX_TAG) !!};
        var done1 = {!! json_encode(__('messages.done'), JSON_HEX_TAG) !!};
        var login_error1 = {!! json_encode(__('messages.login_error1'), JSON_HEX_TAG) !!};
        var login_signup1 = {!! json_encode(__('messages.login_signup'), JSON_HEX_TAG) !!};
        var login_pass_error1 = {!! json_encode(__('messages.login_pass_error'), JSON_HEX_TAG) !!};
        var verification_code1 = {!! json_encode(__('messages.verification_code'), JSON_HEX_TAG) !!};
        var login_confirm1 = {!! json_encode(__('messages.login_confirm'), JSON_HEX_TAG) !!};
        var login_time1 = {!! json_encode(__('messages.login_time'), JSON_HEX_TAG) !!};
        var login_timeout1 = {!! json_encode(__('messages.login_timeout'), JSON_HEX_TAG) !!};
        var name1 = {!! json_encode(__('messages.name'), JSON_HEX_TAG) !!};
        var user_name1 = {!! json_encode(__('messages.user_name'), JSON_HEX_TAG) !!};
        var identification_code1 = {!! json_encode(__('messages.identification_code'), JSON_HEX_TAG) !!};
        var verification_code2 = {!! json_encode(__('messages.verification_code2'), JSON_HEX_TAG) !!};
        var login_ban1 = {!! json_encode(__('messages.login_ban'), JSON_HEX_TAG) !!};
        var login_ban2 = {!! json_encode(__('messages.login_ban2'), JSON_HEX_TAG) !!};
        var login_captcha1 = {!! json_encode(__('messages.login_captcha'), JSON_HEX_TAG) !!};
        var login_once1 = {!! json_encode(__('messages.login_once'), JSON_HEX_TAG) !!};
        number = $("input[name='authData']").val('');
        var number ='';
        var code ='';
        var buttons = '';
        $('.level1 .continue').click(function(){
            $(this).text(wait1);
            buttons = $(this);
            if(number == ''){
                number = $("input[name='authData']").val();
                var form = {
                    "_token": "{{ csrf_token() }}",
                    "authData": number,
                    'captcha' : $(".authItems input[name='captcha']").val()
                };

                $.ajax({
                    url: "/check-auth",
                    type: "post",
                    data: form,
                    success: function (data) {
                        if(data[1] == 0){
                            number = '';
                            buttons.text(submit1);
                            $.toast({
                                text: login_fill1,
                                heading: login_attention1,
                                icon: 'error',
                                showHideTransition: 'fade',
                                allowToastClose: true,
                                hideAfter: 3000,
                                stack: 5,
                                position: 'bottom-left',
                                textAlign: 'left',
                                loader: true,
                                loaderBg: '#c60000',
                            });
                        }
                        else{
                            if(data == 'exist'){
                                $('.level1').remove();
                                $('.authIndex').append(
                                    $('<div class="authItems level2">'+
                                        '<input type="password" id="authPassword" name="password" placeholder="'+login_pass1+'">'+
                                        '<div class="buttons">'+
                                        '<button class="enter">'+login_sign1+'</button>'+
                                        '<button class="forget">'+login_forget1+'</button>'+
                                        '</div>'+
                                        '</div>')
                                        .on('click' , '.enter',function(){
                                            var password = $("input[name='password']").val();
                                            var form = {
                                                "_token": "{{ csrf_token() }}",
                                                "authData": number,
                                                "password": password,
                                            };
                                            $.ajax({
                                                url: "/enter-auth",
                                                type: "post",
                                                data: form,
                                                success: function (data) {
                                                    if(data == 'success'){
                                                        $.toast({
                                                            heading: done1,
                                                            text: login_signup1,
                                                            icon: 'success',
                                                            showHideTransition: 'fade',
                                                            allowToastClose: true,
                                                            hideAfter: 3000,
                                                            stack: 5,
                                                            position: 'bottom-left',
                                                            textAlign: 'left',
                                                            loader: true,
                                                            loaderBg: '#9EC600',
                                                        });
                                                        window.location.href="/profile";
                                                    }
                                                    if(data == 'format'){
                                                        $.toast({
                                                            heading: login_error1,
                                                            text: login_fill1,
                                                            icon: 'error',
                                                            showHideTransition: 'fade',
                                                            allowToastClose: true,
                                                            hideAfter: 3000,
                                                            stack: 5,
                                                            position: 'bottom-left',
                                                            textAlign: 'left',
                                                            loader: true,
                                                            loaderBg: '#c60000',
                                                        });
                                                    }
                                                    if(data == 'no'){
                                                        $.toast({
                                                            heading: login_error1,
                                                            text: login_pass_error1,
                                                            icon: 'error',
                                                            showHideTransition: 'fade',
                                                            allowToastClose: true,
                                                            hideAfter: 3000,
                                                            stack: 5,
                                                            position: 'bottom-left',
                                                            textAlign: 'left',
                                                            loader: true,
                                                            loaderBg: '#c60000',
                                                        });
                                                    }
                                                },
                                            })
                                        })
                                        .on('click' , '.forget',function(ss){
                                            var form = {
                                                "_token": "{{ csrf_token() }}",
                                                "authData": number,
                                            };
                                            $.ajax({
                                                url: "/change-password",
                                                type: "post",
                                                data: form,
                                                success: function (data) {
                                                    $('.authIndex .level2').remove();
                                                    $('.authIndex').append(
                                                        $(
                                                            '<div class="authItems level2">'+
                                                            '<input type="text" id="authNumber" name="code" placeholder="'+verification_code1+'">'+
                                                            '<button>'+submit1+'</button>'+
                                                            '</div>')
                                                            .on('click' , 'button',function(){
                                                                code=$("input[name='code']").val();
                                                                var form = {
                                                                    "_token": "{{ csrf_token() }}",
                                                                    "authData": number,
                                                                    "code": code,
                                                                };
                                                                $.ajax({
                                                                    url: "/check-pass-code",
                                                                    type: "post",
                                                                    data: form,
                                                                    success: function (data) {
                                                                        if(data == 'ok'){
                                                                            $('.level2').remove();
                                                                            $('.authIndex').append(
                                                                                $(
                                                                                    '<div class="authItems level3">'+
                                                                                    '<input type="password" id="authPassword" name="password" placeholder="'+login_pass1+'">'+
                                                                                    '<input type="password" id="authConfirmed" name="confirmed" placeholder="'+login_confirm1+'">'+
                                                                                    '<button>'+submit1+'</button>'+
                                                                                    '</div>')
                                                                                    .on('click' , 'button',function(){
                                                                                        var form = {
                                                                                            "_token": "{{ csrf_token() }}",
                                                                                            "authData": number,
                                                                                            "code": code,
                                                                                            "password": $("input[name='password']").val(),
                                                                                            "confirmed": $("input[name='confirmed']").val(),
                                                                                        };
                                                                                        $.ajax({
                                                                                            url: "/change-user-password",
                                                                                            type: "post",
                                                                                            data: form,
                                                                                            success: function (data) {
                                                                                                if(data == 'time'){
                                                                                                    $.toast({
                                                                                                        heading: login_time1,
                                                                                                        text: login_timeout1,
                                                                                                        icon: 'error',
                                                                                                        showHideTransition: 'fade',
                                                                                                        allowToastClose: true,
                                                                                                        hideAfter: 3000,
                                                                                                        stack: 5,
                                                                                                        position: 'bottom-left',
                                                                                                        textAlign: 'left',
                                                                                                        loader: true,
                                                                                                        loaderBg: '#c60000',
                                                                                                    });
                                                                                                }
                                                                                                if(data == 'format'){
                                                                                                    $.toast({
                                                                                                        heading: login_error1,
                                                                                                        text: login_fill1,
                                                                                                        icon: 'error',
                                                                                                        showHideTransition: 'fade',
                                                                                                        allowToastClose: true,
                                                                                                        hideAfter: 3000,
                                                                                                        stack: 5,
                                                                                                        position: 'bottom-left',
                                                                                                        textAlign: 'left',
                                                                                                        loader: true,
                                                                                                        loaderBg: '#c60000',
                                                                                                    });
                                                                                                }
                                                                                                if(data == 'success'){
                                                                                                    $.toast({
                                                                                                        heading: done1,
                                                                                                        text: login_signup1,
                                                                                                        icon: 'success',
                                                                                                        showHideTransition: 'fade',
                                                                                                        allowToastClose: true,
                                                                                                        hideAfter: 3000,
                                                                                                        stack: 5,
                                                                                                        position: 'bottom-left',
                                                                                                        textAlign: 'left',
                                                                                                        loader: true,
                                                                                                        loaderBg: '#9EC600',
                                                                                                    });
                                                                                                    window.location.href="/profile";
                                                                                                }
                                                                                            },
                                                                                            error: function (errors) {
                                                                                                if(errors.responseJSON.errors['password']){
                                                                                                    $.toast({
                                                                                                        heading: login_pass1,
                                                                                                        text: errors.responseJSON.errors['password'],
                                                                                                        icon: 'error',
                                                                                                        showHideTransition: 'fade',
                                                                                                        allowToastClose: true,
                                                                                                        hideAfter: 3000,
                                                                                                        stack: 5,
                                                                                                        position: 'bottom-left',
                                                                                                        textAlign: 'left',
                                                                                                        loader: true,
                                                                                                        loaderBg: '#c60000',
                                                                                                    });
                                                                                                }
                                                                                                if(errors.responseJSON.errors['name']){
                                                                                                    $.toast({
                                                                                                        text: name1,
                                                                                                        heading: errors.responseJSON.errors['name'],
                                                                                                        icon: 'error',
                                                                                                        showHideTransition: 'fade',
                                                                                                        allowToastClose: true,
                                                                                                        hideAfter: 3000,
                                                                                                        stack: 5,
                                                                                                        position: 'bottom-left',
                                                                                                        textAlign: 'left',
                                                                                                        loader: true,
                                                                                                        loaderBg: '#c60000',
                                                                                                    });
                                                                                                }
                                                                                            }
                                                                                        })
                                                                                    })
                                                                            );
                                                                        }else{
                                                                            $.toast({
                                                                                text: verification_code1,
                                                                                title: verification_code2,
                                                                                icon: 'error',
                                                                                showHideTransition: 'fade',
                                                                                allowToastClose: true,
                                                                                hideAfter: 3000,
                                                                                stack: 5,
                                                                                position: 'bottom-left',
                                                                                textAlign: 'left',
                                                                                loader: true,
                                                                                loaderBg: '#c60000',
                                                                            });
                                                                        }
                                                                    },
                                                                    error: function (xhr) {
                                                                        $.toast({
                                                                            text: verification_code1,
                                                                            title: verification_code2,
                                                                            icon: 'error', // Type of toast icon
                                                                            showHideTransition: 'fade', // fade, slide or plain
                                                                            allowToastClose: true, // Boolean value true or false
                                                                            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                                                            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                                                                            position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                                                                            textAlign: 'left',
                                                                            loader: true,
                                                                            loaderBg: '#c60000',
                                                                        });
                                                                    }
                                                                })
                                                            })
                                                    );
                                                },
                                            })
                                        })
                                );
                            }
                            if(data == 'code'){
                                $('.level1').remove();
                                $('.authIndex').append(
                                    $(
                                        '<div class="authItems level2">'+
                                        '<input type="text" id="authNumber" name="code" placeholder="'+verification_code1+'">'+
                                        '<button>'+submit1+'</button>'+
                                        '</div>')
                                        .on('click' , 'button',function(){
                                            code=$("input[name='code']").val();
                                            var form = {
                                                "_token": "{{ csrf_token() }}",
                                                "authData": number,
                                                "code": code,
                                            };
                                            $.ajax({
                                                url: "/check-code",
                                                type: "post",
                                                data: form,
                                                success: function (data) {
                                                    if(data == 'ok'){
                                                        $('.level2').remove();
                                                        $('.authIndex').append(
                                                            $(
                                                                '<div class="authItems level3">'+
                                                                '<input type="text" id="authUser" name="name" placeholder="'+user_name1+'">'+
                                                                '<input type="text" id="referral" name="referral" placeholder="'+identification_code1 +'">'+
                                                                '<input type="password" id="authPassword" name="password" placeholder="'+login_pass1+'">'+
                                                                '<input type="password" id="authConfirmed" name="confirmed" placeholder="'+login_confirm1+'">'+
                                                                '<div class="fields"></div>'+
                                                                '<button>'+submit1+'</button>'+
                                                                '</div>')
                                                                .on('click' , 'button',function(){
                                                                    $(this).text(wait1);
                                                                    buttons = $(this);
                                                                    var form = {
                                                                        "_token": "{{ csrf_token() }}",
                                                                        "authData": number,
                                                                        "code": code,
                                                                        "user": $("input[name='name']").val(),
                                                                        "password": $("input[name='password']").val(),
                                                                        "confirmed": $("input[name='confirmed']").val(),
                                                                        "referral": $("input[name='referral']").val(),
                                                                    };
                                                                    $.ajax({
                                                                        url: "/add-user",
                                                                        type: "post",
                                                                        data: form,
                                                                        success: function (data) {
                                                                            if(data == 'time'){
                                                                                $.toast({
                                                                                    heading: login_time1,
                                                                                    text: login_timeout1,
                                                                                    icon: 'error',
                                                                                    showHideTransition: 'fade',
                                                                                    allowToastClose: true,
                                                                                    hideAfter: 3000,
                                                                                    stack: 5,
                                                                                    position: 'bottom-left',
                                                                                    textAlign: 'left',
                                                                                    loader: true,
                                                                                    loaderBg: '#c60000',
                                                                                });
                                                                            }
                                                                            if(data == 'format'){
                                                                                $.toast({
                                                                                    heading: login_error1,
                                                                                    text: login_fill1,
                                                                                    icon: 'error',
                                                                                    showHideTransition: 'fade',
                                                                                    allowToastClose: true,
                                                                                    hideAfter: 3000,
                                                                                    stack: 5,
                                                                                    position: 'bottom-left',
                                                                                    textAlign: 'left',
                                                                                    loader: true,
                                                                                    loaderBg: '#c60000',
                                                                                });
                                                                            }
                                                                            if(data == 'success'){
                                                                                $.toast({
                                                                                    heading: done1,
                                                                                    text: login_signup1,
                                                                                    icon: 'success',
                                                                                    showHideTransition: 'fade',
                                                                                    allowToastClose: true,
                                                                                    hideAfter: 3000,
                                                                                    stack: 5,
                                                                                    position: 'bottom-left',
                                                                                    textAlign: 'left',
                                                                                    loader: true,
                                                                                    loaderBg: '#9EC600',
                                                                                });
                                                                                window.location.href="/profile";
                                                                            }
                                                                        },
                                                                        error: function (errors) {
                                                                            buttons.text(submit1);
                                                                            if(errors.responseJSON.errors['password']){
                                                                                $.toast({
                                                                                    heading: login_pass1,
                                                                                    text: errors.responseJSON.errors['password'],
                                                                                    icon: 'error',
                                                                                    showHideTransition: 'fade',
                                                                                    allowToastClose: true,
                                                                                    hideAfter: 3000,
                                                                                    stack: 5,
                                                                                    position: 'bottom-left',
                                                                                    textAlign: 'left',
                                                                                    loader: true,
                                                                                    loaderBg: '#c60000',
                                                                                });
                                                                            }
                                                                            if(errors.responseJSON.errors['user']){
                                                                                $.toast({
                                                                                    heading: name1,
                                                                                    text: errors.responseJSON.errors['user'],
                                                                                    icon: 'error',
                                                                                    showHideTransition: 'fade',
                                                                                    allowToastClose: true,
                                                                                    hideAfter: 3000,
                                                                                    stack: 5,
                                                                                    position: 'bottom-left',
                                                                                    textAlign: 'left',
                                                                                    loader: true,
                                                                                    loaderBg: '#c60000',
                                                                                });
                                                                            }
                                                                        }
                                                                    })
                                                                })
                                                        );
                                                    }else{
                                                        $.toast({
                                                            heading: verification_code1,
                                                            text: verification_code2,
                                                            icon: 'error',
                                                            showHideTransition: 'fade',
                                                            allowToastClose: true,
                                                            hideAfter: 3000,
                                                            stack: 5,
                                                            position: 'bottom-left',
                                                            textAlign: 'left',
                                                            loader: true,
                                                            loaderBg: '#c60000',
                                                        });
                                                    }
                                                },
                                                error: function (xhr) {
                                                    $.toast({
                                                        heading: verification_code1,
                                                        text: verification_code2,
                                                        icon: 'error', // Type of toast icon
                                                        showHideTransition: 'fade', // fade, slide or plain
                                                        allowToastClose: true, // Boolean value true or false
                                                        hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                                        stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                                                        position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                                                        textAlign: 'left',
                                                        loader: true,
                                                        loaderBg: '#c60000',
                                                    });
                                                }
                                            })
                                        })
                                );
                            }
                            if(data == 'ban'){
                                $.toast({
                                    text: login_ban1,
                                    heading: login_ban2,
                                    icon: 'error',
                                    showHideTransition: 'fade',
                                    allowToastClose: true,
                                    hideAfter: 3000,
                                    stack: 5,
                                    position: 'bottom-left',
                                    textAlign: 'left',
                                    loader: true,
                                    loaderBg: '#c60000',
                                });
                            }
                        }
                    },
                    error: function (xhr) {
                        buttons.text(submit1);
                        number = '';
                        setTimeout(function() { window.location.reload() }, 1000);
                        if(xhr.responseJSON.errors['captcha']){
                            $.toast({
                                text: login_captcha1,
                                heading: login_attention1,
                                icon: 'error',
                                showHideTransition: 'fade',
                                allowToastClose: true,
                                hideAfter: 3000,
                                stack: 5,
                                position: 'bottom-left',
                                textAlign: 'left',
                                loader: true,
                                loaderBg: '#c60000',
                            });
                        }
                        else{
                            $.toast({
                                text: login_fill1,
                                heading: login_attention1,
                                icon: 'error',
                                showHideTransition: 'fade',
                                allowToastClose: true,
                                hideAfter: 3000,
                                stack: 5,
                                position: 'bottom-left',
                                textAlign: 'left',
                                loader: true,
                                loaderBg: '#c60000',
                            });
                        }
                    }
                });
            }
        })
        $('.level1 .first').click(function(){
            $(this).text(wait1);
            buttons = $(this);
            if(number == ''){
                number = $("input[name='authData']").val();
                var form = {
                    "_token": "{{ csrf_token() }}",
                    "authData": number,
                    'captcha' : $(".authItems input[name='captcha']").val()
                };

                $.ajax({
                    url: "/send-login-code",
                    type: "post",
                    data: form,
                    success: function (data) {
                        if(data == 'code'){
                            $('.level1').remove();
                            $('.authIndex').append(
                                $(
                                    '<div class="authItems level2">'+
                                    '<input type="text" id="authNumber" name="code" placeholder="'+verification_code1+'">'+
                                    '<button>'+submit1+'</button>'+
                                    '</div>')
                                    .on('click' , 'button',function(){
                                        code=$("input[name='code']").val();
                                        var form = {
                                            "_token": "{{ csrf_token() }}",
                                            "authData": number,
                                            "code": code,
                                            "type": 1,
                                        };
                                        $.ajax({
                                            url: "/check-code-login",
                                            type: "post",
                                            data: form,
                                            success: function (data) {
                                                if(data == 'ok'){
                                                    window.location.reload();
                                                }else if(data == 'ban'){
                                                    $.toast({
                                                        text: login_ban1,
                                                        heading: login_ban2,
                                                        icon: 'error',
                                                        showHideTransition: 'fade',
                                                        allowToastClose: true,
                                                        hideAfter: 3000,
                                                        stack: 5,
                                                        position: 'bottom-left',
                                                        textAlign: 'left',
                                                        loader: true,
                                                        loaderBg: '#c60000',
                                                    });
                                                }
                                                else{
                                                    $.toast({
                                                        heading: verification_code1,
                                                        text: verification_code2,
                                                        icon: 'error',
                                                        showHideTransition: 'fade',
                                                        allowToastClose: true,
                                                        hideAfter: 3000,
                                                        stack: 5,
                                                        position: 'bottom-left',
                                                        textAlign: 'left',
                                                        loader: true,
                                                        loaderBg: '#c60000',
                                                    });
                                                }
                                            },
                                            error: function (xhr) {
                                                $.toast({
                                                    heading: verification_code1,
                                                    text: verification_code2,
                                                    icon: 'error', // Type of toast icon
                                                    showHideTransition: 'fade', // fade, slide or plain
                                                    allowToastClose: true, // Boolean value true or false
                                                    hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                                    stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                                                    position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                                                    textAlign: 'left',
                                                    loader: true,
                                                    loaderBg: '#c60000',
                                                });
                                            }
                                        })
                                    })
                            );
                        }
                    },
                    error: function (xhr) {
                        buttons.text(login_once1);
                        number = '';
                        if(xhr.responseJSON.errors['g-recaptcha-response']){
                            $.toast({
                                text: login_captcha1,
                                heading: login_attention1,
                                icon: 'error',
                                showHideTransition: 'fade',
                                allowToastClose: true,
                                hideAfter: 3000,
                                stack: 5,
                                position: 'bottom-left',
                                textAlign: 'left',
                                loader: true,
                                loaderBg: '#c60000',
                            });
                        }
                        else{
                            $.toast({
                                text: login_fill1,
                                heading: login_attention1,
                                icon: 'error',
                                showHideTransition: 'fade',
                                allowToastClose: true,
                                hideAfter: 3000,
                                stack: 5,
                                position: 'bottom-left',
                                textAlign: 'left',
                                loader: true,
                                loaderBg: '#c60000',
                            });
                        }
                        setTimeout(function() { window.location.reload() }, 1000);
                    }
                });
            }
        })
    });
</script>
@endsection

