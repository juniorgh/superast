<?php

class Telephony_Model_Queue {

    public static function create($data) {
        $queue = new Telephony_Model_DbTable_Queue();
        return $queue->insert($data);
    }

    public static function read($id = null, $pager = false, $where = null, $order = null) {
        $queue = new Telephony_Model_DbTable_Queue();
        if(!is_null($id)) {
            return $queue->find($id)->current()->toArray();
        } else {
            $query = $queue->select();
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            } else {
                $query->order('queue_name');
            }

            if($pager == false) {
                return $queue->fetchAll($query)->toArray();
            } else {
                return $query;
            }
        }
    }

    public static function update($data) {
        $queue = new Telephony_Model_DbTable_Queue();
        $where = $queue->getAdapter()->quoteInto('queue_id = ?', $data['queue_id']);
        unset($data['queue_id']);
        return $queue->update($data, $where);
    }

    public static function delete($id) {
        $queue = new Telephony_Model_DbTable_Queue();
        $where = $queue->getAdapter()->quoteInto('queue_id = ?', $id);
        return $queue->delete($where);
    }

}