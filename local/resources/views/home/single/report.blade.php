<div class="allCounseling">
    <form class="counselingFast">
        <div class="title">
            <div class="title2">ثبت گزارش</div>
            <i class="closeCounseling">
                <svg class="icon">
                    <use xlink:href="#cancel"></use>
                </svg>
            </i>
        </div>
        <div class="counselingTitleProduct">{{$name}}</div>
        <div class="counselingFastData">
            <label for="counselingDescription">گزارش :</label>
            <textarea name="counselingDescription" id="counselingDescription" placeholder="گزارش خود را بنویسید"></textarea>
        </div>
        @if(auth()->user())
            <button>ثبت گزارش</button>
        @else
            <a href="/login">ابتدا وارد حساب خود شوید.(کلیک کنید)</a>
        @endif
    </form>
</div>

<script>
    $(document).ready(function(){
        var type1 = {!! json_encode($type, JSON_HEX_TAG) !!};
        var id1 = {!! json_encode($id, JSON_HEX_TAG) !!};
        $(document).on('click',".optionR",function(event){
            event.preventDefault();
            $('.allCounseling').show();
            $('.allCounseling .counselingTitleProduct').text($(this).attr('data'));
        })
        $('.allCounseling .closeCounseling').click(function(){
            $(".counselingFast input[name='counselingDescription']").val('');
        })
        $('.counselingFast button').click(function(event){
            event.preventDefault();
            var buttonCounseling = $(this);
            buttonCounseling.text('صبر کنید.')
            var form = {
                "_token": "{{ csrf_token() }}",
                "body": $(".counselingFast textarea[name='counselingDescription']").val(),
                "product": id1,
                "type": type1,
            };
            $.ajax({
                url: "/send-report",
                type: "post",
                data: form,
                success: function (data) {
                    if(data == 'no'){
                        $.toast({
                            text: 'یک گزارش در حال بررسی وجود دارد.', // Text that is to be shown in the toast
                            heading: 'ناموفق', // Optional heading to be shown on the toast
                            icon: 'error', // Type of toast icon
                            showHideTransition: 'fade', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                            position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#c60000',
                        });
                    }else{
                        $.toast({
                            text: 'گزارش شما در حال بررسی است', // Text that is to be shown in the toast
                            heading: 'موفقیت آمیز', // Optional heading to be shown on the toast
                            icon: 'success', // Type of toast icon
                            showHideTransition: 'fade', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                            position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#9EC600',
                        });
                    }
                    $(".counselingFast textarea[name='counselingDescription']").val('');
                    $('.allCounseling').hide();
                    buttonCounseling.text('ثبت گزارش');
                },
                error: function (xhr) {
                    buttonCounseling.text('ثبت گزارش');
                    $.toast({
                        text: 'فیلد های ستاره دار را پر کنید', // Text that is to be shown in the toast
                        heading: 'ناموفق', // Optional heading to be shown on the toast
                        icon: 'error', // Type of toast icon
                        showHideTransition: 'fade', // fade, slide or plain
                        allowToastClose: true, // Boolean value true or false
                        hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                        stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                        position: 'bottom-left', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                        textAlign: 'left',
                        loader: true,
                        loaderBg: '#c60000',
                    });
                }
            });
        })
    })
</script>
