<?php

class Default_GroupsController extends Zend_Controller_Action {

    public function indexAction() {
        $where = null;
        $order = null;
        $hasFilter = false;
        $params = $this->getRequest()->getParams();

        $where = array('group_active = 1');

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
            if(!array_key_exists('group_id', $params)) {
                Default_Model_Group::create($params);
            } else {
                Default_Model_Group::update($params);
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
        if(!is_null($id)) {
            $group = Default_Model_Group::read($id);
            $this->view->assign('group', $group);
        }
    }

}