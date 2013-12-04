<?php

class Telephony_Model_Agent {

    public static function create(array $data) {
        $agent = new Telephony_Model_DbTable_Agent();
        return $agent->insert($data);
    }

    public static function read($id = null, $pager = false, array $where = null, array $order = null, array $columns = null) {
        $agent = new Telephony_Model_DbTable_Agent();
        $query = $agent->select()->setIntegrityCheck(false);

        if(!is_null($columns)) {
            $query->from(array('a' => 'agent'), array())
            ->join(array('s' => 'server'), 'a.agent_server = s.server_id', array())
            ->joinLeft(array('c' => 'company'), 'a.agent_company = c.company_id', array())
            ->joinLeft(array('u' => 'user'), 'a.agent_user = u.user_id', array())
            ->columns($columns);
        } else {
            $query->from(array('a' => 'agent'))
            ->join(array('s' => 'server'), 'a.agent_server = s.server_id')
            ->joinLeft(array('c' => 'company'), 'a.agent_company = c.company_id')
            ->joinLeft(array('u' => 'user'), 'a.agent_user = u.user_id');
        }

        if(!is_null($id)) {
            return $agent->fetchRow($query);
        } else {
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            }

            return $pager === false ? $agent->fetchAll($query)->toArray() : $query;
        }
    }

    public static function update(array $data) {
        $agent = new Telephony_Model_DbTable_Agent();
        $id = $data['agent_id'];
        unset($data['agent_id']);
        $where = $agent->getAdapter()->quoteInto('agent_id = ?', $id);
        return $agent->update($data, $where);
    }

    public static function delete(array $id) {
        $agent = new Telephony_Model_DbTable_Agent();
        $where = $agent->getAdapter()->quoteInto('agent_id = ?', $id);
        return $agent->delete($where);
    }

}

