<?php
/**
 * Default Index Controller
 * Controladora inicial e padrão da aplicação
 * 
 * @package Default
 * @category Controller
 * @author William D. Urbano <contato@williamurbano.com.br>
 */
class Default_UsuariosController extends Zend_Controller_Action
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
        $this->view->assign('params', parent::_getAllParams());
        
    }

    public function editarAction()
    {
        $this->view->assign('params', parent::_getAllParams());
    }

    public function visualizarAction()
    {
        $this->view->assign('params', parent::_getAllParams());
    }

    public function excluirAction()
    {
        $this->view->assign('params', parent::_getAllParams());
    }


}

