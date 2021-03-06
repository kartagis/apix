# Model File Content (it is for example)

```
<?php
namespace src\app\mobi\v1\model;

class user extends \src\services\sudb\src\model {

    //tablename
    public $table='users';

    //primary key
    public $primaryKey='id';

    //this value is run for auto paginator
    public $paginator=['auto'=>10];

    //this value is run for auto order by desc
    public $orderBy=['auto'=>['id'=>'desc']];

    //query result with this value is called from redis
    public $redis=['status'=>false,'expire'=>60];

    //this value is created and updated time for values it will be inserted
    public $createdAndUpdatedFields=['created_at'=>'createdAt','updated_at'=>'updatedAt'];

    //this value is run for auto join type (left|inner)
    //protected $joiner=['auto'=>"left"];

    //this value is similar field that on the joined tables
    /*protected $joinField=['books'=>['match'=>'BookId','joinField'=>['bookname','status/bookstatus']],
        'chats'=>['hasOne'=>'userid','joinField'=>['message']]
    ];*/

    //this value hiddens  to select field
    //public $selectHidden=['id'];

    //insert conditions
    public $insertConditions=[
        'status'=>true,
        'wantedFields'=>[],
        'exceptFields'=>[],
        'obligatoryFields'=>[],
        'queueFields'=>[]
    ];

    //update conditions
    public $updateConditions=[
        'status'=>false,
        'wantedFields'=>[],
        'exceptFields'=>[],
        'obligatoryFields'=>[],
        'queueFields'=>[]
    ];

    //select permissions for client
    //header select id::username
    public $selectPermissions=[
        'status'=>false,
        'authorized'=>'*',
        'forbidden'=>[],
        'tokens'=>'*',
        'seperator'=>'::'
    ];

    //this scope is automatically run
    //public $scope=['auto'=>'active'];

    //scope query
    /**
     * @param $data
     * @param $query
     */
    public function modelScope($data,$query){

        //id scope
        if($data=="id"){
            $query->where(function($model){
                if(\app::checkUrlParam("id")){
                    $model->where("id","=",\app::getUrlParam("id"));
                }
            });
        }

        //active scope
        if($data=="active"){
            $query->where("status","=",1);
        }

    }

    /**
     * @param field query
     * @param $string
     */
    /*public function fieldPassword(){
        return md5(\app::post("password"));
    }*/


}

```
