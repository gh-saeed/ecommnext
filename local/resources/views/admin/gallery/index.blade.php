@extends('admin.master')

@section('tab',11)
@section('content')
    <div class="allGallery">
        <div class="topGalleryPanel">
            <div class="right">
                <a href="/admin">داشبورد</a>
                <span>/</span>
                <a href="/admin/gallery">گالری و رسانه</a>
            </div>
        </div>
        <div class="allGalleryPanelFiles">
            <div class="allGalleryDrop">
                <form method="post" id="upload-image-form" enctype="multipart/form-data">
                    @csrf
                    <div class="sendImage">
                        <input type="file" id="post_cover" class="dropify" name="image"/>
                    </div>
                    <button type="submit" id="upload-image">آپلود</button>
                </form>
            </div>
            <div class="chartGalleries">
                <a href="/admin/gallery/?container=0" class="chartItem">
                    <h3>اخیرا</h3>
                    <h4>{{$count1}} فایل</h4>
                    <div class="circles">
                        @if($percent1 >= 60)
                            <div class="circle full">
                                <span>{{$percent1}}%</span>
                                <div class="drown" style="top:{{100-$percent1}}%"></div>
                            </div>
                        @endif
                        @if($percent1 <= 59 && $percent1 >= 30)
                        <div class="circle half">
                            <span>{{$percent1}}%</span>
                            <div class="drown" style="top:{{100-$percent1}}%"></div>
                        </div>
                        @endif
                        @if($percent1 <= 29)
                        <div class="circle empty">
                            <span>{{$percent1}}%</span>
                            <div class="drown" style="top:{{100-$percent1}}%"></div>
                        </div>
                        @endif
                    </div>
                </a>
                <a href="/admin/gallery/?container=1" class="chartItem">
                    <h3>تصاویر</h3>
                    <h4>{{$count2}} تصویر</h4>
                    <div class="circles">
                        @if($percent2 >= 60)
                            <div class="circle full">
                                <span>{{$percent2}}%</span>
                                <div class="drown" style="top:{{100-$percent2}}%"></div>
                            </div>
                        @endif
                        @if($percent2 <= 59 && $percent2 >= 30)
                            <div class="circle half">
                                <span>{{$percent2}}%</span>
                                <div class="drown" style="top:{{100-$percent2}}%"></div>
                            </div>
                        @endif
                        @if($percent2 <= 29)
                            <div class="circle empty">
                                <span>{{$percent2}}%</span>
                                <div class="drown" style="top:{{100-$percent2}}%"></div>
                            </div>
                        @endif
                    </div>
                </a>
                <a href="/admin/gallery/?container=2" class="chartItem">
                    <h3>فایل ها</h3>
                    <h4>{{$count3}} فایل</h4>
                    <div class="circles">
                        @if($percent3 >= 60)
                            <div class="circle full">
                                <span>{{$percent3}}%</span>
                                <div class="drown" style="top:{{100-$percent3}}%"></div>
                            </div>
                        @endif
                        @if($percent3 <= 59 && $percent3 >= 30)
                            <div class="circle half">
                                <span>{{$percent3}}%</span>
                                <div class="drown" style="top:{{100-$percent3}}%"></div>
                            </div>
                        @endif
                        @if($percent3 <= 29)
                            <div class="circle empty">
                                <span>{{$percent3}}%</span>
                                <div class="drown" style="top:{{100-$percent3}}%"></div>
                            </div>
                        @endif
                    </div>
                </a>
                <a href="/admin/gallery/?container=3" class="chartItem">
                    <h3>ویدیو ها</h3>
                    <h4>{{$count4}} ویدیو</h4>
                    <div class="circles">
                        @if($percent4 >= 60)
                            <div class="circle full">
                                <span>{{$percent4}}%</span>
                                <div class="drown" style="top:{{100-$percent4}}%"></div>
                            </div>
                        @endif
                        @if($percent4 <= 59 && $percent4 >= 30)
                            <div class="circle half">
                                <span>{{$percent4}}%</span>
                                <div class="drown" style="top:{{100-$percent4}}%"></div>
                            </div>
                        @endif
                        @if($percent4 <= 29)
                            <div class="circle empty">
                                <span>{{$percent4}}%</span>
                                <div class="drown" style="top:{{100-$percent4}}%"></div>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
            <ul>
                @foreach($galleries as $item)
                <li>
                    <div class="itemsPic">
                        @if($item->type == 'mp3' || $item->type == 'mkv')
                            <img src="/img/music.png" alt="">
                        @endif
                        @if($item->type == 'zip' || $item->type == 'rar')
                            <img src="/img/zip.ico" alt="">
                        @endif
                        @if($item->type != 'mp3' && $item->type != 'mkv' && $item->type != 'mp3' && $item->type != 'mkv')
                            <img src="{{$item->url}}" alt="">
                        @endif
                    </div>
                    <h3>
                        {{$item->name}}
                    </h3>
                    <span>{{$item->size}}</span>
                    <div class="imageDataOver">
                        <h3>{{$item->name}}</h3>
                        <div class="imageDataOverOption">
                            <div class="imageDataOverOptionItem">
                                <svg class="icon">
                                    <use xlink:href="#recently"></use>
                                </svg>
                                <span>{{$item->created_at}}</span>
                            </div>
                            <div class="imageDataOverOptionItem">
                                <svg class="icon">
                                    <use xlink:href="#size"></use>
                                </svg>
                                <span>{{$item->size}}</span>
                            </div>
                        </div>
                        <div class="imageDataOverCats">
                            <svg class="icon">
                                <use xlink:href="#path"></use>
                            </svg>
                            <span>مسیر فایل :</span>
                            <h4>{{$item->path}}</h4>
                        </div>
                        <div class="imageDataOverCats">
                            <svg class="icon">
                                <use xlink:href="#url"></use>
                            </svg>
                            <span>آدرس فایل :</span>
                            <h4>{{$item->url}}</h4>
                        </div>
                        <div class="imageDataOverCats">
                            <svg class="icon">
                                <use xlink:href="#type"></use>
                            </svg>
                            <span>نوع فایل :</span>
                            <h4>{{$item->type}}</h4>
                        </div>
                    </div>
                    <div class="imageDataOver2">
                        <div class="imageDataOver2Items">
                            <div class="imageDataOver2Item">
                                <input type="hidden" value="{{$item->url}}" id="{{$item->id}}">
                                <i title="کپی آدرس" onclick="copyToClipboard('#' + {{$item->id}})">
                                    <svg class="icon">
                                        <use xlink:href="#edit"></use>
                                    </svg>
                                </i>
                                <i title="حذف" class="deletePost" id="{{$item->id}}">
                                    <svg class="icon">
                                        <use xlink:href="#trash"></use>
                                    </svg>
                                </i>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            {{ $galleries->links('admin.paginate') }}
        </div>
        <div class="popUp" style="display:none;">
            <div class="popUpItem">
                <div class="title">آیا از حذف تصویر مطمئن هستید؟</div>
                <p>با حذف تصویر اطلاعات محصول به طور کامل حذف میشوند</p>
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

