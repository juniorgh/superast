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

    protected function _initView() {
    }

    /**
     * Instancia e registra os plugins utilizados pela aplicação.
     * 
     * @return void
     */
    protected function _initPlugins() {
        $layout = new Application_Plugin_LayoutPlugin();
        $autenticacao = new Application_Plugin_AutenticacaoPlugin();

        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin($layout);
        $front->registerPlugin($autenticacao);

    }

    /**
     * Realiza o autoload de Namespaces da aplicação.
     * 
     * @return void
     */
    protected function _initAutoload() {
        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
            'basePath'      => APPLICATION_PATH,
            'namespace'     => 'Application',
            'resourceTypes' => array(
                'decorator' => array(
                    'path'      => 'decorators/',
                    'namespace' => 'Decorator',
                )
            ),
        ));

        $autoloader = new Zend_Application_Module_Autoloader(array(
            'basePath' => APPLICATION_PATH.'/modules/default/',
            'namespace' => 'Default'
        ));
    }
}

