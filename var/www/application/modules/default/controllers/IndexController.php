<?php
/**
 * Default Index Controller
 * Controladora inicial e padrão da aplicação
 * 
 * @package Default
 * @category Controller
 * @author William D. Urbano <contato@williamurbano.com.br>
 */
class Default_IndexController extends Zend_Controller_Action
{

    /**
     * Método construtor da controladora
     * 
     * @return void
     */
    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * Método de índice da controladora
     * 
     * @return void
     */
    public function indexAction()
    {
        echo "<pre>";
        print_r($this->_getAllParams());
        echo '</pre>';
    }


}

