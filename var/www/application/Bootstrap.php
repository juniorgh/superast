<?php

/**
 * Classe que inicializa a aplicação.
 * @package Application
 * @author William D. Urbano <contato@williamurbano.com.br>
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    /**
     * Define as rotas customizadas da aplicação
     * @return Zend_Controller_Router_Rewrite
     */
    protected function _initRoutes() {
        $front = Zend_Controller_Front::getInstance();
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini', 'routes');
        $router = $front->getRouter()->addConfig($config, 'routes');
        return $router;
    }

    /**
     * Instancia e registra os plugins utilizados pela aplicação
     * @return void
     */
    protected function _initPlugins() {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Application_Plugin_LayoutPlugin());
        $front->registerPlugin(new Application_Plugin_AuthenticationPlugin());
    }

    /**
     * Realiza o autoload de Namespaces da aplicação
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initAutoload() {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'basePath' => APPLICATION_PATH . '/modules/default/',
            'namespace' => 'Default'
        ));

        $autoloader = new Zend_Application_Module_Autoloader(array(
            'basePath' => APPLICATION_PATH . '/modules/telephony/',
            'namespace' => 'Telephony'
        ));

        $autoloader = new Zend_Application_Module_Autoloader(array(
            'basePath' => APPLICATION_PATH . '/modules/elastix/',
            'namespace' => 'Elastix'
        ));

        return $autoloader;
    }

    /** 
     * Define parâmetros padrões para a paginação
     * @return null
     */
    public function _initPagination() {
        return Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
    }

    /** 
     * Define os parâmetros padrões de localização.
     * @return null
     */
    public function _initLocale() {
        return Zend_Locale::setDefault('pt_BR');
    }
}