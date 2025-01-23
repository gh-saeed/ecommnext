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
                <a href="/admin/category">دسته بندی</a>
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
                    <form method="GET" action="/admin/category" class="filterContent">
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
                    @foreach($categories as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>
                                <div class="buttons">
                                    <a href="/admin/category/{{$item->id}}/show">آمارگیری</a>
                                    <button id="{{$item->id}}" class="editButton">ویرایش</button>
                                    <button id="{{$item->id}}" class="deleteButton">حذف</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $categories->links('admin.paginate') }}
            </div>
            <div>
                <form action="/admin/category" class="createFilled" method="post">
                    @csrf
                    <div class="filledItem">
                        <label>عنوان*</label>
                        <input type="text" name="name" placeholder="عنوان را وارد کنید">
                        @error('name')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>پیوند</label>
                        <input type="text" name="slug" placeholder="پیوند را وارد کنید">
                    </div>
                    <div class="filledItem">
                        <label>توضیحات*</label>
                        <textarea name="body" placeholder="توضیحات را وارد کنید"></textarea>
                    </div>
                    <div class="filledItem">
                        <label>عنوان سئو*</label>
                        <input type="text" name="nameSeo" placeholder="عنوان را وارد کنید">
                        @error('nameSeo')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>کلمات کلیدی*</label>
                        <input name="keyword" placeholder="با , جدا کنید"/>
                        @error('keyword')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>توضیحات سئو*</label>
                        <textarea name="bodySeo" placeholder="توضیحات را وارد کنید"></textarea>
                        @error('bodySeo')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>پورسانت*</label>
                        <input name="percent" placeholder="مثال : 10"/>
                        @error('percent')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem">
                        <label>نوع دسته بندی :</label>
                        <select name="type">
                            <option value="0" selected>محصول</option>
                            <option value="1">بلاگ</option>
                            <option value="2">فروشنده</option>
                        </select>
                    </div>
                    <div class="filledItem2">
                        <label>زیر مجموعه های این دسته :</label>
                        <select class="cats-multiple" name="cats[]" multiple="multiple">
                            @foreach ($cats as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filledItem2">
                        <label>دسته های مادر :</label>
                        <select class="mother-multiple" name="mother[]" multiple="multiple">
                            @foreach ($cats as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filledItem2">
                        <label>برند ها :</label>
                        <select class="brands-multiple" name="brands[]" multiple="multiple">
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
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
            $('.cats-multiple').val([]);
            $('.mother-multiple').val([]);
            $('.brands-multiple').val([]);
            $('.cats-multiple').select2({
                placeholder: 'دسته بندی را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $('.mother-multiple').select2({
                placeholder: 'دسته بندی را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $('.brands-multiple').select2({
                placeholder: 'برند را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $('.popUp').hide();
            $('.filemanager').hide();
            $('.filterContent').hide();
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
            $("textarea[name='body']").ckeditor();
            $('.allTables .buttons').on('click' , '.deleteButton' ,function(){
                post = this.id;
                $('.popUp').show();
                $('.buttonsPop form').attr('action' , '/admin/category/' + post+'/delete');
            })
            $('.allTables .buttons').on('click' , '.editButton' ,function(){
                window.scrollTo(0,0);
                post = this.id;
                var form = {
                    "_token": "{{ csrf_token() }}",
                    category:post,
                };
                $.ajax({
                    url: "/admin/category/" + post + "/edit",
                    type: "get",
                    data: form,
                    success: function (data) {
                        $(".getImageItem .getImagePic").remove();
                        $('.createFilled').attr('action' , '/admin/category/' + post+'/edit');
                        $(".createFilled input[name='_method']").remove();
                        $('.createFilled').append(
                            $('@method('put')')
                        )
                        $('.buttonForm h4').remove();
                        $('.buttonForm').append(
                            $('<h4>لغو</h4>').on('click',function(ss){
                                post = 0;
                                $('.createFilled').attr('action' , '/admin/category/');
                                $(".createFilled input[name='_method']").remove();
                                $(this).hide();
                                $("input[name='name']").val('');
                                $("input[name='slug']").val('');
                                $("input[name='nameSeo']").val('');
                                $("input[name='keyword']").val('');
                                $("input[name='percent']").val('');
                                $("textarea[name='body']").val('');
                                $("textarea[name='bodySeo']").val('');
                                $("input[name='image']").val('');
                                $('.cats-multiple').val([]);
                                $("select[name='type']").val(0);
                                $('.getImageItem .getImagePic').remove()
                            })
                        )
                        $("input[name='name']").val(data.name);
                        $("input[name='slug']").val(data.slug);
                        $("input[name='nameSeo']").val(data.nameSeo);
                        $("input[name='keyword']").val(data.keyword);
                        $("input[name='percent']").val(data.percent);
                        $("textarea[name='body']").val(data.body);
                        $("textarea[name='bodySeo']").val(data.bodySeo);
                        $("select[name='type']").val(data.type);
                        var cats2 = []
                        var mother2 = []
                        var brands = []
                        $('.cats-multiple').val(cats2);
                        $('.mother-multiple').val(mother2);
                        $('.brands-multiple').val(brands);
                        $('.cats-multiple').select2({
                            placeholder: 'دسته بندی را انتخاب کنید ...',
                            "language": {
                                "noResults": function(){
                                    return "موردی پیدا نشد";
                                }
                            },
                        });
                        $('.mother-multiple').select2({
                            placeholder: 'دسته بندی را انتخاب کنید ...',
                            "language": {
                                "noResults": function(){
                                    return "موردی پیدا نشد";
                                }
                            },
                        });
                        if(data.cats.length){
                            $.each(data.cats,function(){
                                cats2.push(this.id);
                            });
                            $('.cats-multiple').val(cats2);
                            $('.cats-multiple').select2({
                                placeholder: 'دسته بندی را انتخاب کنید ...',
                                "language": {
                                    "noResults": function(){
                                        return "موردی پیدا نشد";
                                    }
                                },
                            });
                        }
                        if(data.mother.length){
                            $.each(data.mother,function(){
                                mother2.push(this.id);
                            });
                            $('.mother-multiple').val(mother2);
                            $('.mother-multiple').select2({
                                placeholder: 'دسته بندی را انتخاب کنید ...',
                                "language": {
                                    "noResults": function(){
                                        return "موردی پیدا نشد";
                                    }
                                },
                            });
                        }
                        $('.brands-multiple').select2({
                            placeholder: 'برند را انتخاب کنید ...',
                            "language": {
                                "noResults": function(){
                                    return "موردی پیدا نشد";
                                }
                            },
                        });
                        if(data.brands.length){
                            $.each(data.brands,function(){
                                brands.push(this.id);
                            });
                            $('.brands-multiple').val(brands);
                            $('.brands-multiple').select2({
                                placeholder: 'برند را انتخاب کنید ...',
                                "language": {
                                    "noResults": function(){
                                        return "موردی پیدا نشد";
                                    }
                                },
                            });
                        }
                        if(data.image){
                            $('.getImageItem').append(
                                $('<div class="getImagePic"><input type="hidden" name="image" value="'+data.image+'"><i><svg class="deleteImg"><use xlink:href="#trash"></use></svg></i><img src="'+data.image+'"></div>')
                                    .on('click' , '.deleteImg',function(ss){
                                        ss.currentTarget.parentElement.parentElement.remove();
                                    })
                            );
                        }
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
