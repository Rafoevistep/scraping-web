<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Curl\Curl;
use voku\helper\HtmlDomParser;


class ScrapeController extends Controller
{

    private function scrape_top_posts(): array
    {
        $curl = new Curl();

        $curl->get('https://www.list.am/category/23');

        $html = $curl->response;
        $htmlDomParser = HtmlDomParser::str_get_html($html);

        $topItemDataList = [];

        $itemElements = $htmlDomParser->findOne("#tp > div.dl > div.gl");
        foreach ($itemElements as $itemElement) {
            $image = $itemElement->findOne("img")->getAttribute("src");
            $topItemDataList = $this->getTopItemDataList($itemElement, $image, $topItemDataList);
        }

        //get Top posts list.am
        // return response()->json($topItemDataList) ;
        return $topItemDataList;
    }

    public function scrape_all_posts()
    {
        $curl = new Curl();
        $curl->get('https://www.list.am/category/23');

        $html = $curl->response;
        $htmlDomParser = HtmlDomParser::str_get_html($html);

        $itemDataList = [];

        $itemElements = $htmlDomParser->findOne("#contentr > div.dl > div.gl");
        foreach ($itemElements as $itemElement) {
            $image = $itemElement->findOne("img")->getAttribute("data-original");
            $itemDataList = $this->getTopItemDataList($itemElement, $image, $itemDataList);
        }

        //get all posts list.am
        //return response()->json($itemDataList);

        $topItemDataList = $this->scrape_top_posts();

        return view('welcome', compact('topItemDataList', 'itemDataList'));

    }

    /**
     * @param $itemElement
     * @param $image
     * @param array $topItemDataList
     * @return array
     */
    private function getTopItemDataList($itemElement, $image, array $topItemDataList): array
    {
        $name = $itemElement->findOne(".p")->text;
        $price = $itemElement->findOne(".l")->text;
        $location = $itemElement->findOne(".at")->text;

        $itemData = array(
            "image" => $image,
            "name" => $price,
            "price" => $name,
            'location' => $location
        );

        //convert amd to usd

        $dram = 413;
        $amd = mb_substr($name, -1);
        if ($amd == '֏') {
            $amdUpd = rtrim($name, " ֏",);
            $var2 = str_replace(",", "", $amdUpd);
            $convertAmd = $var2 / $dram;
            $itemData['price'] = '$' . number_format($convertAmd);
        }

        $topItemDataList[] = $itemData;
        return $topItemDataList;
    }

}
