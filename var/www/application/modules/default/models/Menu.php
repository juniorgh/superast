<?php

class Default_Model_Menu {

    public static function create($data) {
        $menu = new Default_Model_DbTable_Menu();
        return $menu->insert($data);
    }

    public static function read($id = null, $pager = false, array $where = null, array $order = null) {
        $menu = new Default_Model_DbTable_Menu();
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
            } else {
                $query->order('menu_order');
            }

            if($pager == false) {
                return $menu->fetchAll($query)->toArray();
            } else {
                return $query;
            }
        }
    }

    public static function update($data) {
        $menu = new Default_Model_DbTable_Menu();
        $where = $menu->getAdapter()->quoteInto('menu_id = ?', $data['menu_id']);
        unset($data['menu_id']);
        return $menu->update($data, $where);
    }

    public static function delete($id) {
        $menu = new Default_Model_DbTable_Menu();
        $where = $menu->getAdapter()->quoteInto('menu_id = ?', $id);
        return $menu->delete($where);
    }

    public static function readTree($pager = false, array $where = null, array $order = null) {
        $menu = new Default_Model_DbTable_Menu();
        $query = $menu->select()->setIntegrityCheck(false)
        ->from(array('m1' => 'menu'), array())
        ->joinLeft(array('m2' => 'menu'), 'm2.menu_id = m1.menu_parent', array())
        ->joinLeft(array('m3' => 'menu'), 'm3.menu_id = m2.menu_parent', array())
        ->joinLeft(array('m4' => 'menu'), 'm4.menu_id = m3.menu_parent', array())
        ->columns(array(
                "m1_menu_id" => "m1.menu_id", "m1_menu_name" => "m1.menu_name", "m1_menu_parent" => "m1.menu_parent",
                "m2_menu_id" => "m2.menu_id", "m2_menu_name" => "m2.menu_name", "m2_menu_parent" => "m2.menu_parent",
                "m3_menu_id" => "m3.menu_id", "m3_menu_name" => "m3.menu_name", "m3_menu_parent" => "m3.menu_parent",
                "m4_menu_id" => "m4.menu_id", "m4_menu_name" => "m4.menu_name", "m4_menu_parent" => "m4.menu_parent"
            ))
        ->order(array('m1.menu_name ASC'));

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

