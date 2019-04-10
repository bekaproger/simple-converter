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

/**
 * Class CurrencyService
 * @package App\Services
 */
class CurrencyService
{

    /**
     * @var Client
     */
    protected $http;
    /**
     * @var string
     */
    protected $url = 'http://www.cbr.ru/scripts/XML_daily.asp';

    /**
     * CurrencyService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->http = $client;
    }

    /**
     * Main method - Update currencies
     */
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

    /**
     * Make float value from string separated by ','
     *
     * @param string $rate
     * @return float
     */
    protected function makeRate(string $rate)
    {
        $exploded = explode(',', $rate);

        return (float)implode('.', $exploded);
    }

    /**
     * Make request to provided url
     *
     * @return \SimpleXMLElement
     */
    protected function getCurrencies()
    {
        $body = $this->http->get($this->url)->getBody();

        return new \SimpleXMLElement($body);

    }

}