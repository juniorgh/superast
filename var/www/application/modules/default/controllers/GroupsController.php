<?php

class Default_GroupsController extends Zend_Controller_Action {

    public function indexAction() {
        $where = null;
        $order = null;
        $hasFilter = false;
        $params = $this->getRequest()->getParams();

        $where = array('group_active = 1', 'group_visible = 1');

        if(!empty($params['group_name'])) {
            $where[] = "group_name LIKE '%{$params['group_name']}%'";
            $hasFilter = true;
        }

        $query = Default_Model_Group::read(null, true, $where, $order);
        $paginator = Zend_Paginator::factory($query);
        $paginator->setCurrentPageNumber(parent::_getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(5);

        $this->view->assign('groups', $paginator);
        $this->view->assign('hasFilter', $hasFilter);
    }

    public function viewAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $group = Default_Model_Group::read($id);
            $this->view->assign('group', $group);
        }
    }

    public function saveAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        $request = $this->getRequest();
        if($request->isPost()) {
            $params = $request->getPost();
            $menus = count($params['group_menu']) > 0 ? $params['group_menu'] : null;
            unset($params['group_menu']);

            if(!array_key_exists('group_id', $params)) {
                $params['group_id'] = Default_Model_Group::create($params);
            } else {
                Default_Model_Group::update($params);
                Default_Model_GroupMenu::deleteByGroup($params['group_id']);
            }

            if(!is_null($menus)) {
                foreach($menus as $menu) {
                    $group_menu = array(
                        'group_menu_menu' => $menu,
                        'group_menu_group' => $params['group_id']
                    );

                    Default_Model_GroupMenu::create($group_menu);
                }
            }
        }
        
        $this->_redirect($this->view->actions['index']);
    }

    public function dropAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $data = array(
                'group_id' => $id,
                'group_active' => 0
            );

            $group = Default_Model_Group::update($data);

            $this->_redirect($this->view->actions['index']);
        }
    }

    public function formAction() {
        $id = $this->getRequest()->getParam('id', null);
        $menu_added = array();
        if(!is_null($id)) {
            $group = Default_Model_Group::read($id);
            $menu = Default_Model_GroupMenu::read(null, false, array("group_menu_group = {$group['group_id']}"));

            foreach($menu as $m) {
                $menu_added[] = $m['group_menu_menu'];
            }

            $this->view->assign('group', $group);
        }

        $menu = Default_Model_Menu::read(null, false, array('LENGTH(menu_parent) = 0 OR menu_parent IS NULL'));
        foreach($menu as $k => $v) {
            $childs1 = Default_Model_Menu::read(null, false, array("menu_parent = {$v['menu_id']}"));
            if(count($childs1) > 0) {
                foreach($childs1 as $i => $j) {
                    $childs2 = Default_Model_Menu::read(null, false, array("menu_parent = {$j['menu_id']}"));
                    if(count($childs2) > 0) {
                        foreach($childs2 as $x => $y) {
                            $childs3 = Default_Model_Menu::read(null, false, array("menu_parent = {$y['menu_id']}"));
                            if(count($childs3) > 0) {
                                $childs2[$x]['childs'] = $childs3;
                            }
                        }

                        $childs1[$i]['childs'] = $childs2;
                    }
                }

                $menu[$k]['childs'] = $childs1;
            }
        }

        $menu = Superast_Utils_MenuIterator::parseHierarchyNames($menu);

        $this->view->assign('list_menus', $menu);
        $this->view->assign('menu_added', $menu_added);
    }

}