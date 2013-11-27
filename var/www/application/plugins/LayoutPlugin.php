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
        $view->doctype('HTML5');
        $view->headMeta()->setCharset('utf-8')
        ->appendHttpEquiv('X-UA-Compatible', 'IE=edge,chrome=1')
        ->appendHttpEquiv('viewport', 'width=device-width, initial-scale=1.0');

        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        $javascriptPath = $config->frontend->assets->javascriptPath;

        $public_path = realpath(APPLICATION_PATH . '/../public/') . '/';

        $mvc = array($request->getModuleName(), $request->getControllerName(), $request->getActionName() . '.js');
        $actionjs = '../../application/javascript/' . implode('/', $mvc);

        $scripts = array("jquery-2.0.3.min.js", "jquery-migrate-1.2.1.min.js", "semantic.min.js", '../../application/javascript/setup.js');
        $scripts[] = '../../application/vendor/jqplot/jquery.jqplot.min.js';
        $scripts[] = '../../application/vendor/jqplot/plugins/jqplot.pieRenderer.min.js';
        $scripts[] = $actionjs;

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
            ),
            array(
                "href" => '../../application/vendor/jqplot/jquery.jqplot.min.css',
                "media" => "all"
            )
        );
        
        foreach($styles as $file) {
            $filename = realpath($cssPath . $file["href"]);
            if(file_exists($filename)) {
                $view->headLink()->appendStylesheet(str_replace($public_path, '', $filename), $file["media"]);
            }
        }

        $usuario = Zend_Auth::getInstance()->getIdentity();
       
        $menus = Superast_Utils_MenuIterator::findActive($usuario['menus'], $request->getModuleName(), $request->getControllerName());
        $menus = Superast_Utils_MenuIterator::makeActiveHierarchy($menus);
        $active_node = Superast_Utils_MenuIterator::getActiveNode($menus);
        $active = Superast_Utils_MenuIterator::getLastActive($active_node);
        $title = Superast_Utils_MenuIterator::getPagesTitle($active_node);

        $actions = array('index' => '', 'add' => '', 'save' => '');

        foreach($actions as $k => $v) {
            $varname = sprintf('active%sAction', ucfirst($k));
            $route = str_replace('index', $k, $active['menu_route']);
            $actions[$k] = $view->url(array(
                    'module' => $request->getModuleName(),
                    'controller' => $request->getControllerName(),
                    'action' => $k
                ), $route, true);
        }

        $exp = explode('_', $active['menu_route']);

        $route_prefix = $exp[0] != "index" ? $exp[0] . "_" : "";

        $routes = array(
            "view" => $route_prefix . "view_action",
            "drop" => $route_prefix . "drop_action",
            "save" => $route_prefix . "save_action",
            "edit" => $route_prefix . "edit_action",
            "add" => $route_prefix . "add_action",
            "index_pager" => $route_prefix . "index_pager_action",
            "index" => $route_prefix . "index_action"
        );

        foreach($title as $t) {
            $view->headTitle($t);
        }

        $view->headTitle()->setSeparator(' : ');

        $partial_header = $view->partial('header.phtml', array('active_menu' => $active, 'routes' => $routes));
        $partial_sidebar = $view->partial('sidebar.phtml', array('menu' => $menus, 'routes' => $routes));
        $partial_navigation = $view->partial('navigation.phtml', array('menu' => $menus, 'routes' => $routes));

        $view->assign('partial_header', $partial_header);
        $view->assign('partial_sidebar', $partial_sidebar);
        $view->assign('partial_navigation', $partial_navigation);
        $view->assign('actions', $actions);
        $view->assign('moduleName', $request->getModuleName());
        $view->assign('controllerName', $request->getControllerName());
        $view->assign('actionName', $request->getActionName());
        $view->assign('routes', $routes);
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