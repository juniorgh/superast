<?php
/**
 * 
 * Classe que inicializa a aplicação.
 * 
 * @package Application
 * @author William D. Urbano <contato@williamurbano.com.br>
 * 
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    /**
     * Inicia as rotas customizadas da aplicação.
     * 
     * @return void
     */
    protected function _initRoutes() {
        $front = Zend_Controller_Front::getInstance();
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini', 'routes');
        $router = $front->getRouter()->addConfig($config, 'routes');
        return $router;
    }

    /**
     * Instancia e registra os plugins utilizados pela aplicação.
     * 
     * @return void
     */
    protected function _initPlugins() {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Application_Plugin_LayoutPlugin());
        $front->registerPlugin(new Application_Plugin_AutenticacaoPlugin());
    }

    /**
     * Realiza o autoload de Namespaces da aplicação.
     * 
     * @return void
     */
    protected function _initAutoload() {
        new Zend_Application_Module_Autoloader(array(
            'basePath' => APPLICATION_PATH . '/modules/default/',
            'namespace' => 'Default'
        ));

        new Zend_Application_Module_Autoloader(array(
            'basePath' => APPLICATION_PATH . '/modules/telephony/',
            'namespace' => 'Telephony'
        ));
    }

    public function _initPagination() {
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
    }
}