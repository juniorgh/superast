<?php

/** 
 * Controladora índice de integração com os servidores Elastix.
 * @package Elastix
 * @category Controller
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Elastix_IndexController extends Zend_Controller_Action {

    /** 
     * Método construtor da controladora. Não executa procedimentos
     * @return void
     */
    public function init() {}

    /** 
     * Realiza conexão com o módulo Call Center do Elastix por meio do Elastix
     * Call Center Protocol para obter as informações dos agentes logados
     * @return void
     */
    public function indexAction() {
        try {
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->layout->disableLayout();

            $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
            $eccp = new Elastix_Eccp();

            $server = Telephony_Model_Server::read(2);
            $eccp->connect($server['server_ip_address'], $config->elastix->eccp->login, $config->elastix->eccp->secret);
            $eccp->setAgentNumber('Agent/2045');
            $eccp->setAgentPass('2045');
            $status = $eccp->getAgentStatus();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }


}

