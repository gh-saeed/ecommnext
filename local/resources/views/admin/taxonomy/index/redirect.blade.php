@extends('admin.master')

@section('tab',2)
@section('content')
    <div class="allBrandPanel">
        <div class="topBrandPanel">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a>تاکسونامی</a>
                <span>/</span>
                <a href="/admin/redirect">ریدایرکت</a>
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
                        <th>آیدی</th>
                        <th>قدیم</th>
                        <th>جدید</th>
                        <th>عملیات</th>
                    </tr>
                    @foreach($redirects as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->start}}</td>
                            <td>{{$item->end}}</td>
                            <td>
                                <div class="buttons">
                                    <button id="{{$item->id}}" class="editButton">ویرایش</button>
                                    <button id="{{$item->id}}" class="deleteButton">حذف</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $redirects->links('admin.paginate') }}
            </div>
            <div>
                <form action="/admin/redirect" class="createFilled" method="post">
                    @csrf
                    <div class="filledItem">
                        <label>ادرس قدیم</label>
                        <input type="text" name="start" placeholder="ادرس را وارد کنید">
                    </div>
                    <div class="filledItem">
                        <label>ادرس جدید</label>
                        <input type="text" name="end" placeholder="ادرس را وارد کنید">
                    </div>
                    <div class="filledItem">
                        <label>نوع انتقال</label>
                        <select name="type">
                            <option value="0">بدون وضعیت</option>
                            <option value="301">301</option>
                            <option value="302">302</option>
                            <option value="303">303</option>
                            <option value="403">403</option>
                            <option value="410">410</option>
                            <option value="503">503</option>
                        </select>
                    </div>
                    <div class="buttonForm">
                        <button type="submit">ثبت اطلاعات</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="popUp" style="display:none;">
            <div class="popUpItem">
                <div class="title">آیا از حذف ریدایرکت مطمئن هستید؟</div>
                <p>با حذف ریدایرکت اطلاعات ریدایرکت به طور کامل حذف میشوند</p>
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
    <div class="filemanager">
        @include('admin.filemanager')
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
                $('.buttonsPop form').attr('action' , '/admin/redirect/' + post+'/delete');
            })
            $('.buttons').on('click' , '.editButton' ,function(){
                window.scrollTo(0,0);
                post = this.id;
                var form = {
                    "_token": "{{ csrf_token() }}",
                    redirect:post,
                };
                $.ajax({
                    url: "/admin/redirect/" + post + "/edit",
                    type: "get",
                    data: form,
                    success: function (data) {
                        $('.createFilled').attr('action' , '/admin/redirect/' + post+'/edit');
                        $(".createFilled input[name='_method']").remove();
                        $('.createFilled').append(
                            $('@method('put')')
                        )
                        $('.buttonForm h4').remove();
                        $('.buttonForm').append(
                            $('<h4>لغو</h4>').on('click',function(ss){
                                post = 0;
                                $('.createFilled').attr('action' , '/admin/redirect/');
                                $(".createFilled input[name='_method']").remove();
                                $(this).hide();
                                $("input[name='start']").val('');
                                $("input[name='end']").val('');
                                $("select[name='type']").val('');
                            })
                        )
                        $("input[name='start']").val(data.start);
                        $("input[name='end']").val(data.end);
                        $("select[name='type']").val(data.type);
                    },
                });
            })
        })
    </script>
@endsection
