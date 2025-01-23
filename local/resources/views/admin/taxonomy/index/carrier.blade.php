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
                <a href="/admin/carrier">حامل</a>
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
                    <form method="GET" action="/admin/carrier" class="filterContent">
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
        <div class="allTables">
            <div>
                <table>
                    <tr>
                        <th>آیدی</th>
                        <th>عنوان</th>
                        <th>غرفه دار</th>
                        <th>عملیات</th>
                    </tr>
                    @foreach($carriers as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->user?$item->user->name:'-'}}</td>
                            <td>
                                <div class="buttons">
                                    <button id="{{$item->id}}" class="editButton">ویرایش</button>
                                    <button id="{{$item->id}}" class="deleteButton">حذف</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $carriers->links('admin.paginate') }}
            </div>
            <div>
                <form action="/admin/carrier" class="createFilled" method="post">
                    @csrf
                    <div class="filledItem">
                        <label>عنوان*</label>
                        <input type="text" name="name" placeholder="عنوان را وارد کنید">
                        @error('name')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>غرفه دار* :</label>
                        <select name="user_id">
                            @foreach($users as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <div id="validation-language"></div>
                    </div>
                    <div class="filledItem">
                        <label>قیمت*</label>
                        <input type="text" name="price" placeholder="مبلغ را وارد کنید">
                        @error('price')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>بیشتر از این مبلغ حامل رایگان است*</label>
                        <input type="text" name="limit" placeholder="مبلغ را وارد کنید">
                        @error('limit')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>اضافه شدن هزینه به ازای هر کیلو*</label>
                        <input type="text" name="weightPrice" placeholder="مثال : 2000">
                        @error('weightPrice')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>حداکثر وزنی که میتوان حمل کرد(کیلو)*</label>
                        <input type="text" name="weight" placeholder="مثال : 5">
                        @error('weight')
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
                <div class="title">آیا از حذف حامل مطمئن هستید؟</div>
                <p>با حذف حامل اطلاعات حامل به طور کامل حذف میشوند</p>
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
            $('#addRate').click(function (){
                $('#rates').append(
                    $('<tr><td><input type="text" name="city[]" value="" placeholder="شهر را وارد کنید"></td><td><input type="text" name="price2[]" value="" placeholder="قیمت را وارد کنید"></td><td><i id="deleteRate"><svg class="icon"><use xlink:href="#trash"></use></svg></i></td></tr>')
                        .on('click' , '#deleteRate',function(ss){
                            ss.currentTarget.parentElement.parentElement.remove();
                        })
                );
            })
            $('.buttons').on('click' , '.deleteButton' ,function(){
                post = this.id;
                $('.popUp').show();
                $('.buttonsPop form').attr('action' , '/admin/carrier/' + post+'/delete');
            })
            $('.buttons').on('click' , '.editButton' ,function(){
                window.scrollTo(0,0);
                post = this.id;
                $('#rates tr').remove();
                var form = {
                    "_token": "{{ csrf_token() }}",
                    carrier:post,
                };
                $.ajax({
                    url: "/admin/carrier/" + post + "/edit",
                    type: "get",
                    data: form,
                    success: function (data) {
                        $('.createFilled').attr('action' , '/admin/carrier/' + post+'/edit');
                        $(".createFilled input[name='_method']").remove();
                        $('.createFilled').append(
                            $('@method('put')')
                        )
                        $('.buttonForm h4').remove();
                        $('.buttonForm').append(
                            $('<h4>لغو</h4>').on('click',function(ss){
                                post = 0;
                                $('.createFilled').attr('action' , '/admin/carrier/');
                                $(".createFilled input[name='_method']").remove();
                                $(this).hide();
                                $("input[name='name']").val('');
                                $("input[name='price']").val('');
                                $("input[name='weightPrice']").val('');
                                $("input[name='weight']").val('');
                                $("input[name='limit']").val('');
                                $("select[name='user_id']").val('');
                            })
                        )
                        $("input[name='name']").val(data.name);
                        $("input[name='limit']").val(data.limit);
                        $("input[name='price']").val(data.price);
                        $("input[name='weightPrice']").val(data.weightPrice);
                        $("input[name='weight']").val(data.weight);
                        $("select[name='user_id']").val(data.user_id);
                    },
                });
            })
        })
    </script>
@endsection
