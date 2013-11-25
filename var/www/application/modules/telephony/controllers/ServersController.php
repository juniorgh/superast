<?php

class Telephony_ServersController extends Zend_Controller_Action {

    public function indexAction() {
        $where = null;
        $order = null;
        $request = $this->getRequest();
        $params = parent::_getAllParams();
            
        if(!empty($params['server_hostname'])) {
            $where[] = "server_hostname LIKE '%{$params['server_hostname']}%'";
        }

        if(!empty($params['server_ip_address'])) {
            $where[] = "server_ip_address LIKE '%{$params['server_ip_address']}%'";
        }

        if(!empty($params['server_database_user'])) {
            $where[] = "server_database_user LIKE '%{$params['server_database_user']}%'";
        }

        if(!empty($params['server_ami_user'])) {
            $where[] = "server_ami_user LIKE '%{$params['server_ami_user']}%'";
        }

        if(isset($params['server_is_elastix']) && $params['server_is_elastix'] != 'selecione') {
            $is_elastix = $params['server_is_elastix'] == "sim" ? 1 : 0;
            $where[] = "server_is_elastix = {$is_elastix}";
        }

        if(!is_null($where) > 0) {
            $this->view->assign('hasFilter', true);
        } else {
            $this->view->assign('hasFilter', false);
        }

        $this->view->assign('params', $params);

        $query = Telephony_Model_Server::read(null, true, $where, $order);
        $paginator = Zend_Paginator::factory($query);
        $paginator->setCurrentPageNumber(parent::_getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(5);

        $this->view->assign('servers', $paginator);
    }

    public function viewAction() {
        $id = parent::_getParam('id');
        $server = Telephony_Model_Server::read($id);
        $this->view->assign('server', $server);
    }

    /** 
     * Inclui ou atualiza o registro submetido via formulário.
     * 
     */
    public function saveAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        try {
            $request = $this->getRequest();
            if($request->isPost()) {
                $params = $request->getPost();
                $params['server_is_elastix'] = $params['server_is_elastix'] == "nao" ? 0 : 1;
                if(!empty($params['server_id'])) {
                    $result = Telephony_Model_Server::update($params);
                } else {
                    $result = Telephony_Model_Server::create($params);
                }

                $url = $this->view->url(array('module' => 'telephony', 'controller' => 'servers', 'action' => 'index'), 'index_action', true);
                $this->_redirect($url);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function dropAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        $id = parent::_getParam('id');
        $result = Telephony_Model_Server::delete($id);

        $url = $this->view->url(array('module' => 'telephony', 'controller' => 'servers', 'action' => 'index'), 'index_action', true);
        $this->_redirect($url);
    }

    public function formAction() {
        $id = parent::_getParam('id', null);

        if(!is_null($id)) {
            $server = Telephony_Model_Server::read((int) $id);
            $this->view->assign('server', $server);
        }
    }


}











