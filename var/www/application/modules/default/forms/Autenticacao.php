<?php

class Default_Form_Autenticacao extends Zend_Form
{

    public function init()
    {
        try {
            $action = $this->getView()->url(array('module' => 'default', 'controller' => 'autenticacao', 'action' => 'login'));

            $usuario = $this->createElement('text', 'usuario', array('label' => "Usuário"));
            $usuario->setRequired(true);

            $senha = $this->createElement('password', 'senha', array('label' => "Senha"));
            $senha->setRequired(true);

            $submit = $this->createElement('submit', 'submit', array('label' => "Entrar"));

            $this->setAction($action);
            $this->addElements(array($usuario, $senha, $submit));
        } catch (Exception $e)  {
            echo $e->getMessage();
            exit;
        }
    }


}

