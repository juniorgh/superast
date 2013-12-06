<?php

/** 
 * Controladora de gerenciamento do cadastro de ramais
 * @package Telephony
 * @category Controller
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Telephony_ExtensionsController extends Zend_Controller_Action {

    /** 
     * Ação índice da controladora. Faz a listagem dos registros de acordo com
     * os filtros passados para a consulta SQL executada pelo Zend_Paginator
     * @return void
     */
    public function indexAction() {
        $where = array('extension_active = 1');
        $order = array('extension_name');
        $hasFilter = false;
        $params = $this->getRequest()->getParams();

        if(!empty($params['extension_name'])) {
            $hasFilter = true;
            $where[] = "extension_name LIKE '%{$params['extension_name']}%'";
        }

        if(!empty($params['extension_number'])) {
            $hasFilter = true;
            $where[] = "extension_number LIKE '%{$params['extension_number']}%'";
        }

        if(!empty($params['extension_server']) && $params['extension_server'] != 'selecione') {
            $hasFilter = true;
            $where[] = "extension_server = {$params['extension_server']}";
        }

        if(!empty($params['extension_user']) && $params['extension_user'] != 'selecione') {
            $hasFilter = true;
            $where[] = "extension_user = {$params['extension_user']}";
        }

        $query = Telephony_Model_Extension::read(null, true, $where, $order);
        $paginator = Zend_Paginator::factory($query);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(5);

        $servers = Telephony_Model_Server::read(null, false, null, array('server_hostname'));
        $users = Default_Model_User::read(null, false, null, array('user_name'));

        $this->view->assign('servers', $servers);
        $this->view->assign('users', $users);
        $this->view->assign('hasFilter', $hasFilter);
        $this->view->assign('extensions', $paginator);
    }

    /** 
     * Visualiza um determinado agente cadastrado
     * @return void
     */
    public function viewAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $extension = Telephony_Model_Extension::read($id);
            if(count($extension) > 0) {
                $this->view->assign('extension', $extension);
            }
        } else {
            $this->_redirect($this->view->actions['index']);
        }
    }

    /** 
     * Cria ou atualiza um novo agente no banco de dados
     * @return void
     */
    public function saveAction() {
        $request = $this->getRequest();
        if($request->isPost()) {
            $params = $request->getPost();
            if($params['extension_server'] == "selecione") {
                $params['extension_server'] = null;
            }

            if($params['extension_user'] == "selecione") {
                $params['extension_user'] = null;
            }

            if(array_key_exists('extension_id', $params)) {
                Telephony_Model_Extension::update($params);
            } else {
                Telephony_Model_Extension::create($params);
            }
        }

        $this->_redirect($this->view->actions['index']);
    }

    /** 
     * Altera o status do agente para inativo
     * @return void
     */
    public function dropAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $data = array(
                'extension_id' => $id,
                'extension_active' => 0
            );

            Telephony_Model_Extension::update($data);
        }

        $this->_redirect($this->view->actions['index']);
    }

    /** 
     * Formulário de criação e edição de agente
     * @return void
     */
    public function formAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $extension = Telephony_Model_Extension::read($id);
            if((bool) $extension['server_is_elastix']) {
                $this->view->assign('disabled', ' disabled ');
            }
            $this->view->assign('extension', $extension);
        }

        $servers = Telephony_Model_Server::read(null, false, array('server_active = 1'), array('server_hostname'));
        $users = Default_Model_User::read(null, false, array('user_active = 1'), array('user_name'));
        $this->view->assign('servers', $servers);
        $this->view->assign('users', $users);
    }

}