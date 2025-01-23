@extends('seller.master')

@section('tab',11)
@section('content')
    <div class="allProduct">
        <div class="topProductIndex">
            <div class="right">
                <a href="/seller/dashboard">داشبورد</a>
                <span>/</span>
                <a href="/seller/story">همه استوری ها</a>
            </div>
            <div class="allTopTableItem">
                <a href="/seller/story/create" class="filterItems">
                    <div class="filterTitle" style="background: green">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#video"></use>
                            </svg>
                        </i>
                        افزودن استوری
                    </div>
                </a>
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
                <th>عنوان</th>
                <th>زمان ثبت</th>
                <th>عملیات</th>
            </tr>
            @foreach($stories as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>
                        <div class="pic">
                            <img src="{{$item->cover}}" alt="{{$item->title}}">
                        </div>
                    </td>
                    <td>{{$item->title}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>
                        <div class="buttons">
                            <a href="/seller/story/{{$item->id}}/edit">ویرایش</a>
                            <button id="{{$item->id}}">حذف</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $stories->links('admin.paginate') }}
        <div class="popUp" style="display:none;">
            <div class="popUpItem">
                <div class="title">آیا از حذف استوری مطمئن هستید؟</div>
                <p>با حذف استوری اطلاعات استوری به طور کامل حذف میشوند</p>
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
                $('.buttonsPop form').attr('action' , '/seller/story/' + post+'/delete');
            })
        })
    </script>
@endsection
