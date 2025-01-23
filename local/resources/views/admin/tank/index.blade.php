@extends('admin.master')

@section('tab',8)
@section('content')
    <div class="allTank">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/tank">همه انبار ها</a>
            </div>
            <div class="allTopTableItem">
                <div class="groupEdits">افزودن انبار</div>
                <div class="filterItems">
                    <div class="filterTitle">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#filter"></use>
                            </svg>
                        </i>
                        فیلتر اطلاعات
                    </div>
                    <form method="GET" action="/admin/tank" class="filterContent" style="display: none">
                        <div class="filterContentItem">
                            <label>فیلتر عنوان و آیدی</label>
                            <input type="text" name="title" placeholder="عنوان یا آیدی را وارد کنید" value="{{$title}}">
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
        <div class="allReturnedPay">
            @foreach($tanks as $item)
                <div class="postItem" id="{{$item->id}}">
                    <h3>{{$item->name}}</h3>
                    <h5>
                        تعداد ورودی :
                        <span>{{\App\Models\Tank::where('parent_id' , $item->id)->where('type' , 1)->sum('count')}}</span>
                    </h5>
                    <h5>
                        تعداد خروجی :
                        <span>{{\App\Models\Tank::where('parent_id' , $item->id)->where('type' , 0)->sum('count')}}</span>
                    </h5>
                    <h5>
                        تعداد محصول :
                        <span>{{count(\App\Models\Tank::where('parent_id' , $item->id)->where('product_id' , '>=' ,1)->select('product_id')->distinct()->get())}}</span>
                    </h5>
                    <a class="show" target="_blank" href="/admin/tank/{{$item->id}}/edit" title="جزییات">جزییات و ویرایش انبار</a>
                    <div class="delete" id="{{$item->id}}">حذف انبار</div>
                </div>
            @endforeach
        </div>
        <form class="tankCreate" action="/admin/tank" method="post" style="display:none;">
            @csrf
            <div class="allCreatePostDetailItem">
                <label>نام انبار* :</label>
                <input type="text" name="name" placeholder="نام را وارد کنید">
                <div id="validation-name"></div>
            </div>
            <button class="button">ایجاد انبار</button>
        </form>
        {{ $tanks->links('admin.paginate') }}
        <div class="popUp" style="display:none;">
            <div class="popUpItem">
                <div class="title">آیا از حذف انبار مطمئن هستید؟</div>
                <p>با حذف انبار اطلاعات انبار به طور کامل حذف میشوند</p>
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
            $('.groupEdits').click(function(){
                $('.allReturnedPay').toggle();
                $('.tankCreate').toggle();
            });
            $('.allReturnedPay .postItem').on('click' , '.delete' ,function(){
                post = this.id;
                $('.popUp').show();
                $('.buttonsPop form').attr('action' , '/admin/tank/' + post+'/delete');
            })
        })
    </script>
@endsection
