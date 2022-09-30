<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Curl\Curl;
use voku\helper\HtmlDomParser;
use Whitecube\LaravelPrices\Models\Price;


class ScrapeController extends Controller
{

    private function scrape_top_posts(): array
    {
        $curl = new Curl();
        $curl->get('https://www.list.am/category/23');


        $html = $curl->response;
        $htmlDomParser = HtmlDomParser::str_get_html($html);

        $topProductDataList = [];

        $productElements = $htmlDomParser->findOne("#tp > div.dl > div.gl");
        foreach ($productElements as $productElement) {
            $image = $productElement->findOne("img")->getAttribute("src");
            $name = $productElement->findOne(".p")->text;
            $price = $productElement->findOne(".l")->text;
            $location = $productElement->findOne(".at")->text;

            $productData = array(
                "image" => $image,
                "name" => $price,
                "price" => $name,
                'location' => $location
            );

            //convert amd to usd

            $dram = 413;
            $amd  =  mb_substr($name, -1);
            if ($amd == '֏'){
                $amdUpd = rtrim($name, " ֏",);
                $var2 = str_replace(",", "", $amdUpd);
                $convert = $var2 / $dram;
                $productData['price'] = '$' . floor($convert);
            }

        $topProductDataList[] = $productData;

        }


        //get Top posts list.am
        // return response()->json($topProductDataList) ;
        return $topProductDataList;
    }

    public function scrape_all_posts()
    {
        $curl = new Curl();
        $curl->get('https://www.list.am/category/23');


        $html = $curl->response;
        $htmlDomParser = HtmlDomParser::str_get_html($html);


        $productDataList = [];

        $productElements = $htmlDomParser->findOne("#contentr > div.dl > div.gl");
        foreach ($productElements as $productElement) {
            $image = $productElement->findOne("img")->getAttribute("data-original");
            $name = $productElement->findOne(".p")->text;
            $price = $productElement->findOne(".l")->text;
            $location = $productElement->findOne(".at")->text;

            $productData = array(
                "image" => $image,
                "name" => $price,
                "price" => $name,
                'location' => $location
            );
            //convert amd to usd
            $dram = 413;
            $amd  =  mb_substr($name, -1);
            if ($amd == '֏'){
                $amdUpd = rtrim($name, " ֏",);
                $var2 = str_replace(",", "", $amdUpd);
                $convert = $var2 / $dram;
                $productData['price'] = '$' . floor($convert);
            }

            $productDataList[] = $productData;
        }
        //get all posts list.am
        //return response()->json($productDataList);

        $topProductDataList = $this->scrape_top_posts();

        return view('welcome', compact('productDataList', 'topProductDataList'));

    }

}
