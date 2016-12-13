<?php
/**
 * container app controller
 * it is mainly service app provider for service
 * service app provider
 */

namespace src\app\fussy\v1\config;


class app
{

    /**
     * project app.
     *
     * static call access for every service.
     *
     * @param string
     * @return response container runner
     */
    public function container(){

        return [

            'base' =>'\\src\\app\\fussy\\v1\\serviceBaseController'
        ];

    }
}