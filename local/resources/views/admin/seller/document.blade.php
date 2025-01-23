@extends('admin.master')

@section('tab' , 22)
@section('content')
    <div class="profileIndexTicket">
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <table>
            <tr>
                <th>نام فروشنده</th>
                <th>جلو کارت ملی</th>
                <th>پشت کارت ملی</th>
                <th>وضعیت</th>
                <th>زمان ثبت</th>
                <th>عملیات</th>
            </tr>
            @foreach($documents as $item)
                <tr>
                    <td>
                        @if($item->user)
                        <span>{{$item->user->name}}</span>
                        @endif
                    </td>
                    <td>
                        <div class="pic">
                            <img src="{{$item->frontNaturalId}}">
                        </div>
                    </td>
                    <td>
                        <div class="pic">
                            <img src="{{$item->backNaturalId}}">
                        </div>
                    </td>
                    <td>
                        @if($item->status == 0)
                            <span>در حال بررسی</span>
                        @endif
                        @if($item->status == 1)
                            <span>رد شده</span>
                        @endif
                        @if($item->status == 2)
                            <span>تایید شده</span>
                        @endif
                    </td>
                    <td>
                        <span>{{$item->created_at}}</span>
                    </td>
                    <td>
                        <div class="buttons">
                            <a href="/admin/document/{{$item->id}}/edit">ویرایش</a>
                            <button id="{{$item->id}}" class="deleteButton">حذف</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $documents->links('admin.paginate') }}
        <div class="popUp">
            <div class="popUpItem">
                <div class="title">آیا از حذف مدرک مطمئن هستید؟</div>
                <p>با حذف مدرک اطلاعات مدرک به طور کامل حذف میشوند</p>
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
                $('.buttonsPop form').attr('action' , '/admin/document/' + post+'/delete');
            })
        })
    </script>
@endsection
