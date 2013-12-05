<?php

/** 
 * Controladora de gerenciamento de menus
 * @package Default
 * @category Controller
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Default_MenusController extends Zend_Controller_Action {

    /** 
     * Ação índice da controladora. Faz a listagem dos registros de acordo com
     * os filtros passados para a consulta SQL executada pelo Zend_Paginator
     * @return void
     */
    public function indexAction() {
        $where = null;
        $order = null;
        $params = $this->getRequest()->getParams();
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
        $this->view->assign('menus', $paginator);
        $this->view->assign('hasFilter', $hasFilter);
    }

    /** 
     * Visualiza um determinado menu cadastrado
     * @return void
     */
    public function viewAction() {
        $id = $this->getRequest()->getParam('id', null);

        if(!is_null($id)) {
            $menu = Default_Model_Menu::read($id);
            if(count($menu) > 0) {
                $this->view->assign('menu', $menu);
            } else {
                $this->_redirect($this->view->actions['index']);
            }
        }
    }

    /** 
     * Cria ou atualiza um novo menu no banco de dados
     * @return void
     */
    public function saveAction() {
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

                $this->_redirect($this->view->actions['index']);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /** 
     * Remove um determinado menu da tabela
     * @return void
     */
    public function dropAction() {
        $id = $this->getRequest()->getParam('id', null);

        if(!is_null($id)) {
            Default_Model_Menu::delete($id);
            $this->_redirect($this->view->actions['index']);
        }
    }

    /** 
     * Formulário de criação e edição de menu
     * @return void
     */
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

        $id = $this->getRequest()->getParam('id', null);

        if(!is_null($id)) {
            $menu = Default_Model_Menu::read($id);
            $this->view->assign('menu', $menu);
        }

        $this->view->assign('menus', $menus);
    }

}









