<div class="allProfileLists">
    <div class="showFilter">باز شدن لیست داشبورد</div>
    <div class="allProfileList">
        <div class="showFilter">بستن لیست داشبورد</div>
        <div class="allUserIndexList">
            <div class="allUserIndexListsUser">
                <div class="allUserIndexListsUserPic">
                    <div class="pic">
                        <img src="{{auth()->user()->profile??'/img/user.png'}}" alt="{{auth()->user()->name}}">
                    </div>
                </div>
                <div class="allUserIndexListsUserItem">
                    <div class="allUserIndexListsUserName">{{ auth()->user()->name }}</div>
                </div>
                <h4> {{__('messages.identification_code')}} : {{auth()->user()->referral}}</h4>
            </div>
            <div class="allUserIndexListItems">
                <a href="/profile/personal-info">{{__('messages.user_edit')}}</a>
                <a href="/logout">{{__('messages.exit_user')}}</a>
            </div>
        </div>
        <div class="walletData">
            <i>
                <svg class="icon">
                    <use xlink:href="#wallet"></use>
                </svg>
            </i>
            <h3>{{number_format(auth()->user()->myCharge())}} <span>تومان</span></h3>
            <a href="/charge">افزایش کیف پول</a>
        </div>
        @if(\App\Models\Setting::where('key' , 'sellerStatus')->pluck('value')->first())
            @if(auth()->user()->seller != 0)
                <a class="becomeList" href="/seller/dashboard">
                    <h4>
                        <i>
                            <svg class="icon">
                                <use xlink:href="#shop"></use>
                            </svg>
                        </i>
                        {{__('messages.seller_panel')}}
                    </h4>
                </a>
            @else
                <a class="becomeList" href="/become-seller">
                    <h4>
                        <i>
                            <svg class="icon">
                                <use xlink:href="#seller"></use>
                            </svg>
                        </i>
                        {{__('messages.seller')}}
                    </h4>
                    <div class="pic"></div>
                </a>
            @endif
        @endif
        <div class="allUserIndexListsItems">
            <div class="allUserIndexListsItem">
                <a href="/profile">{{__('messages.dashboard')}}</a>
                @if($tab == 0)
                    <i>
                        <svg class="icon">
                            <use xlink:href="#left"></use>
                        </svg>
                    </i>
                @endif
            </div>
            <div class="allUserIndexListsItem">
                <a href="/profile/pay">{{__('messages.order_user')}}</a>
                @if($tab == 1)
                    <i>
                        <svg class="icon">
                            <use xlink:href="#left"></use>
                        </svg>
                    </i>
                @endif
            </div>
            <div class="allUserIndexListsItem">
                <a href="/profile/like">{{__('messages.like_user')}}</a>
                @if($tab == 2)
                    <i>
                        <svg class="icon">
                            <use xlink:href="#left"></use>
                        </svg>
                    </i>
                @endif
            </div>
            <div class="allUserIndexListsItem">
                <a href="/profile/comment">نظرات</a>
                @if($tab == 4)
                    <i>
                        <svg class="icon">
                            <use xlink:href="#left"></use>
                        </svg>
                    </i>
                @endif
            </div>
            <div class="allUserIndexListsItem">
                <a href="/profile/ticket">درخواست ها</a>
                @if($tab == 5)
                    <i>
                        <svg class="icon">
                            <use xlink:href="#left"></use>
                        </svg>
                    </i>
                @endif
            </div>
            <div class="allUserIndexListsItem">
                <a href="/profile/chat">گفتگو ها</a>
                @if($tab == 7)
                    <i>
                        <svg class="icon">
                            <use xlink:href="#left"></use>
                        </svg>
                    </i>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".showFilter").click(function (){
            $(".allProfileList").toggle()
        })
    })
</script>
