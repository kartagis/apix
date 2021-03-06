<?php
/*
 * This file is client and http request of the guzzle service.
 *
 * client and guzzle http request
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services;
use GuzzleHttp\Client as Client;

/**
 * Represents a redis class.
 *
 * main call
 * return type string
 */

class guzzle {

    public $client;

    /**
     * guzzle class.
     *
     * @return guzzle class
     */
    public function __construct(){

        //redis client
        $this->client=new Client();
    }


    /**
     * guzzle http request get data.
     *
     * @return guzzle class
     */
    public function get($url=null,$responseObject=null){
        //get response guzzle
        $response = $this->client->request("GET",$url,[]);
        if($responseObject==null){
            return json_decode($response->getBody()->getContents(),1);
        }
    }

    /**
     * guzzle http request post data.
     *
     * @return guzzle class
     */
    public function post($url=null,$postdata=array(),$responseObject=null){
        //get response guzzle
        $response = $this->client->request("POST",$url,[
            'form_params'=>$postdata
        ]);
        if($responseObject==null){
            return json_decode($response->getBody()->getContents(),1);
        }
    }




}
