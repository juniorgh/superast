<?php

class Default_Model_Group {

    public static function create($data) {
        $group = new Default_Model_DbTable_Group();
        return $group->insert($data);
    }

    public static function read($id = null, $pager = false, $where = null, $order = null) {
        $group = new Default_Model_DbTable_Group();
        if(!is_null($id)) {
            return $group->find($id)->current()->toArray();
        } else {
            $query = $group->select();
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            } else {
                $query->order('group_name');
            }

            if($pager == false) {
                return $group->fetchAll($query);
            } else {
                return $query;
            }
        }
    }

    public static function update($data) {
        $group = new Default_Model_DbTable_Group();
        $where = $group->getAdapter()->quoteInto('group_id = ?', $data['group_id']);
        unset($data['group_id']);
        return $group->update($data, $where);
    }

    public static function delete($id) {
        $group = new Default_Model_DbTable_Group();
        $where = $group->getAdapter()->quoteInto('group_id = ?', $id);
        return $group->delete($where);
    }

}

