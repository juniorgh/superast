<?php

class Default_AuthenticationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $hasError = false;
        if(parent::_getParam('error') == 1) {
            $hasError = true;
        }
        $this->view->assign('hasError', $hasError);
        $this->_helper->layout->setLayout('login');
    }

    public function loginAction() {
        try {
            //Desabilita renderização da view
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->layout->disableLayout();

            $error_url = $this->view->url(array('module' => 'default', 'controller' => 'authentication', 'action' => 'error'), 'authentication_error');

            if($this->getRequest()->isPost()) {
                $params = $this->getRequest()->getPost();
                if(empty($params['user_login']) || empty($params['user_password'])) {
                    $this->_redirect($error_url);
                }

                //Obter o objeto do adaptador para autenticar usando banco de dados
                $dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
                $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

                //Seta qual tabela e colunas procurar o usuário
                $authAdapter->setTableName('user')
                    ->setIdentityColumn('user_login')
                    ->setCredentialColumn('user_password');

                //Seta as credenciais com dados vindos do formulário de login
                $authAdapter->setIdentity(parent::_getParam('user_login'))
                    ->setCredential(parent::_getParam('user_password'))
                    ->setCredentialTreatment('MD5(?)');

                //Realiza autenticação
                $result = $authAdapter->authenticate();

                //Verifica se a autenticação foi válida
                if($result->isValid()){
                    //Obtém dados do usuário
                    $usuario = (array) $authAdapter->getResultRowObject();
                    $usuario['menus'] = array();

                    $aux = array();
                    $menu = Default_Model_Menu::read(null, false, array('menu_parent IS NULL OR LENGTH(menu_parent) = 0'));
                    foreach($menu as $m) {
                        $aux[$m['menu_id']] = $m;
                    }

                    $menu = $aux;

                    foreach($menu as $k => $v) {
                        $childs1 = Default_Model_Menu::read(null, false, array("menu_parent = {$menu[$k]['menu_id']}"));
                        if(count($childs1) > 0) {
                            $aux = array();
                            foreach($childs1 as $c) {
                                $aux[$c['menu_id']] = $c;
                            }

                            $childs1 = $aux;

                            foreach($childs1 as $i => $j) {
                                $childs2 = Default_Model_Menu::read(null, false, array("menu_parent = {$childs1[$i]['menu_id']}"));
                                if(count($childs2) > 0) {
                                    $aux = array();
                                    foreach($childs2 as $c) {
                                        $aux[$c['menu_id']] = $c;
                                    }

                                    $childs2 = $aux;
                                    foreach($childs2 as $x => $y) {
                                        $childs3 = Default_Model_Menu::read(null, false, array("menu_parent = {$childs2[$x]['menu_id']}"));
                                        if(count($childs3) > 0) {
                                            $aux = array();
                                            foreach($childs3 as $c) {
                                                $aux[$c['menu_id']] = $c;
                                            }

                                            $childs3 = $aux;
                                            $childs2[$x]['childs'] = $childs3;
                                        }
                                    }

                                    $childs1[$i]['childs'] = $childs2;
                                }
                            }

                            $menu[$k]['childs'] = $childs1;
                        }
                    }

                    $usuario['menus'] = $menu;

                    //Armazena seus dados na sessão
                    $storage = Zend_Auth::getInstance()->getStorage();
                    $storage->write($usuario);

                    $this->_redirect($this->view->url(array('module' => 'dashboard'), 'dashboard_action'));
                } else {
                    $this->_redirect($error_url);
                }
            }

        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function logoutAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        Zend_Auth::getInstance()->clearIdentity();
        $url = $this->view->url(array('module' => 'default', 'controller' => 'authentication', 'action' => 'index'), 'authentication_index');
        $this->_redirect($url);
    }


}





