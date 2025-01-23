@extends('admin.master')

@section('tab',9)
@section('content')
    <div class="allProduct">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/report">گزارش</a>
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
                    <form method="GET" action="/admin/report" class="filterContent">
                        <div class="filterContentItem">
                            <label>وضعیت ارسال</label>
                            <select name="status">
                                <option value="2">همه</option>
                                <option value="0">در حال بررسی</option>
                                <option value="1">تایید شده</option>
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
        <table>
            <tr>
                <th>آیدی</th>
                <th>تصویر</th>
                <th>توضیح</th>
                <th>کاربر</th>
                <th>زمان ثبت</th>
                <th>عملیات</th>
            </tr>
            @foreach($reports as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>
                        <div class="pic">
                            @if($item->reportable_type == 'App\\Models\\Product')
                                @if($item->product)
                                    @if($item->product->image != '[]')
                                        <a href="/product/{{$item->product->slug}}">
                                            <img src="{{json_decode($item->product->image)[0]}}" alt="{{$item->product->title}}">
                                        </a>
                                    @endif
                                @endif
                            @else
                                @if($item->user)
                                    <a href="/{{'@'.$item->user->slug}}">
                                        <img src="{{$item->user->profile??'/img/user.png'}}" alt="{{$item->user->name}}">
                                    </a>
                                @endif
                            @endif
                        </div>
                    </td>
                    <td>{{$item->data}}</td>
                    <td>{{$item->customer?$item->customer->name:'-'}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>
                        <div class="buttons">
                            <a href="/admin/report/{{$item->id}}/edit">ویرایش</a>
                            <button id="{{$item->id}}">حذف</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $reports->links('admin.paginate') }}
        <div class="popUp" style="display:none;">
            <div class="popUpItem">
                <div class="title">آیا از حذف گزارش مطمئن هستید؟</div>
                <p>با حذف گزارش اطلاعات گزارش به طور کامل حذف میشوند</p>
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
            $('.buttons').on('click' , 'button' ,function(){
                post = this.id;
                $('.popUp').show();
                $('.buttonsPop form').attr('action' , '/admin/report/' + post+'/delete');
            })
        })
    </script>
@endsection
