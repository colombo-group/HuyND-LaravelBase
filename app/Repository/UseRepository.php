<?php

namespace App\Repository;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\User;
use App\News;
use Illuminate\Container\Container as App;


abstract class UseRepository implements RepositoryInterface
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
    * get all record and paginate
     *
     * @return object
     */
   public function paginate($limit = null, $columns = ['*'])
   {
       return $this->model->paginate($limit);
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
    public function findByField($field, $value, $columns = ['*'])
    {
        return $this->model->where($field,$value)->first();
    }

    /**
    * get one softing deleted record with a condition
     */
    public function getOneDeletedRecord(string $col,$val)
    {
        return $this->model->withTrashed()->where($col,'=',$val)->count();
    }

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function firstOrCreate(array $attributes = [])
    {
        return $this->model->firstOrCreate($attributes);
    }

    /**
    * edit record's infor
     *
     * @param array $attr new infor
     * @param integer $id
     * @return Query
     */
    public function update(array $attributes, $id)
    {
        return $this->model->where('id',$id)->update($attributes);
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
     * @param integer $id
     *
     * @return Query
     */
    public function Restore($id){
        return $this->model->withTrashed()->where('id',$id)->restore();
    }
    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id);
    }
}