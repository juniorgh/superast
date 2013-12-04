<?php

/** 
 * Modelo de execução de transações de dados entre a aplicação e a tabela `role`
 * do banco de dados
 * @package Default
 * @category Model
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Default_Model_Role {

    /** 
     * Insere um registro na tabela
     * @param  array           $data Dados a serem inseridos.
     * @return integer|boolean       Se bem sucedido, retorna a chave primária do registro inserido. Senão, retorna FALSE
     */
    public static function create(array $data) {
        $role = new Default_Model_DbTable_Role();
        return $role->insert($data);
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
        $role = new Default_Model_DbTable_Role();
        if(!is_null($id)) {
            return $role->find($id)->current()->toArray();
        } else {
            $query = $role->select();
            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            } else {
                $query->order('role_name');
            }

            if($pager == false) {
                return $role->fetchAll($query)->toArray();
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
        $role = new Default_Model_DbTable_Role();
        $where = $role->getAdapter()->quoteInto('role_id = ?', $data['role_id']);
        unset($data['role_id']);
        return $role->update($data, $where);
    }

    /** 
     * Remove um registro da tabela
     * @param  integer  $id Valor da chave primária do registro que será removido
     * @return integer
     */
    public static function delete($id) {
        $role = new Default_Model_DbTable_Role();
        $where = $role->getAdapter()->quoteInto('role_id = ?', $id);
        return $role->delete($where);
    }

}

