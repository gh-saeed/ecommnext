<div class="AllPopUpIndex">
    <div class="AllPopUpData">
        <div class="pic">
            <img src="{{$imagePopUp}}" alt="{{$titlePopUp}}">
        </div>
        <h3>{{$titlePopUp}}</h3>
        <p>{{ $descriptionPopUp }}</p>
        <div class="buttons">
            @if($addressPopUp && $addressPopUp != '/')
                <a href="{{$addressPopUp}}" target="_blank">{{$buttonPopUp}}</a>
                @else
                <a>{{$buttonPopUp}}</a>
            @endif
        </div>
    </div>
</div>
