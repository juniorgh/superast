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
        $form = new Default_Form_Autenticacao();
        $this->view->assign("form", $form);
    }


}

