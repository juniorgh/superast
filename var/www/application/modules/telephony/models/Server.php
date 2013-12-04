<?php

class Telephony_Model_Server {

    public static function create($data) {
        $server = new Telephony_Model_DbTable_Server();
        return $server->insert($data);
    }

    public static function read($id = null, $pager = false, $where = null, $order = null) {
        $server = new Telephony_Model_DbTable_Server();
        if(!is_null($id)) {
            return $server->find($id)->current()->toArray();
        } else {
            $query = $server->select();
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            } else {
                $query->order('server_hostname');
            }

            if($pager == false) {
                return $server->fetchAll($query)->toArray();
            } else {
                return $query;
            }
        }
    }

    public static function update($data) {
        $server = new Telephony_Model_DbTable_Server();
        $where = $server->getAdapter()->quoteInto('server_id = ?', $data['server_id']);
        unset($data['server_id']);
        return $server->update($data, $where);
    }

    public static function delete($id) {
        $server = new Telephony_Model_DbTable_Server();
        $where = $server->getAdapter()->quoteInto('server_id = ?', $id);
        return $server->delete($where);
    }

}