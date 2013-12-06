<?php

/** 
 * Modelo de execução de transações de dados entre a aplicação e a tabela `extension`
 * do banco de dados
 * @package Application
 * @subpackage Telephony
 * @category Model
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Telephony_Model_Extension {

    /** 
     * Insere um registro na tabela
     * @param  array           $data Dados a serem inseridos.
     * @return integer|boolean       Se bem sucedido, retorna a chave primária do registro inserido. Senão, retorna FALSE
     */
    public static function create(array $data) {
        $extension = new Telephony_Model_DbTable_Extension();
        return $extension->insert($data);
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
        $extension = new Telephony_Model_DbTable_Extension();
        $query = $extension->select()->setIntegrityCheck(false);

        if(!is_null($columns)) {
            $query->from(array('e' => 'extension'), array())
            ->join(array('s' => 'server'), 'e.extension_server = s.server_id', array())
            ->joinLeft(array('u' => 'user'), 'e.extension_user = u.user_id', array())
            ->columns($columns);
        } else {
            $query->from(array('e' => 'extension'))
            ->join(array('s' => 'server'), 'e.extension_server = s.server_id')
            ->joinLeft(array('u' => 'user'), 'e.extension_user = u.user_id');
        }

        if(!is_null($id)) {
            $query->where('extension_id = ?', $id);
            return $extension->fetchRow($query)->toArray();
        } else {
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            }

            return $pager === false ? $extension->fetchAll($query)->toArray() : $query;
        }
    }

    /** 
     * Atualiza um registro na tabela
     * @param  array   $data Dados que serão atualizados na tabela
     * @return integer
     */
    public static function update(array $data) {
        $extension = new Telephony_Model_DbTable_Extension();
        $id = $data['extension_id'];
        unset($data['extension_id']);
        $where = $extension->getAdapter()->quoteInto('extension_id = ?', $id);
        return $extension->update($data, $where);
    }

    /** 
     * Remove um registro da tabela
     * @param  integer  $id Valor da chave primária do registro que será removido
     * @return integer
     */
    public static function delete($id) {
        $extension = new Telephony_Model_DbTable_Extension();
        $where = $extension->getAdapter()->quoteInto('extension_id = ?', $id);
        return $extension->delete($where);
    }

}

