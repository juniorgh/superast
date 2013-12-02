<?php

class Default_Model_User {

    public static function create($data) {
        $user = new Default_Model_DbTable_User();
        return $user->insert($data);
    }

    public static function read($id = null, $pager = false, $where = null, $order = null) {
        $user = new Default_Model_DbTable_User();
        if(!is_null($id)) {
            $query = $user->select()->setIntegrityCheck(false)
            ->from(array('u' => 'user'))
            ->joinLeft(array('r' => 'role'), 'r.role_id = u.user_role')
            ->where('user_id = ?', $id);

            return $user->fetchRow($query);
        } else {
            $query = $user->select()->setIntegrityCheck(false)
            ->from(array('u' => 'user'))
            ->joinLeft(array('r' => 'role'), 'r.role_id = u.user_role');

            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            } else {
                $query->order('user_name');
            }

            if($pager == false) {
                return $user->fetchAll($query)->toArray();
            } else {
                return $query;
            }
        }
    }

    public static function update($data) {
        $user = new Default_Model_DbTable_User();
        $where = $user->getAdapter()->quoteInto('user_id = ?', $data['user_id']);
        unset($data['user_id']);
        return $user->update($data, $where);
    }

    public static function delete($id) {
        $user = new Default_Model_DbTable_User();
        $where = $user->getAdapter()->quoteInto('user_id = ?', $id);
        return $user->delete($where);
    }

    public static function encodeMD5($password) {
        $user = new Default_Model_DbTable_User();
        return new Zend_Db_Expr($user->getAdapter()->quoteInto('MD5(?)', $password));
    }

}

