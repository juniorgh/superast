<?php

/**
 * Controladora de gerenciamento do cadastro de filas
 * @package Telephony
 * @category Controller
 * @author William Urbano <contato@williamurbano.com.br>
 * 
 */
class Telephony_QueuesController extends Zend_Controller_Action {

    /** 
     * Ação índice da controladora. Faz a listagem dos registros de acordo com
     * os filtros passados para a consulta SQL executada pelo Zend_Paginator
     * @return void
     */
    public function indexAction() {
        $where = array('queue_active = 1');
        $order = array('queue_name');
        $request = $this->getRequest();
        $params = $request->getParams();
        $hasFilter = false;

        if(!empty($params['queue_name'])) {
            $hasFilter = true;
            $where[] = "queue_name LIKE '%{$params['queue_name']}%'";
        }

        if(!empty($params['queue_number'])) {
            $hasFilter = true;
            $where[] = "queue_number LIKE '%{$params['queue_number']}%'";
        }

        if(!empty($params['queue_server']) && $params['queue_server'] != "selecione") {
            $hasFilter = true;
            $where[] = "queue_server = {$params['queue_server']}";
        }

        if(!empty($params['queue_company']) && $params['queue_company'] != "selecione") {
            $hasFilter = true;
            $where[] = "queue_company = {$params['queue_company']}";
        }

        $query = Telephony_Model_Queue::read(null, true, $where, $order);
        $paginator = Zend_Paginator::factory($query);
        $paginator->setCurrentPageNumber($request->getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(5);

        $servers = Telephony_Model_Server::read(null, false, null, array('server_hostname'));
        $companies = Default_Model_Company::read(null, false, null, array('company_name'));

        $this->view->assign('servers', $servers);
        $this->view->assign('companies', $companies);
        $this->view->assign('hasFilter', $hasFilter);
        $this->view->assign('queues', $paginator);
    }

    /** 
     * Visualiza um determinado agente cadastrado
     * @return void
     */
    public function viewAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $queue = Telephony_Model_Queue::read($id);
            if(count($queue) > 0) {
                $where = array("agent_queue_queue = {$queue['queue_id']}");
                $agents = Telephony_Model_AgentQueue::read(null, false, $where, array('agent_name'), array('a.*'));
                $this->view->assign('queue', $queue);
                $this->view->assign('agents', $agents);
            } else {
                $this->_redirect($this->view->actions['index']);
            }
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
            if($params['queue_company'] == "selecione") {
                $params['queue_company'] = null;
            }

            if($params['queue_server'] == "selecione") {
                $params['queue_server'] = null;
            }

            if(array_key_exists('queue_id', $params)) {
                Telephony_Model_Queue::update($params);
            } else {
                $params['queue_id'] = Telephony_Model_Queue::create($params);
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
                'queue_id' => $id,
                'queue_active' => 0
            );
            $agent = Telephony_Model_Queue::update($data);
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
            $queue = Telephony_Model_Queue::read($id);
            $disabled = (bool) $queue['server_is_elastix'] ? ' disabled ' : '';
            $this->view->assign('queue', $queue);
            $this->view->assign('disabled', $disabled);
        }

        $servers = Telephony_Model_Server::read(null, false, null, array('server_hostname'));
        $companies = Default_Model_Company::read(null, false, null, array('company_name'));

        $this->view->assign('servers', $servers);
        $this->view->assign('companies', $companies);
    }


}