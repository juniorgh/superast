<?php

/** 
 * Controladora de gerenciamento do cadastro de agentes de atendimento
 * @package Telephony
 * @category Controller
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Telephony_AgentsController extends Zend_Controller_Action {

    /** 
     * Ação índice da controladora. Faz a listagem dos registros de acordo com
     * os filtros passados para a consulta SQL executada pelo Zend_Paginator
     * @return void
     */
    public function indexAction() {
        $where = null;
        $order = array('agent_name');
        $request = $this->getRequest();
        $params = $request->getParams();
        $hasFilter = false;

        if(!empty($params['agent_name'])) {
            $hasFilter = true;
            $where[] = "agent_name LIKE '%{$params['agent_name']}%'";
        }

        if(!empty($params['agente_number'])) {
            $hasFilter = true;
            $where[] = "agente_number LIKE '%{$params['agente_number']}%'";
        }

        if(!empty($params['agent_server']) && $params['agent_server'] != "selecione") {
            $hasFilter = true;
            $where[] = "agent_server = {$params['agent_server']}";
        }

        if(!empty($params['agent_company']) && $params['agent_company'] != "selecione") {
            $hasFilter = true;
            $where[] = "agent_company = {$params['agent_company']}";
        }

        if(!empty($params['agent_user']) && $params['agent_user'] != "selecione") {
            $hasFilter = true;
            $where[] = "agent_user = {$params['agent_user']}";
        }

        $query = Telephony_Model_Agent::read(null, true, $where, $order);
        $paginator = Zend_Paginator::factory($query);
        $paginator->setCurrentPageNumber($request->getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(5);        

        $servers = Telephony_Model_Server::read(null, false, null, array('server_hostname'));
        $users = Default_Model_User::read(null, false, null, array('user_name'));
        $companies = Default_Model_Company::read(null, false, null, array('company_name'));

        $this->view->assign('servers', $servers);
        $this->view->assign('users', $users);
        $this->view->assign('companies', $companies);
        $this->view->assign('hasFilter', $hasFilter);
        $this->view->assign('agents', $paginator);
    }

    /** 
     * Visualiza um determinado agente cadastrado
     * @return void
     */
    public function viewAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $agent = Telephony_Model_Agent::read($id);
            $this->view->assign('agent', $agent);
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
            $params = $this->getRequest()->getPost();
            if($params['agent_company'] == "selecione") {
                $params['agent_company'] = null;
            }

            if($params['agent_user'] == "selecione") {
                $params['agent_user'] = null;
            }

            if(array_key_exists('agent_id', $params)) {
                Telephony_Model_Agent::update($params);
            } else {
                $params['agent_id'] = Telephony_Model_Agent::create($params);
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
                'agent_id' => $id,
                'agent_active' => 0
            );
            $agent = Telephony_Model_Agent::update($data);
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
            $agent = Telephony_Model_Agent::read($id);
            $disabled = (bool) $agent['server_is_elastix'] ? ' disabled ' : '';
            $this->view->assign('disabled', $disabled);
            $this->view->assign('agent', $agent);
        }

        $servers = Telephony_Model_Server::read(null, false, null, array('server_hostname'));
        $users = Default_Model_User::read(null, false, null, array('user_name'));
        $companies = Default_Model_Company::read(null, false, null, array('company_name'));
        $this->view->assign('servers', $servers);
        $this->view->assign('users', $users);
        $this->view->assign('companies', $companies);
    }


}









