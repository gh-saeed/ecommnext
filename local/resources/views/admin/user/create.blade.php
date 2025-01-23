@extends('admin.master')

@section('tab',10)
@section('content')
    <div class="allCreatePost">
        <form class="allCreatePost" action="/admin/user/create" method="POST">
            @csrf
            <div class="allPostPanelTop">
                <h1>افزودن کاربر</h1>
                <div class="allPostTitle">
                    <a href="/admin">داشبورد</a>
                    <span>/</span>
                    <a href="/admin/user">همه کاربر ها</a>
                    <span>/</span>
                    <a href="/admin/user/create">افزودن کاربر</a>
                </div>
            </div>
            <div class="allCreatePostData">
                <div class="allCreatePostSubject">
                    <div class="allCreatePostItem">
                        <label>نام کاربری :</label>
                        <input type="text" name="name" placeholder="عنوان را وارد کنید">
                        <div class="alert" id="validation-name"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>رمز عبور :</label>
                        <input type="password" name="password" placeholder="رمز عبور را وارد کنید">
                        <div class="alert" id="validation-password"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>ایمیل :</label>
                        <input type="text" name="email" placeholder="ایمیل را وارد کنید">
                        <div class="alert" id="validation-email"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>شماره تماس :</label>
                        <input type="text" name="number" placeholder="شماره تماس را وارد کنید">
                        <div class="alert" id="validation-number"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>وضعیت کاربر :</label>
                        <select name="admin">
                            <option value="0" selected>کاربر ساده</option>
                            <option value="1">مدیر کل</option>
                        </select>
                        <div class="alert" id="validation-admin"></div>
                    </div>
                    <div class="allCreatePostItem">
                        <label>فعالیت کاربر :</label>
                        <select name="suspension">
                            <option value="0" selected>فعال</option>
                            <option value="1">تعلیق / غیرفعال</option>
                        </select>
                        <div class="alert" id="validation-suspension"></div>
                    </div>
                    <button class="button" name="createPost" type="submit">ارسال اطلاعات</button>
                </div>
                <div class="allCreatePostDetails">
                    <div class="allCreatePostDetail">
                        <div class="allCreatePostDetailItemsTitle">
                            تاکسونامی
                        </div>
                        <div class="allCreatePostDetailItems">
                            <div class="allCreatePostDetailItem">
                                <label>مقام :</label>
                                <select class="js-example-basic-single" name="role">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="allCreatePostDetailItem">
                                <label>دسترسی ویژه :</label>
                                <select class="permissions-multiple" name="permissions[]" multiple="multiple">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            $('.permissions-multiple').select2({
                placeholder: 'دسترسی را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
            $('.js-example-basic-single').select2({
                placeholder: 'مقام را انتخاب کنید ...',
                "language": {
                    "noResults": function(){
                        return "موردی پیدا نشد";
                    }
                },
            });
        })
    </script>
@endsection

@section('jsScript')
    <script src="/js/select2.min.js"></script>
@endsection

@section('links')
    <link rel="stylesheet" href="/css/select2.min.css"/>
@endsection
