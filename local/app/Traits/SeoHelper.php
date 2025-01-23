<?php


namespace App\Traits;


use App\Models\Setting;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

trait SeoHelper
{
    public function setIndexSeo(){
        $title = Setting::where('key' , 'titleSeo')->pluck('value')->first() ?:'' ;
        $name = Setting::where('key' , 'name')->pluck('value')->first() ?:'' ;
        $shortActivity = Setting::where('key' , 'aboutSeo')->pluck('value')->first() ?:'' ;
        $keyword = Setting::where('key' , 'keyword')->pluck('value')->first() ?: [] ;
        if ($keyword){
            $keywordFinal = explode(',' , $keyword) ;
        }else{
            $keywordFinal = [];
        }
        $logoSite = Setting::where('key' , 'logo')->pluck('value')->first() ?:'' ;
        SEOTools::setDescription($shortActivity);
        SEOMeta::addKeyword($keywordFinal);
        SEOTools::opengraph()->addProperty('type', 'store');
// Twitter
        SEOTools::twitter()->setSite($title);
        SEOTools::twitter()->setDescription($shortActivity);
        SEOTools::twitter()->setTitle($title);
        SEOTools::twitter()->setImage(url($logoSite));
        SEOTools::twitter()->addValue('image:alt', $title);
        SEOTools::twitter()->addValue('card', 'summary');
// JSON-LD
        SEOTools::jsonLd()->setTitle($title);
        SEOTools::jsonLd()->setDescription($shortActivity);
        SEOTools::jsonLd()->setType('WebSite');
        SEOTools::jsonLd()->addValues([
            'url' => url(''),
            'potentialAction' => [
                '@type' => "SearchAction",
                'target' => url('') . "search?search={search}",
                'query-input' => "required name=search"
            ]
        ]);
// OpenGraph
        OpenGraph::addProperty('locale', 'fa');
        OpenGraph::setSiteName($name);
        OpenGraph::setTitle($title);
        OpenGraph::setDescription($shortActivity);
        OpenGraph::setUrl(url(''));
// JSON-LD
        JsonLd::setTitle($title);
        JsonLd::setDescription($shortActivity);
        JsonLd::setType('store');
        JsonLd::addImage(url($logoSite));
    }

    public function seoSingleSeo($title , $description , $type , $url , $image,$keyword){
        $titleSite = Setting::where('key' , 'titleSeo')->pluck('value')->first() ?:'' ;
        $logoSite = Setting::where('key' , 'logo')->pluck('value')->first() ?:'' ;
        $shortActivity = Setting::where('key' , 'aboutSeo')->pluck('value')->first() ?:'' ;
        if ($keyword){
            $keywordFinal = explode(',' , $keyword) ;
        }else{
            $keywordFinal = [];
        }
        $url = $url??'/';
        $image = $image??$logoSite;
        $description = $description??$shortActivity;
        $name = Setting::where('key' , 'name')->pluck('value')->first() ?:'' ;
        SEOTools::opengraph()->setUrl(url($url));
        SEOTools::setCanonical(url($url));
        SEOTools::setDescription($description);
        SEOMeta::addKeyword($keywordFinal);
        SEOTools::opengraph()->addProperty('type', 'WebSite');
//twitter
        SEOTools::twitter()->setSite($titleSite);
        SEOTools::twitter()->setDescription($description);
        SEOTools::twitter()->setTitle($title);
        SEOTools::jsonLd()->addImage(url($image));
        SEOTools::jsonLd()->setTitle($title);
        SEOTools::jsonLd()->setUrl(url($url));
        SEOTools::jsonLd()->setDescription($description);
        SEOTools::jsonLd()->setType('WebSite');
        SEOTools::jsonLd(['aggregateRating' => [
            '@type' => 'AggregateRating',
            'ratingValue' => '5',
            'reviewCount' => 20
        ]]);
        SEOTools::twitter()->setImage(url($image));
//OpenGraph
        OpenGraph::addProperty('locale', 'fa');
        OpenGraph::setSiteName($name);
        OpenGraph::addImage(url($image));
        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url($url));
        SEOTools::jsonLd()->setTitle($title);
        SEOTools::jsonLd()->setDescription($description);
        SEOTools::jsonLd()->setType('store');
        SEOTools::jsonLd()->addImage(url($image));
    }
}
