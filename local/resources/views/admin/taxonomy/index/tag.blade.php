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
                <a href="/admin/tag">برچسب</a>
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
                    <form method="GET" action="/admin/tag" class="filterContent">
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
                        <th>عملیات</th>
                    </tr>
                    @foreach($tags as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>
                                <div class="buttons">
                                    <a href="/admin/tag/{{$item->id}}/show">آمارگیری</a>
                                    <button id="{{$item->id}}" class="editButton">ویرایش</button>
                                    <button id="{{$item->id}}" class="deleteButton">حذف</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $tags->links('admin.paginate') }}
            </div>
            <div>
                <form action="/admin/tag" class="createFilled" method="post">
                    @csrf
                    <div class="filledItem">
                        <label>عنوان*</label>
                        <input type="text" name="name" placeholder="عنوان را وارد کنید">
                        @error('name')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="allCreatePostDetailItem">
                        <label>زبان* :</label>
                        <select name="language">
                            <option value="fa" selected>فارسی</option>
                            <option value="en">انگلیسی</option>
                            <option value="ar">عربی</option>
                            <option value="tr">ترکی</option>
                        </select>
                        <div id="validation-language"></div>
                    </div>
                    <div class="filledItem">
                        <label>پیوند</label>
                        <input type="text" name="slug" placeholder="پیوند را وارد کنید">
                    </div>
                    <div class="filledItem">
                        <label>توضیحات</label>
                        <textarea name="body" placeholder="توضیحات را وارد کنید"></textarea>
                        @error('body')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>عنوان سئو</label>
                        <input type="text" name="nameSeo" placeholder="عنوان را وارد کنید">
                        @error('nameSeo')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>کلمات کلیدی</label>
                        <input name="keyword" placeholder="با , جدا کنید"/>
                        @error('keyword')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>نوع برچسب :</label>
                        <select name="type">
                            <option value="0" selected>محصول</option>
                            <option value="1">بلاگ</option>
                        </select>
                    </div>
                    <div class="filledItem">
                        <label>توضیحات سئو</label>
                        <textarea name="bodySeo" placeholder="توضیحات را وارد کنید"></textarea>
                        @error('bodySeo')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="addImageButton">برای افزودن تصویر کلیک کنید</div>
                    <div class="sendGallery">
                        <div class="getImageItem">
                            <span id="imageTooltip">تصاویر خود را وارد کنید</span>
                        </div>
                    </div>
                    <div class="buttonForm">
                        <button type="submit">ثبت اطلاعات</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="popUp" style="display:none;">
            <div class="popUpItem">
                <div class="title">آیا از حذف دسته بندی مطمئن هستید؟</div>
                <p>با حذف دسته بندی اطلاعات دسته بندی به طور کامل حذف میشوند</p>
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
            $('.filemanager').hide();
            $('.filterContent').hide();
            $("textarea[name='body']").ckeditor();
            $('.filterTitle').click(function(){
                $('.filterContent').toggle();
            })
            $('.addImageButton').click(function(){
                $('.filemanager').show();
            });
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
                $('.buttonsPop form').attr('action' , '/admin/tag/' + post+'/delete');
            })
            $('.buttons').on('click' , '.editButton' ,function(){
                window.scrollTo(0,0);
                post = this.id;
                var form = {
                    "_token": "{{ csrf_token() }}",
                    tag:post,
                };
                $.ajax({
                    url: "/admin/tag/" + post + "/edit",
                    type: "get",
                    data: form,
                    success: function (data) {
                        $('.createFilled').attr('action' , '/admin/tag/' + post+'/edit');
                        $(".createFilled input[name='_method']").remove();
                        $('.createFilled').append(
                            $('@method('put')')
                        )
                        $('.buttonForm h4').remove();
                        $('.buttonForm').append(
                            $('<h4>لغو</h4>').on('click',function(ss){
                                post = 0;
                                $('.createFilled').attr('action' , '/admin/tag/');
                                $(".createFilled input[name='_method']").remove();
                                $(this).hide();
                                $("input[name='name']").val('');
                                $("input[name='slug']").val('');
                                $("input[name='nameSeo']").val('');
                                $("input[name='keyword']").val('');
                                $("textarea[name='body']").val('');
                                $("textarea[name='bodySeo']").val('');
                                $("input[name='image']").val('');
                                $("select[name='type']").val(0);
                                $('.getImageItem .getImagePic').remove()
                            })
                        )
                        $("input[name='name']").val(data.name);
                        $("input[name='slug']").val(data.slug);
                        $("input[name='nameSeo']").val(data.nameSeo);
                        $("input[name='keyword']").val(data.keyword);
                        $("textarea[name='body']").val(data.body);
                        $("textarea[name='bodySeo']").val(data.bodySeo);
                        $("select[name='type']").val(data.type);
                        $("select[name='language']").val(data.language);
                        $('.getImageItem').append(
                            $('<div class="getImagePic"><input type="hidden" name="image" value="'+data.image+'"><i><svg class="deleteImg"><use xlink:href="#trash"></use></svg></i><img src="'+data.image+'"></div>')
                                .on('click' , '.deleteImg',function(ss){
                                    ss.currentTarget.parentElement.parentElement.remove();
                                })
                        );
                        $("input[name='image']").val(data.image);
                    },
                });
            })
        })
    </script>
@endsection

@section('jsScript')
    <script src="/js/select2.min.js"></script>
    <script src="/js/editor/ckeditor.js"></script>
    <script src="/js/editor/adapters/jquery.js"></script>
@endsection

@section('links')
    <link rel="stylesheet" href="/css/select2.min.css"/>
@endsection
