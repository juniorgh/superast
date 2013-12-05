<?php

/** 
 * Modelo de execução de transações de dados entre a aplicação e a tabela `agent_queue`
 * do banco de dados
 * @package Application
 * @subpackage Telephony
 * @category Model
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Telephony_Model_AgentQueue {

    /** 
     * Insere um registro na tabela
     * @param  array           $data Dados a serem inseridos.
     * @return integer|boolean       Se bem sucedido, retorna a chave primária do registro inserido. Senão, retorna FALSE
     */
    public static function create(array $data) {
        $agentQueue = new Telephony_Model_DbTable_AgentQueue();
        return $agentQueue->insert($data);
    }
    
    /** 
     * Busca um ou mais registros no banco de dados pela chave primária ou pelos parâmetros passados utilizados nas cláusulas SQL
     * @param  integer                    $id      Valor da chave primária do registro desejado
     * @param  boolean                    $pager   Define se a consulta é destinada ao Zend_Paginator
     * @param  array                      $where   Condicionais booleanas para preencher as cláusulas WHERE e AND para a consulta
     * @param  array                      $order   Campos para preencher a cláusula ORDER BY 
     * @param  array                      $columns Nomes das colunas que a consulta irá retornar. Se nulo, retorna todas as colunas
     * @return array|Zend_Db_Table_Select          Se $pager for FALSE retorna um array com o result set. Caso contrário, retorna um
     *                                             objeto do tipo Zend_Db_Table_Select para ser executado pelo Zend_Paginator
     */
    public static function read($id = null, $pager = false, array $where = null, array $order = null, array $columns = null) {
        $agent = new Telephony_Model_DbTable_AgentQueue();
        $query = $agent->select()
        ->setIntegrityCheck(false);

        if(!is_null($columns)) {
            $query->from(array('aq' => 'agent_queue'), array())
            ->join(array('a' => 'agent'), 'a.agent_id = aq.agent_queue_agent', array())
            ->join(array('q' => 'queue'), 'q.queue_id = aq.agent_queue_queue', array())
            ->columns($columns);
        } else {
            $query->from(array('aq' => 'agent_queue'))
            ->join(array('a' => 'agent'), 'a.agent_id = aq.agent_queue_agent')
            ->join(array('q' => 'queue'), 'q.queue_id = aq.agent_queue_queue');
        }

        if(!is_null($id)) {
            $query->where('agent_queue_id = ?', $id);
            return $agent->fetchRow($query)->toArray();
        } else {
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            }

            return $pager === false ? $agent->fetchAll($query)->toArray() : $query;
        }
    }

    /** 
     * Atualiza um registro na tabela
     * @param  array   $data Dados que serão atualizados na tabela
     * @return integer
     */
    public static function update(array $data) {}

    /** 
     * Remove um registro da tabela
     * @param  integer  $id Valor da chave primária do registro que será removido
     * @return integer
     */
    public static function delete($id) {
        $agent = new Telephony_Model_DbTable_AgentQueue();
        $where = $agent->getAdapter()->quoteInto('agent_queue_id = ?', $id);
        return $agent->delete($where);
    }

    /** 
     * Remove registros pela chave estrangeira que referencia a tabela `agent`
     * @param  string|integer  $agentId Valor da chave estrangeira que referencia a tabela `agent`
     * @return integer
     */
    public static function deleteByAgent($agentId) {
        $agent = new Telephony_Model_DbTable_AgentQueue();
        $where = $agent->getAdapter()->quoteInto('agent_queue_agent = ?', $agentId);
        return $agent->delete($where);
    }

    /** 
     * Remove registros pela chave estrangeira que referencia a tabela `queue`
     * @param  string|integer  $queueId Valor da chave estrangeira que referencia a tabela `queue`
     * @return integer
     */
    public static function deleteByQueue($queueId) {
        $agent = new Telephony_Model_DbTable_AgentQueue();
        $where = $agent->getAdapter()->quoteInto('agent_queue_queue = ?', $queueId);
        return $agent->delete($where);
    }
}

