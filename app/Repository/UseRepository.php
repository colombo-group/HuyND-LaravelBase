<?php

namespace App\Repository;

use App\Repository\Repository;
use App\User;
use Illuminate\Container\Container as App;

abstract class UseRepository implements Repository
{
    /**
    * @var Model $model
     */
    protected $model;

    /**
    * @var App $app
     */
    private $app;

    /**
    * @param App $app
     *
     * @return Model
     */
    public function __construct(App $app)
    {
        $this->app=$app;
        $this->makeModel();
    }

    /**
    * get name of model
     *
     * @return mixed
     */
    abstract function model();

    /**
    * @return Model
     */
    public function makeModel(){
        $model=$this->app->make($this->model());
        return $this->model=$model;
    }

    /**
    * get all record
     *
     * @return object
     */
    public function getAll($record)
    {
        return $this->model->paginate($record);
    }

    /**
    * get some records with some conditions and paginate them
     *
     * @return object
     */
    public function getRecordWithCondition(string $col,string $condition , $val=null,$recordPerPage)
    {
        return $this->model->where($col,$condition,$val)->paginate($recordPerPage);
    }

    /**
    * get all softing deleted record
     */
    public function getDeletedRecord($RecordPerPage)
    {
        return $this->model->onlyTrashed()->paginate($RecordPerPage);
    }

    /**
    * get one softing deleted record with a condition
     */
    public function getOneDeletedRecord(string $col,$val)
    {
        return $this->model->withTrashed()->where($col,'=',$val)->count();
    }

    /**
    * check whether value existed or not
     */
    public function checkConcidence($id, string $col, $val)
    {
        return $this->model->where('id','<>',$id)->where($col,'=',$val)->count();
    }

    /**
    * create new record
     *
     * @return object
     */
    public function create(array $attr){
        return $this->model->create($attr);
    }

    /**
    * edit record's infor
     *
     * @param array $attr new infor
     * @param integer $id
     * @return Query
     */
    public function update(array $attr,$id){
        return $this->model->where('id',$id)->update($attr);
    }

    /**
    * delete a record
     */
    public function delete($id){
        return $this->model->where('id',$id)->delete();
    }

    /**
    * count number of record
     *
     * @param string $col name of column
     * @param string $condition
     * @param string|integer $val
     *
     * @return object
     */
    public function  count(string $col,$condition, $val)
    {
        return $this->model->where($col,$condition ,$val)->count();
    }

    /**
    * get one record
     *
     * @param string $col
     * @param string|integer
     *
     * @return object
     */
    public function getOneRecord(string $col, $val)
    {
        return $this->model->where($col,$val)->first();
    }

    /**
    * delete record tempororyly
     *
     * @return Query
     */
    public function softDel($id)
    {
        return $this->model->where('id',$id)->delete();
    }

    /**
    * delete record forever
     * @return Query
     */
    public function forceDel($id){
        return $this->model->where('id', $id)->forceDelete();;
    }
    /**
    * restore record
     *
     * @return Query
     */
    public function restore($id){
        return $this->model->withTrashed()->where('id',$id)->restore();
    }
}