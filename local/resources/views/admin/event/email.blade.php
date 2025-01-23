@extends('admin.master')

@section('tab' , 6)
@section('content')
    <div class="allNote">
        @if (\Session::has('message'))
            <div class="alert">
                {!! \Session::get('message') !!}
            </div>
        @endif
        <div class="allTables">
            <div>
                <div class="allData">
                    <table>
                        <tr>
                            <th>توضیح</th>
                            <th>عنوان</th>
                            <th>کاربر</th>
                            <th>زمان ثبت</th>
                        </tr>
                        @foreach($events as $item)
                            <tr>
                                <td>{{$item->body}}</td>
                                <td>{{$item->title}}</td>
                                @if($item->customer)
                                    <td>{{$item->customer->name}}</td>
                                @else
                                    <td>-</td>
                                @endif
                                <td>{{$item->created_at}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                {{ $events->links('admin.paginate') }}
            </div>
            <div>
                <form action="/admin/notification/email" class="createFilled" method="post">
                    @csrf
                    <div class="filledItem">
                        <label>عنوان ایمیل*</label>
                        <input type="text" name="title" placeholder="عنوان را وارد کنید">
                        @error('title')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="filledItem2">
                        <label>کاربر :</label>
                        <select name="user_id[]" multiple>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">
                                    {{$user->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filledItem">
                        <label>توضیح ایمیل*</label>
                        <textarea name="body" placeholder="توضیح را وارد کنید"></textarea>
                        @error('body')
                        <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="buttonForm">
                        <button type="submit">ثبت اطلاعات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts3')
    <script>
        $(document).ready(function(){
            $("select[name='user_id[]']").select2({
                placeholder: 'جستجو نام کاربران',
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
