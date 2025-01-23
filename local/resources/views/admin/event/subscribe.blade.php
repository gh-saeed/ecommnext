@extends('admin.master')

@section('tab' , 6)
@section('content')
    <div class="allNote">
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <div class="allTables">
            <div>
                <table>
                    <tr style="grid-template-columns: 1fr 8rem 8rem;">
                        <th>ایمیل</th>
                        <th>زمان ثبت</th>
                        <th>عملیات</th>
                    </tr>
                    @foreach($sub as $item)
                        <tr style="grid-template-columns: 1fr 8rem 8rem;">
                            <td>{{$item->name}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>
                                <div class="buttons">
                                    <button id="{{$item->id}}" class="deleteButton">حذف</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $sub->links('admin.paginate') }}
            </div>
            <div>
                <form action="/admin/subscribe" class="createFilled" method="post">
                    @csrf
                    <div class="filledItem">
                        <label>ایمیل :*</label>
                        <input type="text" name="email" placeholder="ایمیل را وارد کنید">
                        @error('email')
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
                <div class="title">آیا از حذف ایمیل مطمئن هستید؟</div>
                <p>با حذف ایمیل اطلاعات ایمیل به طور کامل حذف میشوند</p>
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
            $('#deletePost').click(function(){
                $('.popUp').hide();
            });
            $('.buttons').on('click' , '.deleteButton' ,function(){
                post = this.id;
                $('.popUp').show();
                $('.buttonsPop form').attr('action' , '/admin/subscribe/' + post+'/delete');
            })
        })
    </script>
@endsection
