<?php
/**
 * Created by PhpStorm.
 * User: Bekzod
 * Date: 10.04.2019
 * Time: 1:34
 */

namespace App\Services;


use App\Currency;
use GuzzleHttp\Client;

class CurrencyService
{

    protected $http;
    protected $url = 'http://www.cbr.ru/scripts/XML_daily.asp';

    public function __construct(Client $client)
    {
        $this->http = $client;
    }

    public function update()
    {
        $xml = $this->getCurrencies();
        foreach ($xml->Valute as $valute){
            $rate = $this->makeRate((string)$valute->Value);
            $curr = Currency::firstOrNew(['char_code' => (string)$valute->CharCode]);
            if($curr->rate !== $rate){
                $curr->char_code = (string)$valute->CharCode;
                $curr->rate = $rate;
                $curr->name = (string)$valute->Name;
                $curr->save();
            }else{
                continue;
            }
        }
    }

    protected function makeRate(string $rate)
    {
        $exploded = explode(',', $rate);

        return (float)implode('.', $exploded);
    }

    protected function getCurrencies()
    {
        $body = $this->http->get($this->url)->getBody();

        return new \SimpleXMLElement($body);

    }

}