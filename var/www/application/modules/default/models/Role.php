<?php

class Default_Model_Role {

    public static function create($data) {
        $role = new Default_Model_DbTable_Role();
        return $role->insert($data);
    }

    public static function read($id = null, $pager = false, $where = null, $order = null) {
        $role = new Default_Model_DbTable_Role();
        if(!is_null($id)) {
            return $role->find($id)->current()->toArray();
        } else {
            $query = $role->select();
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            } else {
                $query->order('role_name');
            }

            if($pager == false) {
                return $role->fetchAll($query)->toArray();
            } else {
                return $query;
            }
        }
    }

    public static function update($data) {
        $role = new Default_Model_DbTable_Role();
        $where = $role->getAdapter()->quoteInto('role_id = ?', $data['role_id']);
        unset($data['role_id']);
        return $role->update($data, $where);
    }

    public static function delete($id) {
        $role = new Default_Model_DbTable_Role();
        $where = $role->getAdapter()->quoteInto('role_id = ?', $id);
        return $role->delete($where);
    }

}

