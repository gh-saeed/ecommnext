@extends('admin.master')

@section('tab' , 30)
@section('content')
    <div class="allLearnDash">
        <div class="questions" id="customer">
            <div class="title">
                <i></i>
                ورژن فعلی شما
            </div>
            <div class="description">
                <ul>
                    <li>
                        ورژن شما:
                        <span>"{{File::get($_SERVER['DOCUMENT_ROOT'].'/version.txt')}}"</span>
                    </li>
                </ul>
            </div>
        </div>
        <div id="update_notification" style="display:none;">
            <div class="toast-header">
                <strong class="me-auto">{{trans("laraupdater.Update_Available")}}</strong>
                <span id="update_version" class="badge rounded-pill bg-info text-dark"></span>
                <button type="button" class="btn-close" data-bs-dismiss="toast">
                    <i>
                        <svg class="icon">
                            <use xlink:href="#cancel"></use>
                        </svg>
                    </i>
                </button>
            </div>
            <div class="toast-body">
                <span id="update_description"></span>
                <hr>
                <button type="button" onclick="update();" class="btn btn-info btn-sm update_btn">{{trans('laraupdater.Update_Now')}}</button>
            </div>
        </div>
    </div>
@endsection

@section('scripts3')
    <script>
        $(document).ready(function(){
            $.ajax({
                type: 'GET',
                url: '/updater.check',
                async: false,
                success: function(response) {
                    if(response != ''){
                        $('#update_version').text(response.version);
                        $('#update_description').text(response.description);
                        $('#update_notification').show();
                    }else{
                        $('#update_notification').remove();
                    }
                }
            });
        })
        function update() {
            $("#update_description").show();
            $(".update_btn").html('{{trans("laraupdater.Updating")}}');
            $.ajax({
                type: 'GET',
                url: '/updater.update',
                success: function(response) {
                    if(response != ''){
                        $('#update_description').append(response);
                        $(".update_btn").html('{{trans("laraupdater.Updated")}}');
                        $(".update_btn").attr("onclick","");
                        $('#update_notification').remove();
                        window.location.reload();
                    }
                },
                error: function(response) {
                    window.location.reload();
                    if(response != ''){
                        $('#update_description').append(response);
                        $(".update_btn").html('{{trans("laraupdater.error_try_again")}}');
                    }
                }
            });
        }
    </script>
@endsection
