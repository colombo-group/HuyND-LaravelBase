<?php

namespace App\Repository;

interface Repository {
    public function getAll($record);
    

    public function getRecordWithCondition(string $col,string $condition , $val=null,$recordPerPage);

    public function create(array $attr);

    public function update(array $attr, $id);

    public function delete($id);

    public function count(string $col,$condition, $val);
    
    public function getDeletedRecord($RecordPerPage);
    
    public function getOneDeletedRecord(string $col,$val);
    
    public function checkConcidence($id,string $col,$val);

    public function getOneRecord(string $col, $val);

    public function softDel($id);

    public function forceDel($id);

    public function restore($id);
}