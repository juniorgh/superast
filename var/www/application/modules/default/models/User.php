<?php

/** 
 * Modelo de execução de transações de dados entre a aplicação e a tabela `user`
 * do banco de dados
 * @package Default
 * @category Model
 * @author William Urbano <contato@williamurbano.com.br>
 */
class Default_Model_User {

    /** 
     * Insere um registro na tabela
     * @param  array           $data Dados a serem inseridos.
     * @return integer|boolean       Se bem sucedido, retorna a chave primária do registro inserido. Senão, retorna FALSE
     */
    public static function create(array $data) {
        $user = new Default_Model_DbTable_User();
        return $user->insert($data);
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
        $user = new Default_Model_DbTable_User();
        if(!is_null($id)) {
            $query = $user->select()->setIntegrityCheck(false)
            ->from(array('u' => 'user'))
            ->joinLeft(array('r' => 'role'), 'r.role_id = u.user_role')
            ->where('user_id = ?', $id);

            return $user->fetchRow($query)->toArray();
        } else {
            $query = $user->select()->setIntegrityCheck(false)
            ->from(array('u' => 'user'))
            ->joinLeft(array('r' => 'role'), 'r.role_id = u.user_role');

            if(!is_null($where)) {
                foreach($where as $cond) {
                    $query->where($cond);
                }
            }

            if(!is_null($order)) {
                $query->order($order);
            } else {
                $query->order('user_name');
            }

            if($pager == false) {
                return $user->fetchAll($query)->toArray();
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
        $user = new Default_Model_DbTable_User();
        $where = $user->getAdapter()->quoteInto('user_id = ?', $data['user_id']);
        unset($data['user_id']);
        return $user->update($data, $where);
    }

    /** 
     * Remove um registro da tabela
     * @param  integer  $id Valor da chave primária do registro que será removido
     * @return integer
     */
    public static function delete($id) {
        $user = new Default_Model_DbTable_User();
        $where = $user->getAdapter()->quoteInto('user_id = ?', $id);
        return $user->delete($where);
    }

    /** 
     * Retorna a expressão MD5() do MySQL com um valor passado por parâmetro
     * @param  string        $password Valor a ser passado para a expressão MD5()
     * @return Zend_Db_Expr            Objeto com a expressão para ser passada para o adaptador de consulta
     */
    public static function encodeMD5($password) {
        $user = new Default_Model_DbTable_User();
        return new Zend_Db_Expr($user->getAdapter()->quoteInto('MD5(?)', $password));
    }

}

