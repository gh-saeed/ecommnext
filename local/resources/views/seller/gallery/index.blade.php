@extends('seller.master')

@section('tab',1)
@section('content')
    <div class="allGallery">
        <div class="topGalleryPanel">
            <div class="right">
                <a href="/seller">{{__('messages.dashboard')}}</a>
                <span>/</span>
                <a href="/seller/gallery">{{__('messages.gallery')}}</a>
            </div>
        </div>
        <div class="allGalleryPanelFiles">
            <div class="allGalleryDrop">
                <form method="post" id="upload-image-form" enctype="multipart/form-data">
                    @csrf
                    <div class="sendImage">
                        <input type="file" id="post_cover" class="dropify" name="image"/>
                    </div>
                    <button type="submit" id="upload-image">{{__('messages.upload')}}</button>
                </form>
            </div>
            <div class="chartGalleries">
                <a href="/seller/gallery/?container=0" class="chartItem">
                    <h3>{{__('messages.recently')}}</h3>
                    <h4>{{$count1}} {{__('messages.file')}}</h4>
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
                <a href="/seller/gallery/?container=1" class="chartItem">
                    <h3>{{__('messages.pictures')}}</h3>
                    <h4>{{$count2}} {{__('messages.picture')}}</h4>
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
                <a href="/seller/gallery/?container=2" class="chartItem">
                    <h3>{{__('messages.files')}}</h3>
                    <h4>{{$count3}} {{__('messages.file')}}</h4>
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
                <a href="/seller/gallery/?container=3" class="chartItem">
                    <h3>{{__('messages.videos')}}</h3>
                    <h4>{{$count4}} {{__('messages.video')}}</h4>
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
                            <span>{{__('messages.file_path')}} :</span>
                            <h4>{{$item->path}}</h4>
                        </div>
                        <div class="imageDataOverCats">
                            <svg class="icon">
                                <use xlink:href="#url"></use>
                            </svg>
                            <span>{{__('messages.file_address')}} :</span>
                            <h4>{{$item->url}}</h4>
                        </div>
                        <div class="imageDataOverCats">
                            <svg class="icon">
                                <use xlink:href="#type"></use>
                            </svg>
                            <span>{{__('messages.file_type')}} :</span>
                            <h4>{{$item->type}}</h4>
                        </div>
                    </div>
                    <div class="imageDataOver2">
                        <div class="imageDataOver2Items">
                            <div class="imageDataOver2Item">
                                <input type="hidden" value="{{$item->url}}" id="{{$item->id}}">
                                <i title="{{__('messages.copy_address')}}" onclick="copyToClipboard('#' + {{$item->id}})">
                                    <svg class="icon">
                                        <use xlink:href="#edit"></use>
                                    </svg>
                                </i>
                                <i title="{{__('messages.delete')}}" class="deletePost" id="{{$item->id}}">
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
        <div class="popUp">
            <div class="popUpItem">
                <div class="title">{{__('messages.gallery1')}}</div>
                <p>{{__('messages.gallery2')}}</p>
                <div class="buttonsPop">
                    <form method="POST" action="" id="deletePost">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit">{{__('messages.deleted')}}</button>
                    </form>
                    <button id="cancelDelete">{{__('messages.cancel1')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts4')
    <script>
        var success2 = {!! json_encode(__('messages.success'), JSON_HEX_TAG) !!};
        var copy_address = {!! json_encode(__('messages.copy_address'), JSON_HEX_TAG) !!};
        var seller_front2 = {!! json_encode(__('messages.seller_front2'), JSON_HEX_TAG) !!};
        var delete_pic = {!! json_encode(__('messages.delete_pic'), JSON_HEX_TAG) !!};
        var delete_pic2 = {!! json_encode(__('messages.delete_pic2'), JSON_HEX_TAG) !!};
        var delete_pic3 = {!! json_encode(__('messages.delete_pic3'), JSON_HEX_TAG) !!};
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).val()).select();
            document.execCommand("copy");
            $temp.remove();
            $.toast({
                text: copy_address, // Text that is to be shown in the toast
                heading: success2, // Optional heading to be shown on the toast
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

                $.ajax({
                    type:'POST',
                    url: `/seller/upload-image`,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        if (response) {
                            window.location.reload();
                        }
                    },
                    error: function(response){
                        $('#image-input-error').text(response.responseJSON.errors.file);
                    }
                });
            });

            $('.dropify').dropify({
                messages: {
                    default: delete_pic3,
                    replace: seller_front2,
                    remove: delete_pic,
                    error: delete_pic2,
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
                $('.buttonsPop form').attr('action' , '/seller/gallery/' + post+'/delete');
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
