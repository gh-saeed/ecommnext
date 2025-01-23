@extends('admin.master')

@section('tab',1)
@section('content')
    <div class="allBrandPanel">
        <div class="topBrandPanel">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a>افزودن محصول با متاتگ</a>
            </div>
            <div class="allTopTableItem">
                <div class="filterItems">
                    <div class="filterTitle">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#filter"></use>
                            </svg>
                        </i>
                        فیلتر اطلاعات
                    </div>
                    <form method="GET" action="/admin/digikala" class="filterContent">
                        <div class="filterContentItem">
                            <label>فیلتر آیدی و نام کاربر</label>
                            <input type="text" name="title" placeholder="آیدی و نام کاربر را وارد کنید" value="{{$title}}">
                        </div>
                        <button type="submit">اعمال</button>
                    </form>
                </div>
            </div>
        </div>
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <div class="allTables">
            <div>
                <table>
                    <tr id="link1">
                        <th>لینک</th>
                        <th>وضعیت</th>
                        <th>لینک در حال بررسی</th>
                        <th>عملیات</th>
                    </tr>
                    @foreach($links as $item)
                        <tr id="link1">
                            <td><a href="{{$item->link}}" target="_blank">{{$item->link}}</a></td>
                            <td>
                                @if($item->status == 0)
                                    <span class="unActive">در حال بررسی</span>
                                @elseif($item->status == 1)
                                    <span class="active">تایید شده</span>
                                @else
                                    <span class="unActive">رد شده</span>
                                @endif
                            </td>
                            <td>{{$item->page}}</td>
                            <td>
                                <div class="button1 buttons">
                                    <a href="/admin/digikala/{{$item->id}}/reset">ریست شدن</a>
                                    <button id="{{$item->id}}" class="editButton">ویرایش</button>
                                    <button id="{{$item->id}}" class="deleteButton">حذف</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $links->links('admin.paginate') }}
            </div>
            <div>
                <form action="/admin/digikala" class="createFilled" method="post">
                    @csrf
                    <div class="filledItem">
                        <label>شناسه فروشگاه</label>
                        <input name="link" type="text" placeholder="مثال : test">
                        @error('link')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>وضعیت*</label>
                        <select name="status">
                            <option value="0" selected>در حال بررسی</option>
                            <option value="1">تایید شده</option>
                            <option value="2">رد شده</option>
                        </select>
                        @error('status')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>کاربر*</label>
                        <select name="user_id">
                            <option value="0" selected>بدون کاربر</option>
                            @foreach($users as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="buttonForm">
                        <button type="submit">ثبت اطلاعات</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="popUp" style="display:none;">
            <div class="popUpItem">
                <div class="title">آیا از حذف لینک مطمئن هستید؟</div>
                <p>با حذف لینک اطلاعات لینک به طور کامل حذف میشوند</p>
                <div class="buttonsPop">
                    <form method="POST" action="" id="deletePost">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit">حذف شود</button>
                    </form>
                    <button id="cancelDelete">منصرف شدم</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).mouseup(function(e)
        {
            var container = $("table tr .buttons");
            if (!container.is(e.target) && container.has(e.target).length == 0)
            {
                $('table tr .buttons .items').hide();
                $(".items").removeClass("open1");
            }
        });
        $(document).ready(function(){
            var post = 0;
            $('.popUp').hide();
            $('.filemanager').hide();
            $('.filterContent').hide();
            $("select[name='link_type']").val(0);
            $('.filterTitle').click(function(){
                $('.filterContent').toggle();
            })
            $('.addImageButton').click(function(){
                $('.filemanager').show();
            });
            $('#cancelDelete').click(function(){
                $('.popUp').hide();
                post = 0;
            })
            $('#deletePost').click(function(){
                $('.popUp').hide();
            });
            $('.buttons').on('click' , '.deleteButton' ,function(){
                post = this.id;
                $('.popUp').show();
                $('.buttonsPop form').attr('action' , '/admin/api/' + post+'/delete');
            })
            $("table tr .buttons").click(function (){
                var pp = $($(this)[0]['parentElement']).find('.items');
                $("table tr .buttons .items").hide();
                pp.show();
                if (pp.hasClass("open1")) {
                    pp.hide();
                    pp.removeClass("open1");
                }else {
                    pp.show();
                    $(".items").removeClass("open1");
                    pp.addClass("open1");
                }
            })
            $('.buttons').on('click' , '.editButton' ,function(){
                window.scrollTo(0,0);
                post = this.id;
                var form = {
                    "_token": "{{ csrf_token() }}",
                    link:post,
                };
                $.ajax({
                    url: "/admin/digikala/" + post + "/edit",
                    type: "get",
                    data: form,
                    success: function (data) {
                        $('.createFilled').attr('action' , '/admin/digikala/' + post+'/edit');
                        $(".createFilled input[name='_method']").remove();
                        $('.createFilled').append(
                            $('@method('put')')
                        )
                        $('.buttonForm h4').remove();
                        $('.buttonForm').append(
                            $('<h4>لغو</h4>').on('click',function(ss){
                                post = 0;
                                $('.createFilled').attr('action' , '/admin/digikala/');
                                $(".createFilled input[name='_method']").remove();
                                $(this).hide();
                                $("input[name='link']").val('');
                                $("input[name='prefix']").val('');
                                $("textarea[name='list']").val('');
                                $("select[name='user_id']").val(0);
                                $("select[name='status']").val(0);
                                $("select[name='currency']").val(0);
                                $("select[name='link_type']").val(0);
                                $("select[name='link_paginate']").val(0);
                            })
                        )
                        $("input[name='link']").val(data.link);
                        $("input[name='prefix']").val(data.prefix);
                        $("textarea[name='list']").val(data.list);
                        $("select[name='user_id']").val(data.user_id);
                        $("select[name='status']").val(data.status);
                        $("select[name='currency']").val(data.currency);
                        $("select[name='link_type']").val(data.link_type);
                        $("select[name='link_paginate']").val(data.link_paginate);
                    },
                });
            })
        })
    </script>
@endsection
