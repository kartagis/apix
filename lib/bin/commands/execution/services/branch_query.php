<?php
/*
 * This file is main part of the mobi service.
 *
 * every request is called index method as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\__projectName__\v1\__call\__serviceName__\branches\query\__requestName__;
use src\services\httprequest as request;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class __className__ extends \src\app\__projectName__\v1\__call\__serviceName__\app {

    public $request;

    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct(request $request){

        //get request info
        parent::__construct();
        $this->request=$request;

    }

    /**
     * index method is main method.
     *
     * @return array
     */
    public function get(){

        //return source
        return [
            'source'=>'__projectName__ query __serviceName__ __className__ __requestName__'
        ];
    }
}