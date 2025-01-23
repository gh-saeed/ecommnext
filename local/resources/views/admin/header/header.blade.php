<div class="allHeaderPanel" style="background:{{$headerColor}}">
    <div class="right">
        <i class="alignIcon">
            <svg class="icon">
                <use xlink:href="#align"></use>
            </svg>
        </i>
        <a class="noteLeft" href="/admin/user" data_count="کاربران">
            <i>
                <svg class="icon">
                    <use xlink:href="#user"></use>
                </svg>
            </i>
            <span>{{number_format(\App\Models\User::whereBetween('created_at', [verta()->startDay()->formatGregorian('Y-m-d H:i:s'), verta()->endDay()->formatGregorian('Y-m-d H:i:s')])->count())}}</span>
        </a>
        <a class="noteLeft" href="/admin/product" data_count="محصولات">
            <i>
                <svg class="icon">
                    <use xlink:href="#post"></use>
                </svg>
            </i>
            <span>{{number_format(\App\Models\Product::whereBetween('created_at', [verta()->startDay()->formatGregorian('Y-m-d H:i:s'), verta()->endDay()->formatGregorian('Y-m-d H:i:s')])->count())}}</span>
        </a>
        <a class="noteLeft" href="/admin/blog" data_count="بلاگ ها">
            <i>
                <svg class="icon">
                    <use xlink:href="#news"></use>
                </svg>
            </i>
            <span>{{number_format(\App\Models\News::whereBetween('created_at', [verta()->startDay()->formatGregorian('Y-m-d H:i:s'), verta()->endDay()->formatGregorian('Y-m-d H:i:s')])->count())}}</span>
        </a>
        <a class="noteLeft" href="/admin/pay" data_count="سفارشات">
            <i>
                <svg class="icon">
                    <use xlink:href="#pay"></use>
                </svg>
            </i>
            <span>{{number_format(\App\Models\Pay::whereBetween('created_at', [verta()->startDay()->formatGregorian('Y-m-d H:i:s'), verta()->endDay()->formatGregorian('Y-m-d H:i:s')])->count())}}</span>
        </a>
        <a class="noteLeft" href="/admin/ticket" data_count="درخواست ها">
            <i>
                <svg class="icon">
                    <use xlink:href="#ticket2"></use>
                </svg>
            </i>
            <span>{{number_format(\App\Models\Ticket::whereBetween('created_at', [verta()->startDay()->formatGregorian('Y-m-d H:i:s'), verta()->endDay()->formatGregorian('Y-m-d H:i:s')])->count())}}</span>
        </a>
        <a class="noteLeft" href="/admin/comment" data_count="دیدگاه ها">
            <i>
                <svg class="icon">
                    <use xlink:href="#comment2"></use>
                </svg>
            </i>
            <span>{{number_format(\App\Models\Comment::whereBetween('created_at', [verta()->startDay()->formatGregorian('Y-m-d H:i:s'), verta()->endDay()->formatGregorian('Y-m-d H:i:s')])->count())}}</span>
        </a>
    </div>
    <div class="center">
        <span><--- اطلاعات امروز</span>
        <div></div>
        <span>اطلاعات کامل ---></span>
    </div>
    <div class="left">
        <a class="noteLeft" href="/admin/user" data_count="کاربران">
            <i>
                <svg class="icon">
                    <use xlink:href="#user"></use>
                </svg>
            </i>
            <span>{{number_format(\App\Models\User::count())}}</span>
        </a>
        <a class="noteLeft" href="/admin/product" data_count="محصولات">
            <i>
                <svg class="icon">
                    <use xlink:href="#post"></use>
                </svg>
            </i>
            <span>{{number_format(\App\Models\Product::count())}}</span>
        </a>
        <a class="noteLeft" href="/admin/blog" data_count="بلاگ ها">
            <i>
                <svg class="icon">
                    <use xlink:href="#news"></use>
                </svg>
            </i>
            <span>{{number_format(\App\Models\News::count())}}</span>
        </a>
        <a class="noteLeft" href="/admin/pay" data_count="سفارشات">
            <i>
                <svg class="icon">
                    <use xlink:href="#pay"></use>
                </svg>
            </i>
            <span>{{number_format(\App\Models\Pay::count())}}</span>
        </a>
        <a class="noteLeft" href="/admin/ticket" data_count="درخواست ها">
            <i>
                <svg class="icon">
                    <use xlink:href="#ticket2"></use>
                </svg>
            </i>
            <span>{{number_format(\App\Models\Ticket::count())}}</span>
        </a>
        <a class="noteLeft" href="/admin/comment" data_count="دیدگاه ها">
            <i>
                <svg class="icon">
                    <use xlink:href="#comment2"></use>
                </svg>
            </i>
            <span>{{number_format(\App\Models\Comment::count())}}</span>
        </a>
        <div class="user">
            <div class="pic" id="userPic" aria-haspopup="true">
                <img src="/img/user.png">
            </div>
            <ul id="showUser">
                <li>
                    <div class="picUser">
                        <img src="/img/user.png" :alt="$page.userData.name">
                    </div>
                    <div class="infoUser">
                        <span>{{auth()->user()->name}}</span>
                    </div>
                </li>
                <li>
                    <a href="/profile">
                        پنل کاربری
                    </a>
                </li>
                <li>
                    <a href="/logout">
                        خروج از حساب
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var res = 0;
        $('#showUser').hide();
        $('#userPic').click(function (){
            $('#showUser').toggle(50);
        })
        if(window.innerWidth <= 700){
            res = 1;
            $(".allPanel").animate({"margin": "6rem 1rem 1rem 1rem"},300);
            $(".allHeaderPanel").animate({"right": "0"},300);
            $(".allSideBar").animate({"right": "-20rem"},50);
        }
        if(window.innerWidth > 700) {
            $('.allHeaderPanel .alignIcon').click(function () {
                if (res == 0) {
                    $(".allPanel").animate({"margin": "6rem 1rem 1rem 1rem"}, 300);
                    $(".allHeaderPanel").animate({"right": "0"}, 300);
                    res = 1;
                    $(".allSideBar").animate({"right": "-20rem"}, 50);
                } else {
                    $(".allPanel").animate({"margin": "6rem 18rem 1rem 1rem"}, 300);
                    $(".allHeaderPanel").animate({"right": "17rem"}, 300);
                    $(".allSideBar").animate({"right": "0"}, 50);
                    res = 0;
                }
            })
        }
        else{
            $('.allHeaderPanel .alignIcon').click(function () {
                if (res == 0) {
                    $(".allPanel").animate({"margin": "6rem 1rem 1rem 1rem"}, 300);
                    $(".allHeaderPanel").animate({"right": "0"}, 300);
                    res = 1;
                    $(".allSideBar").animate({"right": "-20rem"}, 50);
                } else {
                    $(".allHeaderPanel").animate({"right": "18rem"}, 300);
                    $(".allSideBar").animate({"right": "0"}, 50);
                    res = 0;
                }
            })
        }
    })
</script>
