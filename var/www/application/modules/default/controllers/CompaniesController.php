<?php

/** 
 * Controladora de gerenciamento do controle de empresas
 * @package Default
 * @category Controller
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Default_CompaniesController extends Zend_Controller_Action {

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

        $where = array('company_active = 1');

        if(!empty($params['company_name'])) {
            $where[] = "company_name LIKE '%{$params['company_name']}%'";
            $hasFilter = true;
        }

        $query = Default_Model_Company::read(null, true, $where, $order);
        $paginator = Zend_Paginator::factory($query);
        $paginator->setCurrentPageNumber(parent::_getParam('page', 1));
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(5);

        $this->view->assign('companies', $paginator);
        $this->view->assign('hasFilter', $hasFilter);
    }

    /** 
     * Visualiza um determinada empresa cadastrada
     * @return void
     */
    public function viewAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $company = Default_Model_Company::read($id);
            $this->view->assign('company', $company);
        }
    }

    /** 
     * Cria ou atualiza uma nova empresa no banco de dados
     * @return void
     */
    public function saveAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        $request = $this->getRequest();
        if($request->isPost()) {
            $params = $request->getPost();
            if(!array_key_exists('company_id', $params)) {
                Default_Model_Company::create($params);
            } else {
                Default_Model_Company::update($params);
            }
        }
        
        $this->_redirect($this->view->actions['index']);
    }

    /** 
     * Altera o status do empresa para inativo
     * @return void
     */
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

    /** 
     * Formulário de criação e edição de empresa
     * @return void
     */
    public function formAction() {
        $id = $this->getRequest()->getParam('id', null);
        if(!is_null($id)) {
            $company = Default_Model_Company::read($id);
            $this->view->assign('company', $company);
        }
    }

}