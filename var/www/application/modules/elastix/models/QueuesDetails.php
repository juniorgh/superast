<?php

/** 
 * Modelo de execução de transações de dados entre a aplicação e a
 * tabela `asterisk`.`queues_details` do banco de dados
 * @package Elastix
 * @category Model
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Elastix_Model_QueuesDetails {

    private $dbAdapter;

    public function __construct($db) {
        $this->dbAdapter = $db;
    }

    public function read($id = null, $pager = false, array $where = null, array $order = null) {
        $queuesDetails = new Elastix_Model_DbTable_QueuesDetails($this->dbAdapter);
        if(!is_null($id)) {
            return $queuesDetails->find($id)->toArray();
        } else {
            $query = $queuesDetails->select()->setIntegrityCheck(false);

            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            }

            return $pager === false ? $queuesDetails->fetchAll($query)->toArray() : $query;
        }
    }

    public function readMembers($id = null) {
        $queuesDetails = new Elastix_Model_DbTable_QueuesDetails($this->dbAdapter);
        $query = $queuesDetails->select()->setIntegrityCheck(false)->where('keyword = ?', 'member')->where('id = ?', $id);
        return $queuesDetails->fetchAll($query)->toArray();
    }


}