@section('scripts4')
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).val()).select();
            document.execCommand("copy");
            $temp.remove();
            $.toast({
                text: "آدرس کپی شد", // Text that is to be shown in the toast
                heading: 'موفقیت آمیز', // Optional heading to be shown on the toast
                icon: 'success', // Type of toast icon
                showHideTransition: 'fade', // fade, slide or plain
                allowToastClose: true, // Boolean value true or false
                hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                textAlign: 'left',  // Text alignment i.e. left, right or center
                loader: true,  // Whether to show loader or not. True by default
                loaderBg: '#9EC600',  // Background color of the toast loader
            });
        }
        $(document).ready(function(){
            var post = 0;
            $('#upload-image-form').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $('.allGalleryDrop #upload-image').text('صبر کنید ..');
                $.ajax({
                    type:'POST',
                    url: `/admin/upload-image`,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        $('.allGalleryDrop #upload-image').text('آپلود');
                        window.location.reload();
                    },
                    error: function(response){
                        $('.allGalleryDrop #upload-image').text('آپلود');
                        $('#image-input-error').text(response.responseJSON.errors.file);
                    }
                });
            });

            $('.dropify').dropify({
                messages: {
                    default: "بکشید و رها کنید یا برای انتخاب کلیک کنید.",
                    replace: "برای جایگزین کردن تصویر بکشید و رها کنید.",
                    remove: "حذف تصویر",
                    error: "خطایی به وجود آمده است. دوباره تلاش کنید.",
                }
            });

            $('.popUp').hide();
            $('#cancelDelete').click(function(){
                $('.popUp').hide();
                post = 0;
            })
            $('#deletePost').click(function(){
                $('.popUp').hide();
            });
            $('ul li').on('click' , '.deletePost' ,function(){
                post = this.id;
                $('.popUp').show();
                $('.buttonsPop form').attr('action' , '/admin/gallery/' + post+'/delete');
            })
        })
    </script>
@endsection

@section('links2')
    <link rel="stylesheet" href="/css/dropify.min.css"/>
    <link rel="stylesheet" href="/css/jquery.toast.min.css"/>
@endsection

@section('jsScript2')
    <script src="/js/jquery.toast.min.js"></script>
    <script src="/js/dropify.min.js"></script>
@endsection
