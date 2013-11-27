<?php

class Default_Model_GroupMenu {

    public static function create($data) {
        $menu = new Default_Model_DbTable_GroupMenu();
        return $menu->insert($data);
    }

    public static function read($id = null, $pager = false, array $where = null, array $order = null) {
        $menu = new Default_Model_DbTable_GroupMenu();
        if(!is_null($id)) {
            return $menu->find($id)->current()->toArray();
        } else {
            $query = $menu->select();
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            }

            if($pager == false) {
                return $menu->fetchAll($query)->toArray();
            } else {
                return $query;
            }
        }
    }

    public static function update($data) {
        $menu = new Default_Model_DbTable_GroupMenu();
        $where = $menu->getAdapter()->quoteInto('group_menu_id = ?', $data['group_menu_id']);
        unset($data['group_menu_id']);
        return $menu->update($data, $where);
    }

    public static function delete($id) {
        $menu = new Default_Model_DbTable_GroupMenu();
        $where = $menu->getAdapter()->quoteInto('group_menu_id = ?', $id);
        return $menu->delete($where);
    }

    public static function deleteByGroup($groupId) {
        $menu = new Default_Model_DbTable_GroupMenu();
        $where = $menu->getAdapter()->quoteInto('group_menu_group = ?', $groupId);
        return $menu->delete($where);
    }

    public static function deleteByMenu($menuId) {
        $menu = new Default_Model_DbTable_GroupMenu();
        $where = $menu->getAdapter()->quoteInto('group_menu_menu = ?', $menuId);
        return $menu->delete($where);
    }

}

