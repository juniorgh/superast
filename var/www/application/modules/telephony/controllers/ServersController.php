<?php

/** 
 * Controladora de gerenciamento do cadastro de servidores
 * @package Telephony
 * @category Controller
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Telephony_ServersController extends Zend_Controller_Action {

    /** 
     * Ação índice da controladora. Faz a listagem dos registros de acordo com
     * os filtros passados para a consulta SQL executada pelo Zend_Paginator
     * @return void
     */
    public function indexAction() {
        $where = null;
        $order = null;
        $request = $this->getRequest();
        $params = $request->getParams();
            
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

        $query = Telephony_Model_Server::read(null, true, $where, $order);
        $paginator = Zend_Paginator::factory($query);
        $paginator->setCurrentPageNumber(parent::_getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(5);

        $this->view->assign('servers', $paginator);
    }

    /** 
     * Visualiza um determinado servidor cadastrado
     * @return void
     */
    public function viewAction() {
        $id = $this->getRequest()->getParam('id', null);
        $server = Telephony_Model_Server::read($id);
        $this->view->assign('server', $server);
    }

    /** 
     * Cria ou atualiza um novo servidor no banco de dados
     * @return void
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

                $this->_redirect($this->view->actions['index']);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /** 
     * Altera o status do servidor para inativo
     * @return void
     */
    public function dropAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $data = array(
                'server_id' => $id,
                'server_active' => 0
            );

            Telephony_Model_Server::update($data);
        }

        $this->_redirect($this->view->actions['index']);
    }

    /** 
     * Formulário de criação e edição de servidor
     * @return void
     */
    public function formAction() {
        $id = $this->getRequest()->getParam('id', null);
        
        if(!is_null($id)) {
            $server = Telephony_Model_Server::read((int) $id);
            $this->view->assign('server', $server);
        }
    }


}











