<?php

class Elastix_Model_QueuesConfig {

    private $dbAdapter;

    public function __construct($db) {
        $this->dbAdapter = $db;
    }

    public function read($extension = null, $pager = false, array $where = null, array $order = null) {
        $queuesConfig = new Elastix_Model_DbTable_QueuesConfig($this->dbAdapter);

        if(!is_null($extension)) {
            $query = $queuesConfig->select()->setIntegrityCheck(false)->where('extension = ?', $extension);
            return $query->fetchRow($query)->current();
        } else {
            $query = $queuesConfig->select()->setIntegrityCheck(false);

            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            }

            return $pager === false ? $queuesConfig->fetchAll($query)->toArray() : $query;
        }
    }

}