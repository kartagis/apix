<?php
/*
 * This file is main part of the sudb.
 *
 * model is called for model file as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services\sudb;
use \src\services\sudb\querySqlFormatter as querySqlFormatter;
use \src\services\sudb\selectBuilderOperation as selectBuilderOperation;
use \src\services\sudb\whereBuilderOperation as whereBuilderOperation;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class builder {


    private $model=null;
    private $select="*";
    private $find=null;
    private $where=[];
    private $page=0;
    private $order=null;
    private $execute=[];
    private $querySqlFormatter;
    private $selectBuilderOperation;
    private $whereBuilderOperation;
    private $subClassOf=null;

    private static $primarykey_static=null;
    private static $modelscope=null;
    private static $request=null;
    private static $toSql=null;
    private static $rand=null;
    private static $all=null;
    private static $callstatic_scope=[];
    private static $join=null;
    private static $joinType=null;
    private static $joinTypeField=null;
    private static $hasMany=null;
    private static $attach=null;
    private static $sum=null;
    private static $joiner='';
    private static $whereIn=null;
    private static $whereNotIn=null;
    private static $orWhere=[];
    private static $whereColumn=[];
    private static $whereYear=[];
    private static $whereMonth=[];
    private static $whereDay=[];
    private static $whereDate=[];
    private static $addToSelectSql=null;
    private static $having=[];

    public function __construct(querySqlFormatter $querySqlFormatter,selectBuilderOperation $selectBuilderOperation,whereBuilderOperation $whereBuilderOperation){
        $this->querySqlFormatter=$querySqlFormatter;
        $this->selectBuilderOperation=$selectBuilderOperation;
        $this->whereBuilderOperation=$whereBuilderOperation;
    }

    /**
     * select method is main method.
     *
     * @return array
     */
    public function select($select=null,$model){
        $this->model=$model;
        if(is_array($select) && array_key_exists(0,$select)){
            $this->select=$select[0];
        }
        return $this;
    }


    /**
     * where method is main method.
     *
     * @return array
     */
    public function where($field=null,$operator=null,$value=null,$model=null){
        if(is_callable($field)){
            if($operator!==null){
                $this->model=$operator;
            }
            call_user_func_array($field,[$this->model]);
        }
        else{
            if($field!==null && $operator!==null && $value!==null){
                if($this->model==null){
                    $this->model=$model;
                }

                $this->where['field'][]=$field;
                $this->where['operator'][]=$operator;
                $this->where['value'][]=$value;
            }

        }


        return $this;
    }


    /**
     * query order by.
     *
     * @return pdo class
     */
    public function orderBy($key=null,$order=null,$model=null){

        if($this->model==null){
            $this->model=$model;
        }

        if($key!==null && is_array($key)){

            $this->order=['key'=>$key[0],'order'=>$key[1]];
        }
        else{
            $this->order=['key'=>$key,'order'=>$order];
        }
        return $this;

    }

    /**
     * paginate method is main method.
     *
     * @return array
     */
    public function paginate($paginate=null){
        if(is_numeric($paginate[0])){
            $this->page=$paginate[0];
        }

        return $this;
    }

    /**
     * get method is main method.
     *
     * @return array
     */
    public function get(){
        return $this->allMethodProcess(function(){
            return ['data'=>$this->queryFormatter()];
        });

    }

    /**
     * get method is main method.
     *
     * @return array
     */
    public function queryFormatter(){
        return $this->querySqlFormatter->getSqlPrepareFormatter($this->SqlPrepareFormatterHandleObject());
    }

    /**
     * subClassOf method is main method.
     *
     * @return array
     */
    public function subClassOf($class){
        $this->subClassOf=$class;
    }

    /**
     * subClassOf method is main method.
     *
     * @return array
     */
    public function SqlPrepareFormatterHandleObject(){
        return [
            'model'=>$this->subClassOf,
            'select'=>$this->select,
            'where'=>$this->where,
            'execute'=>$this->execute,
            'paginate'=>$this->page,
            'orderBy'=>$this->order
        ];
    }

    /**
     * allmethodprocess method is main method.
     *
     * @return array
     */
    private function allMethodProcess($callback){
        $this->select=$this->selectBuilderOperation->selectMainProcess($this->select,$this->SqlPrepareFormatterHandleObject());
        $whereOperation=$this->whereBuilderOperation->whereMainProcess($this->where,$this->SqlPrepareFormatterHandleObject());
        $this->where=$whereOperation->where;
        $this->execute=$whereOperation->execute;
        return call_user_func($callback);
    }
}