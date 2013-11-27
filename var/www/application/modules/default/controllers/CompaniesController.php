<?php

class Default_CompaniesController extends Zend_Controller_Action {

    public function indexAction() {
        $where = null;
        $order = null;
        $hasFilter = false;
        $params = $this->getRequest()->getParams();

        $where = array('company_active = 1');

        if(!empty($params['company_name'])) {
            $where[] = "company_name LIKE '%{$params['company_name']}%'";
        }

        $query = Default_Model_Company::read(null, true, $where, $order);
        $paginator = Zend_Paginator::factory($query);
        $paginator->setCurrentPageNumber(parent::_getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(5);

        $this->view->assign('companies', $paginator);
        $this->view->assign('hasFilter', $hasFilter);
    }

    public function viewAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $company = Default_Model_Company::read($id);
            $this->view->assign('company', $company);
        }
    }

    public function saveAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        $request = $this->getRequest();
        if($request->isPost()) {
            $params = $request->getPost();
            echo '<pre>';
            print_r($params);
            if(!array_key_exists('company_id', $params)) { // insert
                Default_Model_Company::create($params);
            } else { // update
                Default_Model_Company::update($params);
            }
        }
        
        $this->_redirect($this->view->actions['index']);
    }

    public function dropAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $data = array(
                'company_id' => $id,
                'company_active' => 0
            );

            $company = Default_Model_Company::update($data);

            $this->_redirect($this->view->actions['index']);
        }
    }

    public function formAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $company = Default_Model_Company::read($id);
            $this->view->assign('company', $company);
        }
    }

}