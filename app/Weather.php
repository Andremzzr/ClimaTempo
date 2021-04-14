<?php

namespace App;

class Weather
{
    private $baseURI = "http://api.openweathermap.org/data/2.5";
    private $client;
    private $apiKey;


    public function __construct()
    {
        $this->apiKey = $_ENV['API_TOKEN'];
        $this->client = curl_init();
        curl_setopt($this->client, CURLOPT_RETURNTRANSFER, true);

    }
    
    /**
     * This Function gets only one forecast for each day
     * 
     * @param array $arrayPrevisoes
     * 
     * @return array $listaDePrevisoes
     */
    public static function getDayByDay(array $arrayPrevisoes){
           
            
                $listaDePrevisoes =[];


                foreach($arrayPrevisoes['list'] as $prevision){
                    if (count($listaDePrevisoes) == 0) {
                        $listaDePrevisoes[] = $prevision;
                    }
                    $data = $prevision['dt_txt'][8] . $prevision['dt_txt'][9];

                    $lastInArray = end($listaDePrevisoes);
                    $lastData = $lastInArray['dt_txt'][8] . $lastInArray['dt_txt'][9];

                    if ($data == $lastData)  {
                        continue;
                    }else{
                        $listaDePrevisoes[] = $prevision;
                    }
                }

                return $listaDePrevisoes;
           
                
    }


    /**
     * This method makes the connection with the api and returns to the user the informations 
     * 
     * @param string $name
     * 
     * @return array $listaDePrevisoesFinal
     */
    public function getWeatherByCity(string $name): array
    {
        
            $payload = http_build_query(
                [
                'q' => $name,
                'appId' => $this->apiKey
                ]
            );
            $uri = $this->baseURI . "/forecast?" . $payload;

            curl_setopt($this->client, CURLOPT_URL, $uri);
            $result = json_decode(curl_exec($this->client), true);

           $listaDePrevisoes = Weather::getDayByDay($result);
            if ($listaDePrevisoes == false) {
                return false;
            }else{
           $listaDePrevisoesFinal =  array();
           foreach($listaDePrevisoes as $value){
               $listaDePrevisoesFinal[]= [
                   'temp_min' => round($value['main']['temp_min'] -273.15, 0),
                   'temp_max' => round($value['main']['temp_max'] -273.15, 0),
                   'humidity' => $value['main']['humidity'],
                   'pop' => $value['pop'],
                   'weather' => $value['weather'][0]['main'] . ', ' . $value['weather'][0]['description'],
                   'date' => substr($value['dt_txt'],0,10)
               ];
           }

           return $listaDePrevisoesFinal;
            
        }

    }

}