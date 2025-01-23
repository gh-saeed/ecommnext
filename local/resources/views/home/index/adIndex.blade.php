<div class="allAdsIndex width">
    <div class="adsItems">
        @foreach(json_decode($data['ads1']) as $item)
            <div class="adsItem">
                <a href="{{$item->address}}">
                    <img lazy="loading" src="{{$item->image}}" alt="{{$item->address}}">
                </a>
            </div>
        @endforeach
    </div>
</div>
