@extends('admin.master')

@section('tab',1)
@section('content')
    <div class="allProduct">
        <div class="topProductIndex">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/product">همه محصول ها</a>
            </div>
            <div class="allTopTableItem">
                <div class="groupDelete">حذف گروهی</div>
                <div class="filterItems">
                    <div class="filterTitle">
                        <i>
                            <svg class="icon">
                                <use xlink:href="#filter"></use>
                            </svg>
                        </i>
                        فیلتر اطلاعات
                    </div>
                    <form method="GET" action="/admin/product" class="filterContent" style="display: none">
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
        <div class="productItems">
            @foreach($products as $item)
                <div id="{{$item->id}}" class="postItem newTr">
                    <div class="postTop">
                        <div class="postTitle">
                            <div class="postImages">
                                @foreach(json_decode($item->image) as $image)
                                    @if($loop->index <= 1)
                                        <div class="postImage">
                                            <img src="{{$image}}" alt="{{$item->title}}">
                                        </div>
                                    @endif
                                    @if($loop->index == 2)
                                        <div class="postMore">
                                            <i>
                                                <svg class="icon">
                                                    <use xlink:href="#more"></use>
                                                </svg>
                                            </i>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <ul class="alerts">
                                <li>
                                    <span>عنوان :</span>
                                    <span>{{$item->title}}</span>
                                </li>
                                <li>
                                    <span>کد محصول :</span>
                                    <span>{{$item->product_id}}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="postOptions grid3">
                            <a href="/admin/product/{{$item->id}}/show" target="_blank" title="آمارگیری محصول">آمارگیری</a>
                            <a href="/product/{{$item->slug}}" target="_blank" title="پیشنمایش محصول">پیشنمایش</a>
                            <a href="/admin/product/{{$item->id}}/edit" target="_blank" title="ویرایش محصول">ویرایش</a>
                            <a href="/admin/product/{{$item->id}}/copy" target="_blank" title="کپی محصول">کپی</a>
                            <button title="حذف محصول" class="deletePay" id="{{$item->id}}">حذف</button>
                        </div>
                    </div>
                    <div class="postBot">
                        <ul>
                            <li>
                                <span>غرفه دار :</span>
                                @if($item->user)
                                    <span class="active">{{$item->user->name}}</span>
                                @endif
                            </li>
                            <li>
                                <span>آیدی محصول :</span>
                                <span>{{$item->id}}</span>
                            </li>
                            <li>
                                <span>موجودی :</span>
                                <span>{{$item->count}}</span>
                            </li>
                            <li>
                                <span>قیمت :</span>
                                <span>{{number_format($item->price)}} تومان</span>
                            </li>
                            <li>
                                <span>تخفیف :</span>
                                @if($item->off >= 1)
                                <span>%{{$item->off}}</span>
                                @else
                                    <span>-</span>
                                @endif
                            </li>
                            <li>
                                <span>دسته بندی :</span>
                                @if(count($item->category) >= 1)
                                    <span>{{$item->category()->pluck('name')->first()}}</span>
                                @endif
                            </li>
                            <li>
                                <span>زمان ثبت :</span>
                                <span>{{$item->created_at}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach
            {{ $products->links('admin.paginate') }}
        </div>
        <div class="popUp" style="display:none;">
            <div class="popUpItem">
                <div class="title">آیا از حذف محصول مطمئن هستید؟</div>
                <p>با حذف محصول اطلاعات محصول به طور کامل حذف میشوند</p>
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
            var checked = 0;
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
            $('.allGroupEdit .groupEditPanel .titleGroupEdit i').click(function(){
                $('.allGroupEdit').hide();
                $.each($(".allGroupEdit .groupEditItems") , function(){
                    $(this).remove();
                })
            });
            $(".productItems .newTr").on('click',function(){
                if($(this).attr('class') == 'postItem newTr checked'){
                    $(this).attr('class' , 'postItem newTr');
                    checked = parseInt(checked) - 1;
                    if(checked == 0){
                        $('.groupEdits').hide();
                        $('.groupDelete').hide();
                    }
                }else{
                    $(this).attr('class' , 'postItem newTr checked');
                    checked = parseInt(checked) + 1;
                    $('.groupEdits').show();
                    $('.groupDelete').show();
                }
            })
            $('.groupDelete').on('click' , function(){
                Swal.fire({
                    title: 'از حذف گروهی محصولات مطمئن هستید؟',
                    text: "امکان بازگشت محصولات وجود ندارد",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'حذف محصولات',
                    cancelButtonText: 'انصراف',
                    confirmButtonColor: '#30d633',
                    cancelButtonColor: '#d33',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        var products = [];
                        $.each($('.productItems .checked'),function(){
                            products.push($(this).attr('id'));
                        })
                        var form = {
                            "_token": "{{ csrf_token() }}",
                            products:JSON.stringify(products),
                        };
                        $.ajax({
                            type:'POST',
                            url: `/admin/product/delete`,
                            data: form,
                            success: (response) => {
                                $(".productItems .checked").remove();
                            },
                        });
                    } else {
                        result.dismiss == Swal.DismissReason.cancel
                    }
                })
            });
            $('.productItems .postOptions').on('click' , 'button' ,function(){
                post = this.id;
                $('.popUp').show();
                $('.buttonsPop form').attr('action' , '/admin/product/' + post+'/delete');
            })
        })
    </script>
@endsection

@section('links')
    <script src="/js/sweetalert.min.js"></script>
@endsection
