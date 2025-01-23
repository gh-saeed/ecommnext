<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FloatAccess;
use App\Models\Land;
use App\Models\Setting;
use App\Models\Widget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function categoryIndex(){
        $cats = Category::select(['id' , 'name'])->where('type' , 0)->get();
        $catHeader1 = Setting::where('key' , 'catHeader')->pluck('value')->first();
        $catHeader2 = explode(',' , $catHeader1);
        $catHeader = [];
        for ( $i = 0; $i < count($catHeader2); $i++) {
            $send = Category::where('id' , $catHeader2[$i])->pluck('name')->first();
            array_push($catHeader , $send);
        }
        return view('admin.setting.category' , compact('cats','catHeader'));
    }

    public function categoryUpdate(Request $request){
        $catHeader1 = explode(',',$request->catHeader);
        $catHeader = [];
        for ( $i = 0; $i < count($catHeader1); $i++) {
            $send = Category::where('name' , $catHeader1[$i])->pluck('id')->first();
            array_push($catHeader , $send);
        }
        $array = [
            'catHeader' => implode(',' , $catHeader),
        ];
        foreach ($array as $key=>$item){
            $setting = Setting::where('key' , $key)->first();
            if ($setting != ''){
                $setting->update([
                    'value'=>$item,
                ]);
            }
        }
        return 'success';
    }

    public function manageIndex(){
        $name = Setting::where('key' , 'name')->pluck('value')->first();
        $title = Setting::where('key' , 'title')->pluck('value')->first();
        $logo = Setting::where('key' , 'logo')->pluck('value')->first();
        $about = Setting::where('key' , 'about')->pluck('value')->first();
        $address = Setting::where('key' , 'address')->pluck('value')->first();
        $email = Setting::where('key' , 'email')->pluck('value')->first();
        $fanavari = Setting::where('key' , 'fanavari')->pluck('value')->first();
        $etemad = Setting::where('key' , 'etemad')->pluck('value')->first();
        $number = Setting::where('key' , 'number')->pluck('value')->first();
        $facebook = Setting::where('key' , 'facebook')->pluck('value')->first();
        $instagram = Setting::where('key' , 'instagram')->pluck('value')->first();
        $twitter = Setting::where('key' , 'twitter')->pluck('value')->first();
        $telegram = Setting::where('key' , 'telegram')->pluck('value')->first();
        $productId = Setting::where('key' , 'productId')->pluck('value')->first();
        $imagePopUp = Setting::where('key' , 'imagePopUp')->pluck('value')->first();
        $titlePopUp = Setting::where('key' , 'titlePopUp')->pluck('value')->first();
        $addressPopUp = Setting::where('key' , 'addressPopUp')->pluck('value')->first();
        $popUpStatus = Setting::where('key' , 'popUpStatus')->pluck('value')->first();
        $descriptionPopUp = Setting::where('key' , 'descriptionPopUp')->pluck('value')->first();
        $buttonPopUp = Setting::where('key' , 'buttonPopUp')->pluck('value')->first();
        $captchaStatus = Setting::where('key' , 'captchaStatus')->pluck('value')->first();
        $captchaType = Setting::where('key' , 'captchaType')->pluck('value')->first();
        $tax = Setting::where('key' , 'tax')->pluck('value')->first();
        $sellerStatus = Setting::where('key' , 'sellerStatus')->pluck('value')->first();
        $newRedirect = Setting::where('key' , 'newRedirect')->pluck('value')->first();
        $redirectStatus = Setting::where('key' , 'redirectStatus')->pluck('value')->first();
        $checkoutCharge = Setting::where('key' , 'checkoutCharge')->pluck('value')->first();
        return view('admin.setting.manage' , compact('name','title','checkoutCharge','newRedirect','redirectStatus','sellerStatus','tax','captchaType','captchaStatus','descriptionPopUp','buttonPopUp','imagePopUp','titlePopUp','addressPopUp','popUpStatus','logo','about','address','email','fanavari','etemad','number','facebook','instagram','twitter','telegram','productId'));
    }

    public function manageUpdate(Request $request){
        $fanavari = $request->fanavari;
        $etemad = $request->etemad;
        $number = $request->number;
        $textFloat = $request->textFloat;
        $facebook = $request->facebook;
        $instagram = $request->instagram;
        $twitter = $request->twitter;
        $telegram = $request->telegram;
        $logo = $request->image;
        $about = $request->about;
        $title = $request->title;
        $address = $request->address;
        $productId = $request->productId;
        $name = $request->name;
        $email = $request->email;
        $captchaType = $request->captchaType;
        $checkoutCharge = $request->checkoutCharge;
        $tax = $request->tax;
        $newRedirect = $request->newRedirect;
        $backIndex = $request->backIndex;
        $captchaStatus = $request->captchaStatus == 'on' ? 1 : 0;
        $sellerStatus = $request->sellerStatus == 'on' ? 1 : 0;
        $redirectStatus = $request->redirectStatus == 'on' ? 1 : 0;
        $array = [
            'productId' =>$productId,
            'name' =>$name,
            'captchaStatus' =>$captchaStatus,
            'textFloat' =>$textFloat,
            'newRedirect' =>$newRedirect,
            'checkoutCharge' =>$checkoutCharge,
            'redirectStatus' =>$redirectStatus,
            'captchaType' =>$captchaType,
            'fanavari' =>$fanavari,
            'telegram' =>$telegram,
            'sellerStatus' =>$sellerStatus,
            'etemad' =>$etemad,
            'twitter' =>$twitter,
            'instagram' =>$instagram,
            'facebook' =>$facebook,
            'number' =>$number,
            'logo' =>$logo,
            'tax' =>$tax,
            'about' =>$about,
            'title' =>$title,
            'address' =>$address,
            'email' =>$email,
            'backIndex' =>$backIndex,
        ];
        foreach ($array as $key=>$item){
            $setting = Setting::where('key' , $key)->first();
            if ($setting != ''){
                $setting->update([
                    'value'=>$item,
                ]);
            }
        }
        return redirect()->back()->with([
            'message' => 'اطلاعات ثبت شد'
        ]);
    }

    public function popUp(Request $request){
        $imagePopUp = $request->imagePopUp;
        $titlePopUp = $request->titlePopUp;
        $addressPopUp = $request->addressPopUp;
        $descriptionPopUp = $request->descriptionPopUp;
        $buttonPopUp = $request->buttonPopUp;
        if($request->popUpStatus == 'on'){
            $popUpStatus = 1;
        }else{
            $popUpStatus = 0;
        }
        $array = [
            'imagePopUp' =>$imagePopUp,
            'titlePopUp' =>$titlePopUp,
            'addressPopUp' =>$addressPopUp,
            'popUpStatus' =>$popUpStatus,
            'descriptionPopUp' =>$descriptionPopUp,
            'buttonPopUp' =>$buttonPopUp,
        ];
        foreach ($array as $key=>$item){
            $setting = Setting::where('key' , $key)->first();
            if ($setting != ''){
                $setting->update([
                    'value'=>$item,
                ]);
            }
        }
        return redirect()->back()->with([
            'message' => 'اطلاعات ثبت شد'
        ]);
    }

    public function redirect(Request $request){
        $newRedirect = $request->newRedirect;
        if($request->redirectStatus == 'on'){
            $redirectStatus = 1;
        }else{
            $redirectStatus = 0;
        }
        $array = [
            'newRedirect' =>$newRedirect,
            'redirectStatus' =>$redirectStatus,
        ];
        foreach ($array as $key=>$item){
            $setting = Setting::where('key' , $key)->first();
            if ($setting != ''){
                $setting->update([
                    'value'=>$item,
                ]);
            }
        }
        return redirect()->back()->with([
            'message' => 'اطلاعات ثبت شد'
        ]);
    }

    public function seoIndex(){
        $titleSeo = Setting::where('key' , 'titleSeo')->pluck('value')->first();
        $keyword = Setting::where('key' , 'keyword')->pluck('value')->first();
        $aboutSeo = Setting::where('key' , 'aboutSeo')->pluck('value')->first();
        return view('admin.setting.seo' , compact('titleSeo','keyword','aboutSeo'));
    }

    public function seoUpdate(Request $request){
        $titleSeo = $request->titleSeo;
        $keyword = $request->keyword;
        $aboutSeo = $request->aboutSeo;
        $array = [
            'titleSeo' =>$titleSeo,
            'keyword' =>$keyword,
            'aboutSeo' =>$aboutSeo,
        ];
        foreach ($array as $key=>$item){
            $setting = Setting::where('key' , $key)->first();
            if ($setting != ''){
                $setting->update([
                    'value'=>$item,
                ]);
            }
        }
        return redirect()->back()->with([
            'message' => 'اطلاعات ثبت شد'
        ]);
    }

    public function galleryIndex(){
        $optimizeImage = Setting::where('key' , 'optimizeImage')->pluck('value')->first();
        $changeImage = Setting::where('key' , 'changeImage')->pluck('value')->first();
        $watermarkImage = Setting::where('key' , 'watermarkImage')->pluck('value')->first();
        $watermarkStatus = Setting::where('key' , 'watermarkStatus')->pluck('value')->first();
        return view('admin.setting.gallery' , compact('optimizeImage','changeImage','watermarkImage','watermarkStatus'));
    }

    public function galleryCache(Request $request){
        $optimizeImage = $request->optimizeImage;
        $changeImage = $request->changeImage;
        $watermarkImage = $request->watermarkImage;
        $watermarkStatus = $request->watermarkStatus;
        $array = [
            'optimizeImage' =>$optimizeImage,
            'changeImage' =>$changeImage,
            'watermarkImage' =>$watermarkImage,
            'watermarkStatus' =>$watermarkStatus,
        ];
        foreach ($array as $key=>$item){
            $setting = Setting::where('key' , $key)->first();
            if ($setting != ''){
                $setting->update([
                    'value'=>$item,
                ]);
            }
        }
        return redirect()->back()->with([
            'message' => 'اطلاعات ثبت شد'
        ]);
    }

    public function cacheIndex(){
        $cacheTime = Setting::where('key' , 'cacheTime')->pluck('value')->first();
        $cacheStatus = Setting::where('key' , 'cacheStatus')->pluck('value')->first();
        return view('admin.setting.cache' , compact('cacheTime','cacheStatus'));
    }

    public function cacheUpdate(Request $request){
        $cacheTime = $request->cacheTime;
        $cacheStatus = $request->cacheStatus;
        $array = [
            'cacheTime' =>$cacheTime,
            'cacheStatus' =>$cacheStatus,
        ];
        foreach ($array as $key=>$item){
            $setting = Setting::where('key' , $key)->first();
            if ($setting != ''){
                $setting->update([
                    'value'=>$item,
                ]);
            }
        }
        return redirect()->back()->with([
            'message' => 'اطلاعات ثبت شد'
        ]);
    }

    public function themeIndex(){
        $greenColorLight = Setting::where('key' , 'greenColorLight')->pluck('value')->first();
        $redColorLight = Setting::where('key' , 'redColorLight')->pluck('value')->first();
        $backColorLight1 = Setting::where('key' , 'backColorLight1')->pluck('value')->first();
        $singleDesign = Setting::where('key' , 'singleDesign')->pluck('value')->first();
        $headerDesign = Setting::where('key' , 'headerDesign')->pluck('value')->first();
        $footerDesign = Setting::where('key' , 'footerDesign')->pluck('value')->first();
        $font = Setting::where('key' , 'font')->pluck('value')->first();
        return view('admin.setting.theme' , compact('greenColorLight','singleDesign','headerDesign','footerDesign','redColorLight','font','backColorLight1'));
    }

    public function themeUpdate(Request $request){
        if($request->demo >= 1){
            if($request->demo == 1) {
                $demo = json_decode('[{"id":10,"name":"\u0645\u0639\u0631\u0641\u06cc \u0633\u0627\u06cc\u062a","title":"\u0628\u0627 \u0645\u0627 \u063a\u0631\u0641\u0647 \u062e\u0648\u062f\u062a\u0627\u0646 \u0631\u0627 \u062f\u0631\u0633\u062a \u06a9\u0646\u06cc\u062f!","more":"\u063a\u0631\u0641\u0647 \u062e\u0648\u062f\u062a \u0631\u0648 \u0628\u0633\u0627\u0632","number":"0","description":"\u06cc\u06a9 \u0628\u0627\u0632\u0627\u0631 \u0628\u0631\u0627\u06cc \u062e\u0631\u06cc\u062f \u0648 \u0641\u0631\u0648\u0634 \u0645\u062d\u0635\u0648\u0644\u0627\u062a \u0645\u062e\u062a\u0644\u0641 \u0628\u0627 \u06a9\u06cc\u0641\u06cc\u062a \u0648 \u0642\u06cc\u0645\u062a\u200c\u0647\u0627\u06cc \u0645\u062a\u0641\u0627\u0648\u062a\u0647. \u0628\u0627\u0633\u0644\u0627\u0645 \u0645\u062c\u0645\u0648\u0639\u0647\u200c\u0627\u06cc \u0627\u0632 \u0628\u0627\u0632\u0627\u0631\u0647\u0627\u06cc \u0628\u0632\u0631\u06af \u0647\u0645\u0647\u200c\u06cc \u0634\u0647\u0631\u0647\u0627\u0633\u062a \u0627\u0645\u0627 \u0627\u06cc\u0646\u062a\u0631\u0646\u062a\u06cc. \u0628\u0627\u0632\u0627\u0631 \u062a\u062c\u0631\u06cc\u0634 \u0648 \u0628\u0627\u0632\u0627\u0631 \u0628\u0632\u0631\u06af \u0633\u06cc\u0633\u062a\u0627\u0646 \u062f\u0631 \u0628\u0627\u0633\u0644\u0627\u0645 \u06a9\u0646\u0627\u0631 \u0647\u0645 \u0686\u06cc\u062f\u0647 \u0634\u062f\u0647. \u0627\u06cc\u0646\u200c\u062c\u0627 \u0628\u0627 \u0641\u0631\u0648\u0634\u0646\u062f\u0647\u200c\u0647\u0627 \u0648 \u062e\u0631\u06cc\u062f\u0627\u0631\u0647\u0627\u06cc \u0648\u0627\u0642\u0639\u06cc \u0633\u0631\u0648\u06a9\u0627\u0631 \u062f\u0627\u0631\u06cc\u061b \u0646\u0647 \u0627\u0646\u0628\u0627\u0631\u0647\u0627\u06cc \u062f\u0631\u0646\u062f\u0634\u062a \u0648 \u0628\u0632\u0631\u06af\u060c \u0686\u0648\u0646 \u0628\u0627\u0633\u0644\u0627\u0645 \u0628\u0627\u0632\u0627\u0631 \u0622\u062f\u0645\u200c\u0647\u0627\u0633\u062a.","background":"https:\/\/rayganapp.ir\/upload\/image\/2024\/js.webp","slug":"\/become-seller","count":"5","sort":"0","type":null,"status":"1","brands":null,"responsive":"0","users":"[\"1\",\"2\",\"3\"]","cats":"[]","ads1":"[]","ads2":null,"ads3":null,"created_at":"2024-07-14T08:32:03.000000Z","updated_at":"2024-07-23T14:28:01.000000Z"},{"id":9,"name":"\u062f\u0633\u062a\u0647 \u0628\u0646\u062f\u06cc","title":null,"more":null,"number":"1","description":null,"background":null,"slug":null,"count":null,"sort":"0","type":null,"status":"1","brands":null,"responsive":"0","users":"[]","cats":"[\"27\",\"28\",\"29\",\"30\",\"68\"]","ads1":"[]","ads2":null,"ads3":null,"created_at":"2024-07-14T08:30:10.000000Z","updated_at":"2024-07-23T14:28:01.000000Z"},{"id":18,"name":"\u062a\u0628\u0644\u06cc\u063a \u0633\u0627\u062f\u0647","title":null,"more":null,"number":"2","description":null,"background":null,"slug":null,"count":null,"sort":"0","type":null,"status":"1","brands":null,"responsive":"0","users":"[]","cats":"[]","ads1":"[{\"image\":\"https:\/\/dkstatics-public.digikala.com\/digikala-adservice-banners\/c11cf0a502e9cb2b6ef8e3fb32b593e2e84348b0_1629115286.jpg?x-oss-process=image\/quality,q_80\",\"address\":\"\/\"}]","ads2":null,"ads3":null,"created_at":"2024-07-23T14:27:51.000000Z","updated_at":"2024-07-23T14:28:01.000000Z"},{"id":11,"name":"\u062a\u06a9 \u063a\u0631\u0641\u0647","title":null,"more":null,"number":"3","description":null,"background":null,"slug":null,"count":null,"sort":"0","type":null,"status":"1","brands":null,"responsive":"0","users":"[\"1\",\"2\",\"3\"]","cats":"[]","ads1":"[]","ads2":null,"ads3":null,"created_at":"2024-07-14T08:32:26.000000Z","updated_at":"2024-07-23T14:28:01.000000Z"},{"id":15,"name":"\u062a\u0628\u0644\u06cc\u063a \u0633\u0627\u062f\u0647","title":null,"more":null,"number":"4","description":null,"background":null,"slug":null,"count":null,"sort":"0","type":null,"status":"1","brands":null,"responsive":"0","users":"[]","cats":"[]","ads1":"[{\"image\":\"https:\/\/dkstatics-public.digikala.com\/digikala-adservice-banners\/ff02be03f70ae8d8b3a21bd7758f76012db79612_1722433903.jpg?x-oss-process=image\/quality,q_95\/format,webp\",\"address\":\"\/\"},{\"image\":\"https:\/\/dkstatics-public.digikala.com\/digikala-adservice-banners\/7abece0d23fb2a2358105da1834393a1c65a49a1_1722753556.jpg?x-oss-process=image\/quality,q_95\/format,webp\",\"address\":\"\/\"},{\"image\":\"https:\/\/dkstatics-public.digikala.com\/digikala-adservice-banners\/6fc8e2d21aba219e1aa2cc93cb4a5fd66a16caac_1722416734.gif?x-oss-process=image?x-oss-process=image\/format,webp\",\"address\":\"\/\"}]","ads2":null,"ads3":null,"created_at":"2024-07-23T11:16:21.000000Z","updated_at":"2024-07-23T14:28:01.000000Z"},{"id":8,"name":"\u0627\u0633\u062a\u0648\u0631\u06cc","title":"\u0627\u0633\u062a\u0648\u0631\u06cc","more":null,"number":"5","description":null,"background":null,"slug":null,"count":null,"sort":"0","type":null,"status":"1","brands":null,"responsive":"0","users":"[\"1\",\"2\",\"3\"]","cats":"[]","ads1":"[]","ads2":null,"ads3":null,"created_at":"2024-07-14T07:59:37.000000Z","updated_at":"2024-07-23T14:28:01.000000Z"},{"id":17,"name":"\u062a\u0628\u0644\u06cc\u063a \u0633\u0627\u062f\u0647","title":null,"more":null,"number":"6","description":null,"background":null,"slug":null,"count":null,"sort":"0","type":null,"status":"1","brands":null,"responsive":"0","users":"[]","cats":"[]","ads1":"[{\"image\":\"https:\/\/dkstatics-public.digikala.com\/digikala-adservice-banners\/1573c10d2feef51495d49668b9d1e465c58757a8_1713603679.jpg?x-oss-process=image\/quality,q_95\/format,webp\",\"address\":\"\/\"},{\"image\":\"https:\/\/dkstatics-public.digikala.com\/digikala-adservice-banners\/9d3337e292fa1fa903de68cd7b5eba61de14b532_1713603787.jpg?x-oss-process=image\/quality,q_95\/format,webp\",\"address\":\"\/\"}]","ads2":null,"ads3":null,"created_at":"2024-07-23T11:22:37.000000Z","updated_at":"2024-07-23T14:28:01.000000Z"},{"id":12,"name":"\u0644\u06cc\u0633\u062a \u063a\u0631\u0641\u0647","title":"\u0641\u0631\u0648\u0634\u0646\u062f\u06af\u0627\u0646 \u0628\u0631\u062a\u0631","more":"\u0645\u0634\u0627\u0647\u062f\u0647 \u0628\u06cc\u0634\u062a\u0631","number":"7","description":null,"background":null,"slug":null,"count":null,"sort":"0","type":null,"status":"1","brands":null,"responsive":"0","users":"[\"1\",\"2\",\"3\"]","cats":"[]","ads1":"[]","ads2":null,"ads3":null,"created_at":"2024-07-14T08:33:08.000000Z","updated_at":"2024-07-23T14:28:01.000000Z"},{"id":16,"name":"\u062a\u0628\u0644\u06cc\u063a \u0633\u0627\u062f\u0647","title":null,"more":null,"number":"8","description":null,"background":null,"slug":null,"count":null,"sort":"0","type":null,"status":"1","brands":null,"responsive":"0","users":"[]","cats":"[]","ads1":"[{\"image\":\"https:\/\/dkstatics-public.digikala.com\/digikala-adservice-banners\/c0ac90329c1a7afd9ffba793f025dec6f03cfd3a_1658497984.jpg?x-oss-process=image\/quality,q_95\/format,webp\",\"address\":\"\/\"},{\"image\":\"https:\/\/dkstatics-public.digikala.com\/digikala-adservice-banners\/870bc573996f86e8770f43ff922ecc7da7d97b73_1658498259.jpg?x-oss-process=image\/quality,q_95\/format,webp\",\"address\":\"\/\"},{\"image\":\"https:\/\/dkstatics-public.digikala.com\/digikala-adservice-banners\/23248bc94a1cc98e98f16d742a825ef0284717fe_1658498127.jpg?x-oss-process=image\/quality,q_95\/format,webp\",\"address\":\"\/\"},{\"image\":\"https:\/\/dkstatics-public.digikala.com\/digikala-adservice-banners\/96d1537e1a684ba918b6111ffdd3dfc9e13bd7f4_1658498413.jpg?x-oss-process=image\/quality,q_95\/format,webp\",\"address\":\"\/\"}]","ads2":null,"ads3":null,"created_at":"2024-07-23T11:20:26.000000Z","updated_at":"2024-07-23T14:28:01.000000Z"},{"id":13,"name":"\u0628\u0627\u0632\u0627\u0631\u06af\u0631\u062f\u06cc","title":"\u0628\u0627\u0632\u0627\u0631\u06af\u0631\u062f\u06cc","more":"\u062c\u0647\u062a \u0645\u0634\u0627\u0647\u062f\u0647 \u0628\u06cc\u0634\u062a\u0631 \u06a9\u0644\u06cc\u06a9 \u06a9\u0646","number":"9","description":null,"background":null,"slug":"\/","count":null,"sort":"0","type":null,"status":"1","brands":null,"responsive":"0","users":"[]","cats":"[]","ads1":"[]","ads2":null,"ads3":null,"created_at":"2024-07-14T08:33:49.000000Z","updated_at":"2024-07-23T14:28:01.000000Z"},{"id":14,"name":"\u0628\u0644\u0627\u06af","title":"\u0628\u0644\u0627\u06af \u0647\u0627 \u0645\u0627","more":"\u0645\u0634\u0627\u0647\u062f\u0647 \u0647\u0645\u0647 \u0628\u0644\u0627\u06af \u0647\u0627","number":"10","description":null,"background":null,"slug":null,"count":null,"sort":"0","type":null,"status":"1","brands":null,"responsive":"0","users":"[]","cats":"[]","ads1":"[]","ads2":null,"ads3":null,"created_at":"2024-07-14T08:34:47.000000Z","updated_at":"2024-07-23T14:28:01.000000Z"}]');
            }elseif($request->demo == 2) {
                $demo = json_decode('[{"id":1,"name":"\u062a\u0628\u0644\u06cc\u063a \u0628\u0632\u0631\u06af","title":null,"more":null,"number":"0","description":null,"background":null,"slug":null,"count":null,"sort":null,"type":null,"status":"1","brands":null,"responsive":"0","users":null,"cats":null,"ads1":"[{\"image\":\"https:\/\/statics.basalam.com\/public-27\/photo\/explore\/aN\/07-31\/CWI7Dw5u3T8cJwZRT5ORMxmngABBvXWCV4q96IDxpDu30C6ktX.jpg\",\"address\":\"\/\"},{\"image\":\"https:\/\/statics.basalam.com\/public-27\/photo\/explore\/aN\/07-31\/CWI7Dw5u3T8cJwZRT5ORMxmngABBvXWCV4q96IDxpDu30C6ktX.jpg\",\"address\":\"\/\"}]","ads2":null,"ads3":null,"created_at":null,"updated_at":null},{"id":2,"name":"\u062f\u0633\u062a\u0647 \u0628\u0646\u062f\u06cc2","title":null,"more":null,"number":"1","description":null,"background":null,"slug":null,"count":null,"sort":null,"type":null,"status":"1","brands":null,"responsive":"0","users":null,"cats":"[\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\"]","ads1":"","ads2":null,"ads3":null,"created_at":null,"updated_at":null},{"id":3,"name":"\u062a\u0628\u0644\u06cc\u063a \u0633\u0627\u062f\u0647","title":null,"more":null,"number":"2","description":null,"background":null,"slug":null,"count":null,"sort":null,"type":null,"status":"1","brands":null,"responsive":"0","users":null,"cats":null,"ads1":"[{\"image\":\"https:\/\/statics.basalam.com\/public-27\/photo\/explore\/aN\/07-31\/sDcVFgZrioJd9poOGhPi1I6zNvChySL2n8vGvInpctijXejFpn.jpg\",\"address\":\"\/\"}]","ads2":null,"ads3":null,"created_at":null,"updated_at":null},{"id":4,"name":"\u0627\u0633\u062a\u0648\u0631\u06cc2","title":" \u0642\u0635\u0647 \u062e\u0648\u0634\u200c\u0645\u0631\u0627\u0645\u06cc \u0628\u0627\u0633\u0644\u0627\u0645\u06cc\u200c\u0647\u0627 \u0627\u0632 \u0632\u0628\u0648\u0646 \u062e\u0648\u062f\u0634\u0648\u0646","more":null,"number":"3","description":null,"background":null,"slug":null,"count":null,"sort":null,"type":null,"status":"1","brands":null,"responsive":"0","users":"[\"1\",\"2\",\"3\"]","cats":"","ads1":"","ads2":null,"ads3":null,"created_at":null,"updated_at":null},{"id":5,"name":"\u062a\u0628\u0644\u06cc\u063a \u0633\u0627\u062f\u0647","title":null,"more":null,"number":"5","description":null,"background":null,"slug":null,"count":null,"sort":null,"type":null,"status":"1","brands":null,"responsive":"0","users":null,"cats":null,"ads1":"[{\"image\":\"https:\/\/statics.basalam.com\/public-28\/photo\/explore\/aN\/08-03\/qcdi4tTuBkqTdR3PxIGFDITov8wHD6f5ZaS8LRpnOoucsqfkRu.jpg\",\"address\":\"\/\"}]","ads2":null,"ads3":null,"created_at":null,"updated_at":null},{"id":6,"name":"\u0627\u0633\u062a\u0648\u0631\u06cc3","title":"\u0627\u0647\u0627\u0644\u06cc \u0631\u0648 \u0628\u0647 \u0686\u06cc \u0645\u06cc\u200c\u0634\u0646\u0627\u0633\u0646\u061f","more":null,"number":"6","description":null,"background":null,"slug":null,"count":null,"sort":null,"type":null,"status":"1","brands":null,"responsive":"0","users":"[\"1\",\"2\",\"3\"]","cats":"","ads1":"","ads2":null,"ads3":null,"created_at":null,"updated_at":null},{"id":8,"name":"\u062a\u06a9 \u063a\u0631\u0641\u0647","title":"\u0628\u0627\u0632\u0627\u0631\u06af\u0631\u062f\u06cc","more":"\u0628\u06cc\u0634\u062a\u0631","number":"8","description":null,"background":null,"slug":null,"count":null,"sort":null,"type":null,"status":"1","brands":null,"responsive":"0","users":"[\"1\",\"2\",\"3\"]","cats":"","ads1":"","ads2":null,"ads3":null,"created_at":null,"updated_at":null},{"id":10,"name":"\u062a\u0628\u0644\u06cc\u063a \u0633\u0627\u062f\u0647","title":null,"more":null,"number":"8","description":null,"background":null,"slug":null,"count":null,"sort":null,"type":null,"status":"1","brands":null,"responsive":"0","users":null,"cats":null,"ads1":"[{\"image\":\"https:\/\/dkstatics-public.digikala.com\/digikala-adservice-banners\/ff02be03f70ae8d8b3a21bd7758f76012db79612_1722433903.jpg?x-oss-process=image\/quality,q_95\/format,webp\",\"address\":\"\/\"},{\"image\":\"https:\/\/dkstatics-public.digikala.com\/digikala-adservice-banners\/7abece0d23fb2a2358105da1834393a1c65a49a1_1722753556.jpg?x-oss-process=image\/quality,q_95\/format,webp\",\"address\":\"\/\"},{\"image\":\"https:\/\/dkstatics-public.digikala.com\/digikala-adservice-banners\/6fc8e2d21aba219e1aa2cc93cb4a5fd66a16caac_1722416734.gif?x-oss-process=image?x-oss-process=image\/format,webp\",\"address\":\"\/\"}]","ads2":null,"ads3":null,"created_at":null,"updated_at":null},{"id":9,"name":"\u0644\u062d\u0638\u0647 \u0627\u06cc","title":"\u0645\u062d\u0635\u0648\u0644\u0627\u062a \u0628\u0627\u0633\u0644\u0627\u0645","more":"\u0628\u06cc\u0634\u062a\u0631","number":"9","description":null,"background":null,"slug":null,"count":null,"sort":null,"type":null,"status":"1","brands":null,"responsive":"0","users":"[\"1\"]","cats":"","ads1":"","ads2":null,"ads3":null,"created_at":null,"updated_at":null},{"id":7,"name":"\u0628\u0644\u0627\u06af2","title":"\u0628\u0644\u0627\u06af \u0647\u0627","more":"\u0645\u0634\u0627\u0647\u062f\u0647 \u0628\u06cc\u0634\u062a\u0631","number":"10","description":null,"background":null,"slug":null,"count":null,"sort":null,"type":null,"status":"1","brands":null,"responsive":"0","users":null,"cats":"[]","ads1":"[{\"image\":\"https:\/\/statics.basalam.com\/public-27\/photo\/explore\/aN\/07-31\/sDcVFgZrioJd9poOGhPi1I6zNvChySL2n8vGvInpctijXejFpn.jpg\",\"address\":\"\/\"}]","ads2":null,"ads3":null,"created_at":null,"updated_at":null},{"id":11,"name":"\u0645\u062d\u0635\u0648\u0644\u0627\u062a \u0627\u0633\u0644\u0627\u06cc\u062f\u0631\u06cc","title":"\u0645\u062d\u0635\u0648\u0644\u0627\u062a \u062c\u062f\u06cc\u062f","more":"\u0628\u06cc\u0634\u062a\u0631","number":"11","description":null,"background":null,"slug":null,"count":null,"sort":null,"type":null,"status":"1","brands":null,"responsive":"0","users":null,"cats":"","ads1":"","ads2":null,"ads3":null,"created_at":null,"updated_at":null}]');
            }
            DB::table('widgets')->delete();
            foreach ($demo as $item){
                Widget::create([
                    'name'=> $item->name,
                    'title'=> $item->title,
                    'more'=> $item->more,
                    'description'=> $item->description,
                    'background'=> $item->background,
                    'slug'=> $item->slug,
                    'count'=> $item->count,
                    'sort'=> $item->sort,
                    'type'=> $item->type,
                    'status'=> $item->status,
                    'brands'=> $item->brands,
                    'users'=> $item->users,
                    'responsive'=> $item->responsive,
                    'cats'=> $item->cats,
                    'ads1'=> $item->ads1,
                    'ads2'=> $item->ads2,
                    'ads3'=> $item->ads3,
                ]);
            }
        }
        $greenColorLight = $request->greenColorLight;
        $redColorLight = $request->redColorLight;
        $backColorLight1 = $request->backColorLight1;
        $singleDesign = $request->singleDesign;
        $headerDesign = $request->headerDesign;
        $footerDesign = $request->footerDesign;
        $font = $request->font;
        $array = [
            'font' =>$font,
            'greenColorLight' =>$greenColorLight,
            'redColorLight' =>$redColorLight,
            'backColorLight1' =>$backColorLight1,
            'singleDesign' =>$singleDesign,
            'headerDesign' =>$headerDesign,
            'footerDesign' =>$footerDesign,
        ];
        foreach ($array as $key=>$item){
            $setting = Setting::where('key' , $key)->first();
            if ($setting != ''){
                $setting->update([
                    'value'=>$item,
                ]);
            }
        }
        return redirect()->back()->with([
            'message' => 'اطلاعات ثبت شد'
        ]);
    }

    public function messageIndex(){
        $messageAuth = Setting::where('key' , 'messageAuth')->pluck('value')->first();
        $messageSuccess = Setting::where('key' , 'messageSuccess')->pluck('value')->first();
        $messageSuggest = Setting::where('key' , 'messageSuggest')->pluck('value')->first();
        $messageCancel = Setting::where('key' , 'messageCancel')->pluck('value')->first();
        $messageBack = Setting::where('key' , 'messageBack')->pluck('value')->first();
        $messageManager = Setting::where('key' , 'messageManager')->pluck('value')->first();
        $messageCounseling = Setting::where('key' , 'messageCounseling')->pluck('value')->first();
        $messageStatus0 = Setting::where('key' , 'messageStatus0')->pluck('value')->first();
        $messageStatus1 = Setting::where('key' , 'messageStatus1')->pluck('value')->first();
        $messageStatus2 = Setting::where('key' , 'messageStatus2')->pluck('value')->first();
        $messageStatus3 = Setting::where('key' , 'messageStatus3')->pluck('value')->first();
        $messageTrack = Setting::where('key' , 'messageTrack')->pluck('value')->first();
        $userSms = Setting::where('key' , 'userSms')->pluck('value')->first();
        $passSms = Setting::where('key' , 'passSms')->pluck('value')->first();
        $kaveKey = Setting::where('key' , 'kaveKey')->pluck('value')->first();
        $typeSms = Setting::where('key' , 'smsType')->pluck('value')->first();
        $userFaraz = Setting::where('key' , 'userFaraz')->pluck('value')->first();
        $passFaraz = Setting::where('key' , 'passFaraz')->pluck('value')->first();
        $numberFaraz = Setting::where('key' , 'numberFaraz')->pluck('value')->first();
        $messageRegister = Setting::where('key' , 'messageRegister')->pluck('value')->first();
        return view('admin.setting.message' , compact('messageAuth','messageCounseling','messageTrack','messageRegister','messageStatus0','messageStatus1','messageStatus2','messageStatus3','userSms','passSms','kaveKey','userFaraz','passFaraz','numberFaraz','typeSms','messageSuccess','messageSuggest','messageCancel','messageBack','messageManager'));
    }

    public function messageUpdate(Request $request){
        $messageAuth = $request->messageAuth;
        $messageSuccess = $request->messageSuccess;
        $messageSuggest = $request->messageSuggest;
        $messageCancel = $request->messageCancel;
        $messageBack = $request->messageBack;
        $messageManager = $request->messageManager;
        $messageCounseling = $request->messageCounseling;
        $messageStatus0 = $request->messageStatus0;
        $messageStatus1 = $request->messageStatus1;
        $messageStatus2 = $request->messageStatus2;
        $messageStatus3 = $request->messageStatus3;
        $messageTrack = $request->messageTrack;
        $userSms = $request->userSms;
        $passSms = $request->passSms;
        $kaveKey = $request->kaveKey;
        $typeSms = $request->typeSms;
        $userFaraz = $request->userFaraz;
        $passFaraz = $request->passFaraz;
        $numberFaraz = $request->numberFaraz;
        $messageRegister = $request->messageRegister;
        $array = [
            'messageAuth' =>$messageAuth,
            'userFaraz' =>$userFaraz,
            'passFaraz' =>$passFaraz,
            'numberFaraz' =>$numberFaraz,
            'messageRegister' =>$messageRegister,
            'messageSuccess' =>$messageSuccess,
            'messageSuggest' =>$messageSuggest,
            'messageCancel' =>$messageCancel,
            'messageBack' =>$messageBack,
            'messageManager' =>$messageManager,
            'messageCounseling' =>$messageCounseling,
            'messageStatus0' =>$messageStatus0,
            'messageStatus1' =>$messageStatus1,
            'messageStatus2' =>$messageStatus2,
            'messageStatus3' =>$messageStatus3,
            'messageTrack' =>$messageTrack,
            'userSms' =>$userSms,
            'passSms' =>$passSms,
            'kaveKey' =>$kaveKey,
            'smsType' =>$typeSms,
        ];
        foreach ($array as $key=>$item){
            $setting = Setting::where('key' , $key)->first();
            if ($setting != ''){
                $setting->update([
                    'value'=>$item,
                ]);
            }
        }
        return redirect()->back()->with([
            'message' => 'اطلاعات ثبت شد'
        ]);
    }

    public function floatIndex(){
        $floats = FloatAccess::get();
        return view('admin.setting.float',compact('floats'));
    }

    public function scriptIndex(){
        $headScript = Setting::where('key' , 'headScript')->pluck('value')->first();
        $bodyScript = Setting::where('key' , 'bodyScript')->pluck('value')->first();
        return view('admin.setting.script',compact('headScript','bodyScript'));
    }

    public function scriptUpdate(Request $request){
        $headScript = $request->headScript;
        $bodyScript = $request->bodyScript;
        $array = [
            'headScript' => $headScript,
            'bodyScript' => $bodyScript,
        ];
        foreach ($array as $key=>$item){
            $setting = Setting::where('key' , $key)->first();
            if ($setting != ''){
                $setting->update([
                    'value'=>$item,
                ]);
            }
        }
        return redirect()->back()->with([
            'message' => 'اطلاعات ثبت شد'
        ]);
    }

    public function fileIndex(){
        $lightHomeCss = File::get($_SERVER['DOCUMENT_ROOT'].'/css/home.css');
        $sellerCss = File::get($_SERVER['DOCUMENT_ROOT'].'/css/seller.css');
        $adminCss = File::get($_SERVER['DOCUMENT_ROOT'].'/css/admin.css');
        $robot = File::get($_SERVER['DOCUMENT_ROOT'].'/robots.txt');
        $htaccess = File::get($_SERVER['DOCUMENT_ROOT'].'/.htaccess');
        return view('admin.setting.file',compact('lightHomeCss','sellerCss','adminCss','robot','htaccess'));
    }

    public function fileUpdate(Request $request){
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/css/home.css',$request->lightHomeCss);
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/css/seller.css',$request->sellerCss);
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/css/admin.css',$request->adminCss);
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/robots.txt',$request->robot);
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/.htaccess',$request->htaccess);
        return redirect()->back()->with([
            'message' => 'اطلاعات ثبت شد'
        ]);
    }

    public function changeCache(Request $request){
        if($request->type){
            if($request->num == 0){
                Artisan::call('route:cache');
            }
            if($request->num == 1){
                Artisan::call('config:cache');
            }
            if($request->num == 2){
                Artisan::call('view:cache');
            }
        }else{
            if($request->num == 0){
                Cache::flush();
                Artisan::call('cache:clear');
            }
            if($request->num == 1){
                Artisan::call('route:clear');
            }
            if($request->num == 2){
                Artisan::call('config:clear');
            }
            if($request->num == 3){
                Artisan::call('view:clear');
            }
            if($request->num == 4){
                Artisan::call('optimize:clear');
            }
        }
    }

    public function paymentIndex(){
        $zarinpal = Setting::where('key' , 'zarinpal')->pluck('value')->first();
        $zibal = Setting::where('key' , 'zibal')->pluck('value')->first();
        $idpay = Setting::where('key' , 'idpay')->pluck('value')->first();
        $nextpay = Setting::where('key' , 'nextpay')->pluck('value')->first();
        $merchantPasargad = Setting::where('key' , 'merchantPasargad')->pluck('value')->first();
        $terminalPasargad = Setting::where('key' , 'terminalPasargad')->pluck('value')->first();
        $certificatePasargad = Setting::where('key' , 'certificatePasargad')->pluck('value')->first();
        $terminalAsan = Setting::where('key' , 'terminalAsan')->pluck('value')->first();
        $userAsan = Setting::where('key' , 'userAsan')->pluck('value')->first();
        $passwordAsan = Setting::where('key' , 'passwordAsan')->pluck('value')->first();
        $terminalBeh = Setting::where('key' , 'terminalBeh')->pluck('value')->first();
        $userBeh = Setting::where('key' , 'userBeh')->pluck('value')->first();
        $passwordBeh = Setting::where('key' , 'passwordBeh')->pluck('value')->first();
        $keySadad = Setting::where('key' , 'keySadad')->pluck('value')->first();
        $merchantSadad = Setting::where('key' , 'merchantSadad')->pluck('value')->first();
        $terminalSadad = Setting::where('key' , 'terminalSadad')->pluck('value')->first();
        $choicePay = Setting::where('key' , 'choicePay')->pluck('value')->first();
        $zarinpalStatus = Setting::where('key' , 'zarinpalStatus')->pluck('value')->first();
        $zibalStatus = Setting::where('key' , 'zibalStatus')->pluck('value')->first();
        $nextpayStatus = Setting::where('key' , 'nextpayStatus')->pluck('value')->first();
        $idpayStatus = Setting::where('key' , 'idpayStatus')->pluck('value')->first();
        $statusBeh = Setting::where('key' , 'statusBeh')->pluck('value')->first();
        $statusSadad = Setting::where('key' , 'statusSadad')->pluck('value')->first();
        $statusAsan = Setting::where('key' , 'statusAsan')->pluck('value')->first();
        $statusPasargad = Setting::where('key' , 'statusPasargad')->pluck('value')->first();
        $cardText = Setting::where('key' , 'cardText')->pluck('value')->first();
        $samansep = Setting::where('key' , 'samansep')->pluck('value')->first();
        $statusSaman = Setting::where('key' , 'statusSaman')->pluck('value')->first();
        return view('admin.setting.payment' , compact('zarinpal','choicePay','merchantPasargad','samansep','statusSaman','terminalPasargad','certificatePasargad','statusPasargad','zarinpalStatus','statusAsan','terminalAsan','userAsan','passwordAsan','zibalStatus','nextpayStatus','idpayStatus','statusBeh','statusSadad','terminalBeh','userBeh','passwordBeh','keySadad','merchantSadad','terminalSadad','cardText','zibal','idpay','nextpay'));
    }

    public function paymentUpdate(Request $request){
        $zarinpal = $request->zarinpal;
        $zibal = $request->zibal;
        $idpay = $request->idpay;
        $nextpay = $request->nextpay;
        $terminalAsan = $request->terminalAsan;
        $userAsan = $request->userAsan;
        $passwordAsan = $request->passwordAsan;
        $terminalBeh = $request->terminalBeh;
        $userBeh = $request->userBeh;
        $passwordBeh = $request->passwordBeh;
        $keySadad = $request->keySadad;
        $merchantSadad = $request->merchantSadad;
        $terminalSadad = $request->terminalSadad;
        $merchantPasargad = $request->merchantPasargad;
        $terminalPasargad = $request->terminalPasargad;
        $certificatePasargad = $request->certificatePasargad;
        $choicePay = $request->choicePay;
        $samansep = $request->samansep;
        $zarinpalStatus = $request->zarinpalStatus ? 1 : 0;
        $zibalStatus = $request->zibalStatus ? 1 : 0;
        $nextpayStatus = $request->nextpayStatus ? 1 : 0;
        $idpayStatus = $request->idpayStatus ? 1 : 0;
        $statusBeh = $request->statusBeh ? 1 : 0;
        $statusSadad = $request->statusSadad ? 1 : 0;
        $statusAsan = $request->statusAsan ? 1 : 0;
        $statusPasargad = $request->statusPasargad ? 1 : 0;
        $statusSaman = $request->statusSaman ? 1 : 0;
        $array = [
            'zarinpal' =>$zarinpal,
            'zibal' =>$zibal,
            'idpay' =>$idpay,
            'nextpay' =>$nextpay,
            'terminalAsan' =>$terminalAsan,
            'userAsan' =>$userAsan,
            'passwordAsan' =>$passwordAsan,
            'terminalBeh' =>$terminalBeh,
            'userBeh' =>$userBeh,
            'passwordBeh' =>$passwordBeh,
            'keySadad' =>$keySadad,
            'merchantSadad' =>$merchantSadad,
            'terminalSadad' =>$terminalSadad,
            'merchantPasargad' =>$merchantPasargad,
            'terminalPasargad' =>$terminalPasargad,
            'certificatePasargad' =>$certificatePasargad,
            'statusPasargad' =>$statusPasargad,
            'choicePay' =>$choicePay,
            'zarinpalStatus' => $zarinpalStatus,
            'zibalStatus' => $zibalStatus,
            'nextpayStatus' => $nextpayStatus,
            'idpayStatus' => $idpayStatus,
            'statusBeh' => $statusBeh,
            'statusSadad' => $statusSadad,
            'statusAsan' => $statusAsan,
            'samansep' => $samansep,
            'statusSaman' => $statusSaman,
        ];
        foreach ($array as $key=>$item){
            $setting = Setting::where('key' , $key)->first();
            if ($setting != ''){
                $setting->update([
                    'value'=>$item,
                ]);
            }
        }
        return redirect()->back()->with([
            'message' => 'اطلاعات ثبت شد'
        ]);
    }
}
