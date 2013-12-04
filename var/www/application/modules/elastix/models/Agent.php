<?php

class Elastix_Model_Agent {

    private $dbAdapter;

    public function __construct($db) {
        $this->dbAdapter = $db;
    }

    public function read($id = null, $pager = false, array $where = null, array $order = null) {
        $agent = new Elastix_Model_DbTable_Agent($this->dbAdapter);
        if(!is_null($id)) {
            return $agent->find($id)->current();
        } else {
            $query = $agent->select()->setIntegrityCheck(false);

            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            }

            return $pager === false ? $agent->fetchAll($query)->toArray() : $query;
        }
    }

}

