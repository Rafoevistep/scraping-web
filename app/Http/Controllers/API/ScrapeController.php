<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Curl\Curl;
use voku\helper\HtmlDomParser;


class ScrapeController extends Controller
{

    public function scrape_top_posts()
    {
        $curl = new Curl();
        $curl->get('https://www.list.am/category/23');


        $html = $curl->response;
        $htmlDomParser = HtmlDomParser::str_get_html($html);

        $productDataList[] = array();

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

            $productDataList[] = $productData;
        }
        //get Top posts list.am
        return response()->json($productDataList);

//    return view('welcome', ['productDataList'=>$productDataList]);

    }

    public function scrape_all_posts()
    {
        $curl = new Curl();
        $curl->get('https://www.list.am/category/23');


        $html = $curl->response;
        $htmlDomParser = HtmlDomParser::str_get_html($html);


        $productDataList[] = array();

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

            $productDataList[] = $productData;
        }

        //get all posts list.am
        return response()->json($productDataList);

//    return view('welcome', ['productDataList'=>$productDataList]);

    }

}
