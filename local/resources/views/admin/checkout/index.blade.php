@extends('admin.master')

@section('tab',34)
@section('content')
    <div class="allBrandPanel">
        <div class="topBrandPanel">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/checkout">تسویه حساب</a>
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
                    <form method="GET" action="/admin/checkout" class="filterContent">
                        <div class="filterContentItem">
                            <label>فیلتر نوع شارژ</label>
                            <select name="title">
                                <option value="">همه</option>
                                <option value="0">افزایش شارژ</option>
                                <option value="1">کاهش شارژ</option>
                            </select>
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
                    <tr>
                        <th>مبلغ</th>
                        <th>وضعیت پرداخت</th>
                        <th>نوع</th>
                        <th>کاربر</th>
                        <th>زمان</th>
                        <th>عملیات</th>
                    </tr>
                    @foreach($checkouts as $item)
                        <tr>
                            <td>{{number_format($item->price)}} تومان </td>
                            <td>
                                @if($item->status == 0)
                                    <span class="unActive">بررسی</span>
                                @elseif($item->status == 1)
                                    <span class="active">تایید شده</span>
                                @else
                                    <span class="unActive">رد شده</span>
                                @endif
                            </td>
                            <td>
                                @if($item->type == 0)
                                    <span class="active">تسویه حساب</span>
                                @endif
                            </td>
                            <td>{{$item->user?$item->user->name: '-'}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>
                                <div class="buttons">
                                    <button id="{{$item->id}}" class="editButton">مشاهده</button>
                                    <button id="{{$item->id}}" class="deleteButton">حذف</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $checkouts->links('admin.paginate') }}
            </div>
            <div>
                <form action="/admin/checkout" class="createFilled" method="post">
                    @csrf
                    <div class="filledItem">
                        <label>نام صاحب کارت*</label>
                        <input type="text" name="name" placeholder="نام را وارد کنید">
                        @error('name')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>مبلغ(تومان)*</label>
                        <input type="text" name="price" placeholder="مبلغ را وارد کنید">
                        @error('price')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>شماره کارت*</label>
                        <input type="text" name="card" placeholder="شماره را وارد کنید">
                        @error('card')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>شماره شبا*</label>
                        <input type="text" name="shaba" placeholder="شماره را وارد کنید">
                        @error('shaba')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label for="status">وضعیت پرداخت :</label>
                        <select id="status" name="status">
                            <option value="0" selected>در حال بررسی</option>
                            <option value="1">تایید شده</option>
                            <option value="2">رد شده</option>
                        </select>
                        @error('status')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label for="user_id">کاربر :</label>
                        <select id="user_id" name="user_id">
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
                <div class="title">آیا از حذف تسویه مطمئن هستید؟</div>
                <p>با حذف تسویه اطلاعات تسویه به طور کامل حذف میشوند</p>
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

@section('scripts')
    <script>
        $(document).ready(function(){
            var post = 0;
            $('.popUp').hide();
            $('.filemanager').hide();
            $('.filterContent').hide();
            $("select[name='type']").val(1);
            $('.filterTitle').click(function(){
                $('.filterContent').toggle();
            })
            $("select[name='type']").change(function (){
                if($(this).val() == 2) {
                    $(".product1").show();
                }else{
                    $(".product1").hide();
                }
            });
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
                $('.buttonsPop form').attr('action' , '/admin/checkout/' + post+'/delete');
            })
            $('.buttons').on('click' , '.editButton' ,function(){
                window.scrollTo(0,0);
                post = this.id;
                var form = {
                    "_token": "{{ csrf_token() }}",
                    checkout:post,
                };
                $.ajax({
                    url: "/admin/checkout/" + post + "/edit",
                    type: "get",
                    data: form,
                    success: function (data) {
                        $('.createFilled').attr('action' , '/admin/checkout/' + post+'/edit');
                        $(".createFilled input[name='_method']").remove();
                        $('.createFilled').append(
                            $('@method('put')')
                        )
                        $('.buttonForm h4').remove();
                        $('.buttonForm').append(
                            $('<h4>لغو</h4>').on('click',function(ss){
                                post = 0;
                                $('.createFilled').attr('action' , '/admin/checkout/');
                                $(".createFilled input[name='_method']").remove();
                                $(this).hide();
                                $("input[name='name']").val('');
                                $("input[name='price']").val('');
                                $("input[name='card']").val('');
                                $("input[name='shaba']").val('');
                                $("select[name='status']").val(100);
                            })
                        )
                        $("input[name='name']").val(data.name);
                        $("input[name='price']").val(data.price);
                        $("input[name='card']").val(data.card);
                        $("input[name='shaba']").val(data.shaba);
                        $("select[name='status']").val(data.status);
                        $("select[name='user_id']").val(data.user_id);
                        $("select[name='type']").val(data.type);
                        $(".product1").hide();
                    },
                });
            })
        })
    </script>
@endsection
