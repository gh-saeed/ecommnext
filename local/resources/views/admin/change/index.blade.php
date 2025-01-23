@extends('admin.master')

@section('tab',18)
@section('content')
    <div class="changeExcelIndex">
        <div class="allExcelPanel">
            <div class="allExcelPanelTop">
                @if($routes == 'increase')
                    <h1>افزایش قیمت</h1>
                @else
                    <h1>کاهش قیمت</h1>
                @endif
                <div class="allExcelPanelTitle">
                    <a href="/admin">داشبورد</a>
                    <span>/</span>
                    <a>تغییر قیمت</a>
                </div>
            </div>
            @if (\Session::has('message'))
                <div class="alert">
                    {!! \Session::get('message') !!}
                </div>
            @endif
            <div class="postType">
                <div class="item" id="0">
                    <h4 class="active">براساس برند</h4>
                </div>
                <div class="item" id="1">
                    <h4>براساس دسته بندی</h4>
                </div>
                <div class="item" id="2">
                    <h4>براساس محصول</h4>
                </div>
            </div>
            <form class="changePrices" method="post" action="/admin/change-price/{{$routes}}">
                @csrf
                <input type="hidden" value="0" name="type">
                <div class="item">
                    <label>درصد تغییر (0,100) :</label>
                    <input type="text" name="percent" placeholder="درصد را وارد کنید">
                </div>
                <div class="item">
                    <label>مبلغ ثابت (تومان) :</label>
                    <input type="text" name="number" placeholder="عدد را وارد کنید">
                </div>
                <div class="item" id="brands">
                    <label>برند :</label>
                    <select class="brand-multiple" multiple="multiple" name="brands[]">
                        @foreach($brands as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="item" id="cats">
                    <label>دسته بندی :</label>
                    <select class="cat-multiple" multiple="multiple" name="cats[]">
                        @foreach($cats as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="item" id="products">
                    <label>محصولات :</label>
                    <select class="product-multiple" multiple="multiple" name="products[]">
                        @foreach($products as $item)
                            <option value="{{$item->id}}">{{$item->title}}</option>
                        @endforeach
                    </select>
                </div>
                <button>اعمال تغییر</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            $("input[name='percent']").val('');
            $("input[name='number']").val('');
            $('.brand-multiple').select2({
                placeholder: 'برند را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $('.cat-multiple').select2({
                placeholder: 'دسته بندی را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $('.product-multiple').select2({
                placeholder: 'محصول را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $('#cats').hide();
            $('#products').hide();
            $("input[name='percent']").on('change' , function(){
                if($(this).val() != ''){
                    $($("input[name='number']")[0].parentElement).val('');
                }
            })
            $("input[name='number']").on('change' , function(){
                if($(this).val() != ''){
                    $($("input[name='percent']")[0].parentElement).val('');
                }
            })
            $('.postType .item').on('click' , function(){
                $("input[name='type']").val(this.id);
                $('.postType h4').attr('class' , '')
                $(this.lastElementChild).attr('class' , 'active');
                $('#cats').hide();
                $('#products').hide();
                $('#brands').hide();
                if(this.id == 0){
                    $('#brands').show();
                }
                if(this.id == 1){
                    $('#cats').show();
                }
                if(this.id == 2){
                    $('#products').show();
                }
            })
        })
    </script>
@endsection

@section('jsScript')
    <script src="/js/select2.min.js"></script>
    <link rel="stylesheet" href="/css/select2.min.css"/>
@endsection
