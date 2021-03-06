<?php
/*
 * This file is main part of the search.
 *
 * model is called for search file as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\packages\providers\search;

/**
 * Represents a search class.
 *
 * main call
 * return type array
 */

class search implements searchInterface {


    /**
     * get construct.
     *
     */
    public function __construct(){
    }

    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function runEngineHandle($driver=null){
        if($driver===null){
            $serviceBase='src\\app\\'.app.'\\'.version.'\\serviceBaseController';
            $serviceBaseResolve=\app::resolve($serviceBase);
            $searchDriver=$serviceBaseResolve->search;
        }
        else{
            $searchDriver=$driver;
        }

        $search='src\\packages\\providers\\search\\'.$searchDriver.'\\search';
        return \app::resolve($search);
    }



}