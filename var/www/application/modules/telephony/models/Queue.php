<?php

/** 
 * Modelo de execução de transações de dados entre a aplicação e a tabela `queue`
 * do banco de dados
 * @package Application
 * @subpackage Telephony
 * @category Model
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Telephony_Model_Queue {

    /** 
     * Insere um registro na tabela
     * @param  array           $data Dados a serem inseridos.
     * @return integer|boolean       Se bem sucedido, retorna a chave primária do registro inserido. Senão, retorna FALSE
     */
    public static function create(array $data) {
        $queue = new Telephony_Model_DbTable_Queue();
        return $queue->insert($data);
    }
    
    /** 
     * Busca um ou mais registros no banco de dados pela chave primária ou pelos parâmetros passados utilizados nas cláusulas SQL
     * @param  integer                    $id    Valor da chave primária do registro desejado
     * @param  boolean                    $pager Define se a consulta é destinada ao Zend_Paginator
     * @param  array                      $where Condicionais booleanas para preencher as cláusulas WHERE e AND para a consulta
     * @param  array                      $order Campos para preencher a cláusula ORDER BY 
     * @return array|Zend_Db_Table_Select        Se $pager for FALSE retorna um array com o result set. Caso contrário, retorna um
     *                                           objeto do tipo Zend_Db_Table_Select para ser executado pelo Zend_Paginator
     */
    public static function read($id = null, $pager = false, array $where = null, array $order = null) {
        $queue = new Telephony_Model_DbTable_Queue();
        if(!is_null($id)) {
            return $queue->find($id)->current()->toArray();
        } else {
            $query = $queue->select();
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            } else {
                $query->order('queue_name');
            }

            if($pager == false) {
                return $queue->fetchAll($query)->toArray();
            } else {
                return $query;
            }
        }
    }

    /** 
     * Atualiza um registro na tabela
     * @param  array   $data Dados que serão atualizados na tabela
     * @return integer
     */
    public static function update(array $data) {
        $queue = new Telephony_Model_DbTable_Queue();
        $where = $queue->getAdapter()->quoteInto('queue_id = ?', $data['queue_id']);
        unset($data['queue_id']);
        return $queue->update($data, $where);
    }
    
    /** 
     * Remove um registro da tabela
     * @param  integer  $id Valor da chave primária do registro que será removido
     * @return integer
     */
    public static function delete($id) {
        $queue = new Telephony_Model_DbTable_Queue();
        $where = $queue->getAdapter()->quoteInto('queue_id = ?', $id);
        return $queue->delete($where);
    }

}