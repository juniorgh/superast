<?php

class Default_Model_UserCompany {

    public static function create($data) {
        $user_company = new Default_Model_DbTable_UserCompany();
        return $user_company->insert($data);
    }

    public static function read($id = null, $pager = false, $where = null, $order = null) {
        $user_company = new Default_Model_DbTable_UserCompany();
        if(!is_null($id)) {
            return $user_company->find($id)->current()->toArray();
        } else {
            $query = $user_company->select();
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            }

            if($pager == false) {
                return $user_company->fetchAll($query);
            } else {
                return $query;
            }
        }
    }

    public static function update($data) {
        $user_company = new Default_Model_DbTable_UserCompany();
        $where = $user_company->getAdapter()->quoteInto('user_company_id = ?', $data['user_company_id']);
        unset($data['user_company_id']);
        return $user_company->update($data, $where);
    }

    public static function delete($id) {
        $user_company = new Default_Model_DbTable_UserCompany();
        $where = $user_company->getAdapter()->quoteInto('user_company_id = ?', $id);
        return $user_company->delete($where);
    }

    public static function deleteByUser($userId) {
        $user_company = new Default_Model_DbTable_UserCompany();
        $where = $user_company->getAdapter()->quoteInto('user_company_user = ?', $userId);
        return $user_company->delete($where);
    }

    public static function deleteByCompany($companyId) {
        $user_company = new Default_Model_DbTable_UserCompany();
        $where = $user_company->getAdapter()->quoteInto('user_company_company = ?', $companyId);
        return $user_company->delete($where);
    }

    public static function readUserCompanies($userId, array $where = null, array $order = null) {
        $user_company = new Default_Model_DbTable_UserGroup();
        $query = $user_company->select()->setIntegrityCheck(false)
        ->from(array('uc' => 'user_company'))
        ->join(array('u' => 'user'), 'u.user_id = uc.user_company_user')
        ->join(array('c' => 'company'), 'c.company_id = uc.user_company_company');

        if(!is_null($where)) {
            foreach($where as $cond) {
                $query->where($cond);
            }
        }

        if(!is_null($order)) {
            $query->order($order);
        }

        return $user_company->fetchAll($query)->toArray();
    }

}

