<?php

/** 
 * Controladora de importação de dados do Elastix
 * @package Elastix
 * @category Controller
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Elastix_ImportController extends Zend_Controller_Action {

    /** 
     * Método construtor da controladora. Impede a renderização dos view
     * scripts e desabilita a utilização do layout da aplicação.
     * @return void
     */
    public function init() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
    }

    /** 
     * Action index da controladora, não executa ações.
     * @return void
     */
    public function indexAction() {}

    /** 
     * Realiza a importação das filas de atendimento do Asterisk cadastradas
     * no Elastix.
     * @return void
     */
    public function queuesAction() {
        $result = array('status' => true, 'message' => 'all right!');
        $this->getResponse()->setHeader('Content-Type', 'application/json')->setBody(Zend_Json::encode($result));
    }

    /** 
     * Realiza a importação dos ramais do Asterisk cadastrados no Elastix.
     * @return void
     */
    public function extensionsAction() {
        $result = array('status' => true, 'message' => 'all right!');
        $this->getResponse()->setHeader('Content-Type', 'application/json')->setBody(Zend_Json::encode($result));
    }

    /** 
     * Realiza a importação das campanhas ativas e receptivas do módulo Call
     * Center do Elastix.
     * @return void
     */
    public function campaignsAction() {
        $result = array('status' => true, 'message' => 'all right!');
        $this->getResponse()->setHeader('Content-Type', 'application/json')->setBody(Zend_Json::encode($result));
    }

    /** 
     * Realiza a importação dos agentes cadastrados no Elastix.
     * @return void
     */
    public function agentsAction() {
        try {
            $servers = Telephony_Model_Server::read(null, false, array('server_active = 1'));
            foreach($servers as $server) {
                if((bool) $server['server_is_elastix']) {
                    $db = Zend_Db::factory('Pdo_Mysql', array(
                        'host' => $server['server_ip_address'],
                        'username' => $server['server_database_user'],
                        'password' => $server['server_database_password'],
                        'dbname' => 'call_center'
                    ));

                    $elastixAgent = new Elastix_Model_Agent($db);
                    $ext_agents = $elastixAgent->read(null, false);

                    foreach($ext_agents as $k => $v) {
                        $status = $v['estatus'] == 'A' ? 1 : 0;
                        $where = array("agent_active = {$status}", "agent_server = {$server['server_id']}", "agent_number = {$v['number']}");
                        $agent = array_shift(Telephony_Model_Agent::read(null, false, $where, null, array('a.*')));

                        $agent['agent_name'] = $v['name'];
                        $agent['agent_number'] = $v['number'];
                        $agent['agent_password'] = $v['password'];
                        $agent['agent_server'] = $server['server_id'];
                        $agent['agent_active'] = $v['estatus'] == 'A' ? 1 : 0;

                        if(array_key_exists('agent_id', $agent)) {
                            Telephony_Model_Agent::update($agent);
                        } else {
                            $agent['agent_id'] = Telephony_Model_Agent::create($agent);
                        }
                    }
                }
            }

            $response = array('status' => true, 'message' => 'Importação ok!');
            $this->getResponse()->setHeader('Content-Type', 'application/json')->setBody(Zend_Json::encode($response));
        } catch (Exception $e) {
            $response = array('status' => false, 'message' => $e->getMessage(), 'server' => $server );
            $this->getResponse()->setHeader('Content-Type', 'application/json')->setBody(Zend_Json::encode($response));
        }
    }

    /** 
     * Recebe uma requisição do processo que faz a sincronia do banco de dados
     * e envia um email ao administrador do sistema caso ocorra algum erro
     * durante a importação.
     * @return void
     */
    public function failureMailAction() {
        $request = $this->getRequest();
        $params = $request->getPost();

        switch($params['import-type']) {
            case 'agents':
            $importType = "dos agentes";
            break;
            case 'queues':
            $importType = "das filas";
            break;
            case 'extensions':
            $importType = "dos ramais";
            break;
            case 'campaigns':
            $importType = "das campanhas";
            break;
        }

        // variables assign
        $this->view->assign('message', $params['message']);
        $this->view->assign('importType', $importType);
        $this->view->assign('now', Zend_Date::now());

        // enviando informação de email
        $content = $this->view->render($request->getControllerName() . DIRECTORY_SEPARATOR . $request->getActionName() . '.phtml');
        $mail = new Zend_Mail('UTF-8');
        $mail->addTo('william.urbano@scitechinfo.com.br', 'William Urbano');
        $mail->setSubject('CRM : Importação de dados');
        $mail->setBodyHtml($content);
        $mail->send();
    }


}
