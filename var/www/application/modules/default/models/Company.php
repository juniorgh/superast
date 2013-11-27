<?php

class Default_Model_Company {

    public static function create($data) {
        $company = new Default_Model_DbTable_Company();
        return $company->insert($data);
    }

    public static function read($id = null, $pager = false, $where = null, $order = null) {
        $company = new Default_Model_DbTable_Company();
        if(!is_null($id)) {
            return $company->find($id)->current()->toArray();
        } else {
            $query = $company->select();
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            } else {
                $query->order('company_name');
            }

            if($pager == false) {
                return $company->fetchAll($query);
            } else {
                return $query;
            }
        }
    }

    public static function update($data) {
        $company = new Default_Model_DbTable_Company();
        $where = $company->getAdapter()->quoteInto('company_id = ?', $data['company_id']);
        unset($data['company_id']);
        return $company->update($data, $where);
    }

    public static function delete($id) {
        $company = new Default_Model_DbTable_Company();
        $where = $company->getAdapter()->quoteInto('company_id = ?', $id);
        return $company->delete($where);
    }

}

