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
        try {
            $servers = Telephony_Model_Server::read();
            foreach($servers as $server) {
                if((bool) $server['server_is_elastix']) {
                    $db = Zend_Db::factory('Pdo_Mysql', array(
                        'host' => $server['server_ip_address'],
                        'username' => $server['server_database_user'],
                        'password' => $server['server_database_password'],
                        'dbname' => 'asterisk'
                    ));

                    $queuesConfig = new Elastix_Model_QueuesConfig($db);
                    $queuesDetails = new Elastix_Model_QueuesDetails($db);
                    $queues = $queuesConfig->read();

                    foreach($queues as $config) {
                        $queue = array_shift(Telephony_Model_Queue::read(null, false, array("queue_number = {$config['extension']}", "queue_server = {$server['server_id']}")));
                        $queue['queue_name'] = $config['descr'];
                        $queue['queue_number'] = $config['extension'];
                        $queue['queue_server'] = $server['server_id'];

                        if(array_key_exists('queue_id', $queue)) {
                            Telephony_Model_Queue::update($queue);
                        } else {
                            $queue['queue_id'] = Telephony_Model_Queue::create($queue);
                        }

                        Telephony_Model_AgentQueue::deleteByQueue($queue['queue_id']);

                        $details = $queuesDetails->readMembers($config['extension']);
                        $queueAgents = array();
                        
                        foreach($details as $detail) {
                            $queueAgents[] = str_replace(array('Agent', '/', ',0'), '', $detail['data']);
                        }

                        if(count($queueAgents) > 0) {
                            $agents = Telephony_Model_Agent::readAgentsList($queueAgents, $server['server_id']);
                            foreach($agents as $agent) {
                                $agent_queue = array(
                                    'agent_queue_agent' => $agent['agent_id'],
                                    'agent_queue_queue' => $queue['queue_id']
                                );

                                Telephony_Model_AgentQueue::create($agent_queue);
                            }
                        }
                    }
                }
            }

            $response = array('status' => true, 'message' => 'all right!');
        } catch (Exception $e) {
            $response = array('status' => false, 'message' => $e->getTraceAsString(), 'server' => $server);
        }

        $this->getResponse()->setHeader('Content-Type', 'application/json')->setBody(Zend_Json::encode($response));
    }

    /** 
     * Realiza a importação dos ramais do Asterisk cadastrados no Elastix.
     * @return void
     */
    public function extensionsAction() {
        try {
            $servers = Telephony_Model_Server::read(null, false, array('server_active = 1'));
            foreach($servers as $server) {
                if((bool) $server['server_is_elastix']) {
                    $db = Zend_Db::factory('Pdo_Mysql', array(
                        'host' => $server['server_ip_address'],
                        'username' => $server['server_database_user'],
                        'password' => $server['server_database_password'],
                        'dbname' => 'asterisk'
                    ));

                    $_users = new Elastix_Model_Users($db);
                    $users = $_users->read();
                    foreach($users as $user) {
                        $where = array("extension_number = '{$user['extension']}'", "extension_server = {$server['server_id']}");
                        $extension = array_shift(Telephony_Model_Extension::read(null, false, $where, null, array('e.*')));
                        $extension['extension_name'] = $user['name'];
                        $extension['extension_number'] = $user['extension'];
                        $extension['extension_server'] = $server['server_id'];

                        if(array_key_exists('extension_id', $extension)) {
                            Telephony_Model_Extension::update($extension);
                        } else {
                            $extension['extension_id'] = Telephony_Model_Extension::create($extension);
                        }
                    }
                }
            }

            $response = array('status' => true, 'message' => 'all right!');
        } catch (Exception $e) {
            $response = array('status' => false, 'message' => $e->getTraceAsString(), 'server' => $server);
        }

        $this->getResponse()->setHeader('Content-Type', 'application/json')->setBody(Zend_Json::encode($response));
    }

    /** 
     * Realiza a importação das campanhas ativas e receptivas do módulo Call
     * Center do Elastix.
     * @todo        As campanhas só poderão ser importadas após a integração da tabela CDR e o Asterisk.
     * @return void
     */
    public function campaignsAction() {
        try {
            $response = array('status' => true, 'message' => 'all right!');
        } catch (Exception $e) {
            $response = array('status' => false, 'message' => $e->getTraceAsString(), 'server' => $server);
        }
        $this->getResponse()->setHeader('Content-Type', 'application/json')->setBody(Zend_Json::encode($response));
    }

    /** 
     * Realiza a importação dos agentes cadastrados no Elastix.
     * @return void
     */
    public function agentsAction() {
        try {
            $servers = Telephony_Model_Server::read(null, false, array('server_active = 1'));
            foreach($servers as $server) {
                if((bool) $server['server_is_elastix'] && (bool) $server['server_has_callcenter']) {
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
        } catch (Exception $e) {
            $response = array('status' => false, 'message' => $e->getTraceAsString(), 'server' => $server);
        }

        $this->getResponse()->setHeader('Content-Type', 'application/json')->setBody(Zend_Json::encode($response));
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
