<?php

/** 
 * Controladora de gerenciamento do controle de usuários
 * @package Default
 * @category Controller
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Default_UsersController extends Zend_Controller_Action {

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

        if(!empty($params['user_name'])) {
            $hasFilter = true;
            $where[] = "user_name LIKE '%{$params['user_name']}%'";
        }

        if(!empty($params['user_email'])) {
            $hasFilter = true;
            $where[] = "user_email LIKE '%{$params['user_email']}%'";
        }

        if(!empty($params['user_login'])) {
            $hasFilter = true;
            $where[] = "user_login LIKE '%{$params['user_login']}%'";
        }

        if(!empty($params['user_role']) && $params['user_role'] != "selecione") {
            $hasFilter = true;
            $where[] = "user_role = {$params['user_role']}";
        }

        $query = Default_Model_User::read(null, true, $where, $order);
        $paginator = Zend_Paginator::factory($query);
        $paginator->setCurrentPageNumber(parent::_getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(5);

        $roles = Default_Model_Role::read(null, false, array("role_active = 1"), array("role_name"));
        $this->view->assign("roles", $roles);

        $this->view->assign('users', $paginator);
        $this->view->assign('hasFilter', $hasFilter);
    }

    /** 
     * Visualiza um determinado usuário cadastrado
     * @return void
     */
    public function viewAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $user = Default_Model_User::read($id);
            if(count($user) > 0) {
                $groups = Default_Model_UserGroup::readUserGroups($user['user_id']);
                $companies = Default_Model_UserCompany::readUserCompanies($user['user_id']);

                $this->view->assign('groups', $groups);
                $this->view->assign('companies', $companies);
                $this->view->assign('user', $user);
            } else {
                $this->_redirect($this->view->actions['index']);
            }
        }
    }

    /** 
     * Cria ou atualiza um novo usuário no banco de dados
     * @return void
     */
    public function saveAction() {
        $request = $this->getRequest();
        if($request->isPost()) {
            $params = $request->getPost();
            $user_group = $params['user_group'];
            $user_company = $params['user_company'];
            if(strlen($params['user_password']) == 0) {
                unset($params['user_password']);
            } else {
                $params['user_password'] = Default_Model_User::encodeMD5($params['user_password']);
            }

            unset($params['user_group'], $params['user_company'], $params['user_password_confirm']);

            if(!empty($params['user_id'])) {
                Default_Model_User::update($params);
            } else {
                $params['user_id'] = Default_Model_User::create($params);
            }

            Default_Model_UserGroup::deleteByUser($params['user_id']);
            foreach($user_group as $group) {
                $data = array(
                    'user_group_user' => $params['user_id'],
                    'user_group_group' => $group
                );

                Default_Model_UserGroup::create($data);
            }

            Default_Model_UserCompany::deleteByUser($params['user_id']);
            foreach($user_company as $company) {
                $data = array(
                    'user_company_user' => $params['user_id'],
                    'user_company_company' => $company
                );

                Default_Model_UserCompany::create($data);
            }
        }

        $this->_redirect($this->view->actions['index']);

    }

    /** 
     * Altera o status do usuário para inativo
     * @return void
     */
    public function dropAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $data = array(
                'user_id' => $id,
                'user_active' => 0
            );

            Default_Model_User::update($data);
        }

        $this->_redirect($this->view->actions['index']);
    }

    /** 
     * Formulário de criação e edição de usuário
     * @return void
     */
    public function formAction() {
        $id = $this->getRequest()->getParam('id', null);
        $company_added = array();
        $group_added = array();

        if(!is_null($id)) {
            $user = Default_Model_User::read($id);
            $this->view->assign('user', $user);

            $user_group = Default_Model_UserGroup::read(null, false, array("user_group_user = {$user['user_id']}"));
            foreach($user_group as $k => $v) {
                $group_added[] = $v['user_group_group'];
            }

            $user_company = Default_Model_UserCompany::read(null, false, array("user_company_user = {$user['user_id']}"));
            foreach($user_company as $k => $v) {
                $company_added[] = $v['user_company_company'];
            }
        }

        $this->view->assign('group_added', $group_added);
        $this->view->assign('company_added', $company_added);

        $groups = Default_Model_Group::read(null, false, array('group_active = 1'), array('group_name'));
        $this->view->assign("groups", $groups);

        $roles = Default_Model_Role::read(null, false, array("role_active = 1"), array("role_name"));
        $this->view->assign("roles", $roles);

        $companies = Default_Model_Company::read(null, false, array('company_active = 1'), array('company_name'));
        $this->view->assign('companies', $companies);
    }

}