<?php
/**
 * Plugin de autenticação de usuários.
 * 
 * @package Application
 * @category Plugin
 * @author William D. Urbano <contato@williamurbano.com.br>
 * 
 */
class Application_Plugin_AutenticacaoPlugin extends Zend_Controller_Plugin_Abstract {

    /**
     * Método invocado antes da execução da controladora para avaliar
     * se a requisição está de acordo com as rotas registradas.
     * 
     * @param type Zend_Controller_Request_Abstract $request 
     * @return void
     */
    public function routeStartup(Zend_Controller_Request_Abstract $request) {

    }
    
    /**
     * Método invocado após o roteador da aplicação finalizar o
     * roteamento da requisição.
     * 
     * @param type Zend_Controller_Request_Abstract $request 
     * @return type
     */
    public function routeShutdown(Zend_Controller_Request_Abstract $request) {

    }
 
    /**
     * Método invocado antes do início do loop de despacho.
     * Verifica se o usuário está autenticado. Se não estiver
     * o envia para a página de autenticação.
     * 
     * @param type Zend_Controller_Request_Abstract $request 
     * @return void
     */
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
        if(!Zend_Auth::getInstance()->hasIdentity() && $request->getControllerName() != "authentication") {
            $view = new Zend_View();
            $url = $view->url(array('module' => 'default', 'controller' => 'authentication', 'action' => 'index'), 'authentication_index');
            $redirector = new Zend_Controller_Action_Helper_Redirector;
            $redirector->gotoUrl($url)->redirectAndExit();
        }

        if(Zend_Auth::getInstance()->hasIdentity() && $request->getControllerName() == "authentication" && $request->getActionName() == "index") {
            $view = new Zend_View();
            $url = $view->url(array('module' => 'dashboard'), 'dashboard_action');
            $redirector = new Zend_Controller_Action_Helper_Redirector;
            $redirector->gotoUrl($url)->redirectAndExit();
        }
    }
 
    /**
     * Método invocado antes que uma Action seja executada e despachada.
     * Este método permite verificar o comportamento de filtros. Alterando
     * a requisição e redefinindo seus parâmetros a Action atual pode ser
     * ignorada e/ou substituída.
     * 
     * @param type Zend_Controller_Request_Abstract $request 
     * @return void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) {

    }
 
    /**
     * Méodo invocado após a execução de uma Action. Este método permite
     * verificar o comportamento de filtros. Alterando a requisição e redefinindo
     * seus parâmetros uma nova Action pode ser definida para despacho.
     * 
     * @param type Zend_Controller_Request_Abstract $request 
     * @return void
     */
    public function postDispatch(Zend_Controller_Request_Abstract $request) {

    }
 
    /**
     * Método invocado após o fim da execução do loop de despacho.
     * 
     * @return void
     */
    public function dispatchLoopShutdown() {

    }
    
}