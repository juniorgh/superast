<?php

/** 
 * Controladora de gerenciamento do controle de cargos
 * @package Default
 * @category Controller
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Default_RolesController extends Zend_Controller_Action {

    /** 
     * Ação índice da controladora. Faz a listagem dos registros de acordo com
     * os filtros passados para a consulta SQL executada pelo Zend_Paginator
     * @return void
     */
    public function indexAction() {
        $where = null;
        $order = null;
        $hasFilter = false;
        $params = $this->getRequest()->getParams();

        $where = array('role_active = 1');

        if(!empty($params['role_name'])) {
            $where[] = "role_name LIKE '%{$params['role_name']}%'";
            $hasFilter = true;
        }

        $query = Default_Model_Role::read(null, true, $where, $order);
        $paginator = Zend_Paginator::factory($query);
        $paginator->setCurrentPageNumber(parent::_getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(5);

        $this->view->assign('roles', $paginator);
        $this->view->assign('hasFilter', $hasFilter);
    }

    /** 
     * Visualiza um determinado cargo cadastrado
     * @return void
     */
    public function viewAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $role = Default_Model_Role::read($id);
            $this->view->assign('role', $role);
        }
    }

    /** 
     * Cria ou atualiza um novo cargo no banco de dados
     * @return void
     */
    public function saveAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        $request = $this->getRequest();
        if($request->isPost()) {
            $params = $request->getPost();
            if(!array_key_exists('role_id', $params)) {
                Default_Model_Role::create($params);
            } else {
                Default_Model_Role::update($params);
            }
        }
        
        $this->_redirect($this->view->actions['index']);
    }

    /** 
     * Altera o status do cargo para inativo
     * @return void
     */
    public function dropAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $data = array(
                'role_id' => $id,
                'role_active' => 0
            );

            $role = Default_Model_Role::update($data);

            $this->_redirect($this->view->actions['index']);
        }
    }

    /** 
     * Formulário de criação e edição de cargo
     * @return void
     */
    public function formAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $role = Default_Model_Role::read($id);
            $this->view->assign('role', $role);
        }
    }

}