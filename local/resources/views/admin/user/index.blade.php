@extends('admin.master')

@section('tab',10)
@section('content')
    <div class="allProduct">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/user">همه کاربران</a>
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
                    <form method="GET" action="/admin/user" class="filterContent">
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
                                    <img src="/img/user.png" alt="{{$item->title}}">
                                </div>
                            </div>
                            <ul>
                                <li>
                                    <span>نام کاربری :</span>
                                    <span>{{$item->name}}</span>
                                </li>
                                <li>
                                    <span>آیدی کاربر :</span>
                                    <span>{{$item->id}}</span>
                                </li>
                                <li>
                                    <span>کیف پول :</span>
                                    <span>{{number_format($item->walletUp - $item->walletDown)}} تومان </span>
                                </li>
                                <li>
                                    <span>مبلغ کل سفارش :</span>
                                    <span>{{number_format($item->pay_count)}} تومان </span>
                                </li>
                                <li>
                                    <span>صفحاتی که مشاهده کرد امروز :</span>
                                    <span>{{number_format(\App\Models\View::where('user_id' , $item->id)->whereDate('created_at', \Carbon\Carbon::today())->count())}}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="postOptions grid3">
                            <a href="/admin/user/{{$item->id}}/edit" title="ویرایش کاربر">ویرایش</a>
                            <a href="/admin/user/{{$item->id}}/show" title="مشاهده کاربر">بازدید ها</a>
                            <button title="حذف کاربر" class="deleteUser" id="{{$item->id}}">حذف</button>
                        </div>
                    </div>
                    <div class="postBot">
                        <ul>
                            <li>
                                <span>شماره تماس :</span>
                                <span>{{$item->number}}</span>
                            </li>
                            <li>
                                <span>ایمیل :</span>
                                <span>{{$item->email}}</span>
                            </li>
                            <li>
                                <span>وضعیت :</span>
                                @if($item->isOnline())
                                    <span class="active">آنلاین</span>
                                @else
                                    <span class="unActive">آفلاین</span>
                                @endif
                            </li>
                            <li>
                                <span>علاقه مندی :</span>
                                <span>{{\App\Models\Like::where('user_id' , $item->id)->count()}}</span>
                            </li>
                            <li>
                                <span>نشانه ها :</span>
                                <span>{{\App\Models\Bookmark::where('user_id' , $item->id)->count()}}</span>
                            </li>
                            <li>
                                <span>زمان ثبت :</span>
                                <span>{{$item->created_at}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $users->links('admin.paginate') }}
        <div class="popUp" style="display:none;">
            <div class="popUpItem">
                <div class="title">آیا از حذف کاربر مطمئن هستید؟</div>
                <p>با حذف کاربر اطلاعات کاربر به طور کامل حذف میشوند</p>
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
                $('.buttonsPop form').attr('action' , '/admin/user/' + post+'/delete');
            })
        })
    </script>
@endsection
