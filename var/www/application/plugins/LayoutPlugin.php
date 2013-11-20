<?php
/**
 * Plugin de gerenciamento do layout da aplicação.
 * 
 * @package Application
 * @category Plugin
 * @author William D. Urbano <contato@williamurbano.com.br>
 * 
 */
class Application_Plugin_LayoutPlugin extends Zend_Controller_Plugin_Abstract {

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
     * 
     * @param type Zend_Controller_Request_Abstract $request 
     * @return void
     */
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {

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
        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();
        $view->addScriptPath(APPLICATION_PATH . '/layouts/partials');
        $view->doctype('HTML5');
        $view->setEncoding('utf-8');

        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        $javascriptPath = $config->frontend->assets->javascriptPath;

        $public_path = realpath(APPLICATION_PATH . '/../public/') . '/';

        $mvc = array($request->getModuleName(), $request->getControllerName(), $request->getActionName() . '.js');
        $actionjs = '../../application/javascript/' . implode('/', $mvc);

        $scripts = array("jquery-2.0.3.min.js", "semantic.min.js", '../../application/javascript/setup.js', $actionjs);

        foreach($scripts as $file) {
            $filename = realpath($javascriptPath . $file);
            if(file_exists($filename)) {
                $view->headScript()->appendFile(str_replace($public_path, '', $filename));
            }
        }

        $cssPath = $config->frontend->assets->cssPath;
        $styles = array(
            array(
                "href" => "semantic.min.css",
                "media" => "all"
            ),
            array(
                "href" => "../../application/css/setup.css",
                "media" => "all"
            )
        );
        
        foreach($styles as $file) {
            $filename = realpath($cssPath . $file["href"]);
            if(file_exists($filename)) {
                $view->headLink()->appendStylesheet(str_replace($public_path, '', $filename), $file["media"]);
            }
        }

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