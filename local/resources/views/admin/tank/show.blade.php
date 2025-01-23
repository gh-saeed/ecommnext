@extends('admin.master')

@section('tab',8)
@section('content')
    <div class="allTank">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="#">جزییات {{$tank->name}}</a>
            </div>
        </div>
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <form class="createTank" method="post" action="/admin/tank/{{$tank->id}}/edit" style="grid-template-columns: 1fr auto">
            @csrf
            <div class="allCreatePostItem">
                <label>نام* :</label>
                <input type="text" name="name" value="{{$tank->name}}" placeholder="نام* را وارد کنید">
            </div>
            <button>ویرایش انبار</button>
        </form>
        <form class="createTank" method="post" action="/admin/tank/add-detail">
            @csrf
            <input type="hidden" name="tank_id" value="{{$tank->id}}">
            <div class="allCreatePostItem">
                <label>تعداد* :</label>
                <input type="text" name="count" placeholder="تعداد* را وارد کنید">
                <div id="validation-price"></div>
            </div>
            <div class="allCreatePostItem">
                <label>نوع :</label>
                <select name="type">
                    <option value="1" selected>افزایش</option>
                    <option value="0">کاهش</option>
                </select>
            </div>
            <div class="allCreatePostItem">
                <label>نام محصول :</label>
                <input type="text" name="name" placeholder="نام را وارد کنید">
            </div>
            <div class="allCreatePostItem">
                <label>محصول :</label>
                <select name="product_id">
                    <option value="0" selected>محصول موجود نیست</option>
                    @foreach($products as $el)
                    <option value="{{$el->id}}">{{$el->title}}</option>
                    @endforeach
                </select>
            </div>
            <button>افزودن جزییات</button>
        </form>
        <div class="allReturnedPay">
            @foreach($tanks as $item)
                <div class="postItem">
                    <h4 class="{{$item->type == 0 ? '' : 'active'}}">
                        @if($item->product_id >= 1 && $item->product)
                            {{$item->product->title}}
                        @else
                            {{$item->name}}
                        @endif
                    </h4>
                    @if($item->type == 0)
                        <h5>
                            تعداد خروجی :
                            <span>{{$item->count}}</span>
                        </h5>
                    @else
                        <h5>
                            تعداد ورودی :
                            <span>{{$item->count}}</span>
                        </h5>
                    @endif
                    <h5>
                        زمان ثبت :
                        <span>{{$item->created_at}}</span>
                    </h5>
                    <div class="delete" id="{{$item->id}}">حذف</div>
                </div>
            @endforeach
        </div>
        <div class="popUp" style="display:none;">
            <div class="popUpItem">
                <div class="title">آیا از حذف جزییات مطمئن هستید؟</div>
                <p>اطلاعات جزییات به طور کامل حذف میشوند</p>
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
        $(document).ready(function(){
            var post = 0;
            var checked = 0;
            $('.popUp').hide();
            $('.filterContent').hide();
            $('.filterTitle').click(function(){
                $('.filterContent').toggle();
            })
            $('#cancelDelete').click(function(){
                $('.popUp').hide();
                post = 0;
            })
            $('#deletePost').click(function(){
                $('.popUp').hide();
            });
            $('.allReturnedPay .postItem').on('click' , '.delete' ,function(){
                post = this.id;
                $('.popUp').show();
                $('.buttonsPop form').attr('action' , '/admin/tank/' + post+'/delete');
            })
        })
    </script>
@endsection
