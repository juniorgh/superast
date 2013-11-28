<?php

class Default_Model_UserGroup {

    public static function create($data) {
        $user_group = new Default_Model_DbTable_UserGroup();
        return $user_group->insert($data);
    }

    public static function read($id = null, $pager = false, $where = null, $order = null) {
        $user_group = new Default_Model_DbTable_UserGroup();
        if(!is_null($id)) {
            return $user_group->find($id)->current()->toArray();
        } else {
            $query = $user_group->select();
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            }

            if($pager == false) {
                return $user_group->fetchAll($query)->toArray();
            } else {
                return $query;
            }
        }
    }

    public static function update($data) {
        $user_group = new Default_Model_DbTable_UserGroup();
        $where = $user_group->getAdapter()->quoteInto('user_group_id = ?', $data['user_group_id']);
        unset($data['user_group_id']);
        return $user_group->update($data, $where);
    }

    public static function delete($id) {
        $user_group = new Default_Model_DbTable_UserGroup();
        $where = $user_group->getAdapter()->quoteInto('user_group_id = ?', $id);
        return $user_group->delete($where);
    }

    public static function deleteByUser($userId) {
        $user_group = new Default_Model_DbTable_UserGroup();
        $where = $user_group->getAdapter()->quoteInto('user_group_user = ?', $userId);
        return $user_group->delete($where);
    }

    public static function deleteByGroup($groupId) {
        $user_group = new Default_Model_DbTable_UserGroup();
        $where = $user_group->getAdapter()->quoteInto('user_group_group = ?', $groupId);
        return $user_group->delete($where);
    }

    public static function readUserGroups($userId, array $where = null, array $order = null) {
        $user_group = new Default_Model_DbTable_UserGroup();
        $query = $user_group->select()->setIntegrityCheck(false)
        ->from(array('ug' => 'user_group'))
        ->join(array('u' => 'user'), 'u.user_id = ug.user_group_user')
        ->join(array('g' => 'group'), 'g.group_id = ug.user_group_group');

        if(!is_null($where)) {
            foreach($where as $cond) {
                $query->where($cond);
            }
        }

        if(!is_null($order)) {
            $query->order($order);
        }

        return $user_group->fetchAll($query)->toArray();
    }

}

