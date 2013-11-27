<?php

class Default_MenusController extends Zend_Controller_Action
{

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $where = null;
        $order = null;
        $request = $this->getRequest();
        $params = parent::_getAllParams();
        $hasFilter = false;

        $read = Default_Model_Menu::read(null, false, array('menu_parent = 0 OR menu_parent IS NULL'));

        foreach($read as $k => $v) {
            $childs1 = Default_Model_Menu::read(null, false, array('menu_parent = ' . $read[$k]['menu_id']));
            if(count($childs1) > 0) {
                foreach($childs1 as $i => $j) {
                    $childs2 = Default_Model_Menu::read(null, false, array('menu_parent = ' . $childs1[$i]['menu_id']));
                    if(count($childs2) > 0) {
                        $childs1[$i]['childs'] = $childs2;
                    }
                }

                $read[$k]['childs'] = $childs1;
            }
        }

        $menus = Superast_Utils_MenuIterator::parseHierarchyNames($read);


        if(!empty($params['menu_name'])) {
            $where[] = "m1.menu_name LIKE '%{$params['menu_name']}%'";
            $hasFilter =  true;
        }

        if(!empty($params['menu_page_title'])) {
            $where[] = "m1.menu_page_title LIKE '%{$params['menu_page_title']}%'";
            $hasFilter =  true;
        }

        if(!empty($params['menu_description'])) {
            $where[] = "m1.menu_description LIKE '%{$params['menu_description']}%'";
            $hasFilter =  true;
        }

        if(!empty($params['menu_module'])) {
            $where[] = "m1.menu_module LIKE '%{$params['menu_module']}%'";
            $hasFilter =  true;
        }

        if(!empty($params['menu_controller'])) {
            $where[] = "m1.menu_controller LIKE '%{$params['menu_controller']}%'";
            $hasFilter =  true;
        }

        if(!empty($params['menu_action'])) {
            $where[] = "m1.menu_action LIKE '%{$params['menu_action']}%'";
            $hasFilter =  true;
        }

        if(!empty($params['menu_route'])) {
            $where[] = "m1.menu_route LIKE '%{$params['menu_route']}%'";
            $hasFilter =  true;
        }

        if(!empty($params['menu_data_target'])) {
            $where[] = "m1.menu_data_target LIKE '%{$params['menu_data_target']}%'";
            $hasFilter =  true;
        }

        if(!empty($params['menu_icon_class'])) {
            $where[] = "m1.menu_icon_class LIKE '%{$params['menu_icon_class']}%'";
            $hasFilter =  true;
        }

        if(!empty($params['menu_parent']) && $params['menu_parent'] != "selecione") {
            $where[] = "m1.menu_parent = {$params['menu_parent']}";
            $hasFilter =  true;
        }

        $query = Default_Model_Menu::readTree(true, $where, $order);
        $paginator = Zend_Paginator::factory($query);
        $paginator->setCurrentPageNumber(parent::_getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(5);

        $this->view->assign('list_menus', $menus);
        $this->view->assign('params', $params);
        $this->view->assign('menus', $paginator);
        $this->view->assign('hasFilter', $hasFilter);
    }

    public function viewAction() {
        $id = parent::_getParam('id', null);

        if(!is_null($id)) {
            $menu = Default_Model_Menu::read($id);
            $this->view->assign('menu', $menu);
        }
    }

    public function saveAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        try {
            $request = $this->getRequest();
            if($request->isPost()) {
                $params = $request->getPost();
                if($params['menu_parent'] == "selecione") {
                    unset($params['menu_parent']);
                }

                if(!empty($params['menu_id'])) {
                    $result = Default_Model_Menu::update($params);
                } else {
                    $result = Default_Model_Menu::create($params);
                }

                $url = $this->view->url(array('module' => 'default', 'controller' => 'menus', 'action' => 'index'), 'index_action', true);
                $this->_redirect($url);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function dropAction() {
        $id = parent::_getParam('id', null);


        if(!is_null($id)) {
            Default_Model_Menu::delete($id);
            $url = $this->view->url(array('module' => 'default', 'controller' => 'menus', 'action' => 'index'), 'settings_index_action');
            $this->_redirect($url);
        }
    }

    public function formAction() {
        $read = Default_Model_Menu::read(null, false, array('menu_parent = 0 OR menu_parent IS NULL'));

        foreach($read as $k => $v) {
            $childs1 = Default_Model_Menu::read(null, false, array('menu_parent = ' . $read[$k]['menu_id']));
            if(count($childs1) > 0) {
                foreach($childs1 as $i => $j) {
                    $childs2 = Default_Model_Menu::read(null, false, array('menu_parent = ' . $childs1[$i]['menu_id']));
                    if(count($childs2) > 0) {
                        $childs1[$i]['childs'] = $childs2;
                    }
                }

                $read[$k]['childs'] = $childs1;
            }
        }

        $menus = Superast_Utils_MenuIterator::parseHierarchyNames($read);

        $id = parent::_getParam('id', null);

        if(!is_null($id)) {
            $menu = Default_Model_Menu::read($id);
            $this->view->assign('menu', $menu);
        }

        $this->view->assign('menus', $menus);
    }

}









