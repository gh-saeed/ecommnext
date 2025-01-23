@extends('admin.master')

@section('tab',22)
@section('content')
    <div class="allProduct">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/sellers">غرفه ها</a>
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
                    <form method="GET" action="/admin/sellers" class="filterContent">
                        <div class="filterContentItem">
                            <label>فیلتر نام و آیدی و شماره و ایمیل</label>
                            <input type="text" name="title" placeholder="جستجو ..." value="{{$title}}">
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
        <div class="allTableContainer">
            @foreach ($users as $item)
                <div class="postItem">
                    <div class="postTop">
                        <div class="postTitle">
                            <div class="postImages">
                                <div class="postImage">
                                    <img src="{{$item->profile??'/img/user.png'}}" alt="{{$item->name}}">
                                </div>
                            </div>
                            <ul>
                                <li>
                                    <span>غرفه دار :</span>
                                    <span>{{$item->name}}</span>
                                </li>
                                <li>
                                    <span>آیدی کاربر :</span>
                                    <span>{{$item->id}}</span>
                                </li>
                                <li>
                                    <span>شماره تماس :</span>
                                    <span>{{$item->number}}</span>
                                </li>
                                <li>
                                    <span>ایمیل :</span>
                                    <span>{{$item->email}}</span>
                                </li>
                                <li>
                                    <span>زمان فعالیت :</span>
                                    <span>{{$item->documentSuccess->created_at}}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="postOptions">
                            @if($item->documentSuccess)
                                <a href="/admin/document/{{$item->documentSuccess->id}}/edit" title="ویرایش فروشنده">ویرایش</a>
                            @endif
                            <button title="حذف کاربر" class="deleteUser" id="{{$item->id}}">حذف</button>
                        </div>
                    </div>
                    <div class="postBot">
                        <ul>
                            <li>
                                <span>موجودی جهت تسویه :</span>
                                <span>{{number_format($item->myCheckout())}} تومان </span>
                            </li>
                            <li>
                                <span>تعداد محصول :</span>
                                <span>{{number_format($item->product()->where('status',1)->count())}}</span>
                            </li>
                            <li>
                                <span>درآمد فروش :</span>
                                <span>{{number_format(\App\Models\Checkout::where('user_id',$item->id)->where('type',1)->sum('price'))}} تومان</span>
                            </li>
                            <li>
                                <span>امتیاز :</span>
                                <span>{{number_format(\App\Models\Comment::where('type',1)->where('status',1)->avg('rate'))??'بدون امتیاز'}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $users->links('admin.paginate') }}
        <div class="popUp" style="display:none;">
            <div class="popUpItem">
                <div class="title">آیا از حذف فروشنده مطمئن هستید؟</div>
                <p>با حذف فروشنده کاربر حذف نخواهد شد و صرفا از بخش فروشندگی خارج میشود</p>
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
            $('.popUp').hide();
            $('.filterContent').hide();
            $('.filemanager').show();
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
            $('.allTableContainer .postItem').on('click' , '.deleteUser' ,function(){
                post = this.id;
                $('.popUp').show();
                $('.buttonsPop form').attr('action' , '/admin/sellers/' + post+'/delete');
            })
        })
    </script>
@endsection
