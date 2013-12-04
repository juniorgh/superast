<?php

/** 
 * Modelo de execução de transações de dados entre a aplicação e a tabela `server`
 * do banco de dados
 * @package Application
 * @subpackage Telephony
 * @category Model
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Telephony_Model_Server {

    /** 
     * Insere um registro na tabela
     * @param  array           $data Dados a serem inseridos.
     * @return integer|boolean       Se bem sucedido, retorna a chave primária do registro inserido. Senão, retorna FALSE
     */
    public static function create($data) {
        $server = new Telephony_Model_DbTable_Server();
        return $server->insert($data);
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
    public static function read($id = null, $pager = false, $where = null, $order = null) {
        $server = new Telephony_Model_DbTable_Server();
        if(!is_null($id)) {
            return $server->find($id)->current()->toArray();
        } else {
            $query = $server->select();
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            } else {
                $query->order('server_hostname');
            }

            if($pager == false) {
                return $server->fetchAll($query)->toArray();
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
    public static function update($data) {
        $server = new Telephony_Model_DbTable_Server();
        $where = $server->getAdapter()->quoteInto('server_id = ?', $data['server_id']);
        unset($data['server_id']);
        return $server->update($data, $where);
    }
    
    /** 
     * Remove um registro da tabela
     * @param  integer  $id Valor da chave primária do registro que será removido
     * @return integer
     */
    public static function delete($id) {
        $server = new Telephony_Model_DbTable_Server();
        $where = $server->getAdapter()->quoteInto('server_id = ?', $id);
        return $server->delete($where);
    }

}