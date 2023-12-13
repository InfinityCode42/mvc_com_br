<?php

namespace backoffice\src\controller\core;
use Exception;
use Firebase\JWT\JWT;

use Firebase\JWT\Key;
use \PDO;
use \PDOException;
use const \HOSTNAME;
use const \PORT;
use const \USERNAME;
use const \PASSWORD;
use const \DATABASE;

class Core
{


    private $database;
    private $host;
    private $username;
    private $password;
    private $dsn;
    private $pdo;
    public function __construct()
    {

        $this->database = DATABASE;
        $this->host = HOSTNAME;
        $this->username = USERNAME;
        $this->password = PASSWORD;

        try {
            $this->dsn = "mysql:host=$this->host;dbname=$this->database";
            $this->pdo = new \PDO($this->dsn, $this->username, $this->password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }


    }

    public function verificaLogin()
    {
        session_start();
        // $this->pre($_SESSION);
        if(isset($_SESSION['usuario_id']) && ($_SESSION['usuario_id'] != null || $_SESSION['usuario_id'] != "")) {

            $verifica = $this->getData('usuarios_autenticados', 'usuario_id, token, data', ['usuario_id' => $_SESSION['usuario_id']]);
            
            if (!empty($verifica)) {

                $token = $this->verificaToken($verifica[0]['token']);

                if ($token != true) {

                    session_destroy();
                    $this->redirect('/');
                }
            }
        }else{
            $this->redirect('/');        
        }
    }
    
    public function verificaModulos() {
        // $req = $_SERVER['REQUEST_URI'];
        // $rota = $this->getData('modulos', 'id, rota', ['rota' => $req]);
        // $usuario = $this->getData('usuarios', 'id, modulos', ['id' => $_SESSION['usuario_id']]);
        
        // $explode_modulos = explode(',', $usuario[0]['modulos']);
        // foreach ($rota as $key => $value) {
        //     $rota_atual['rotas'] = $value['id'];
        //     $rota_atual['solicitada'] = $explode_modulos[$key];
        // }
        
        // if( $rota_atual['rotas'] == $rota_atual['solicitada']){
        //     $redirecionar = $this->getData('modulos', 'id, rota', ['id' => $rota_atual['solicitada']]);
        //     $this->redirect($redirecionar[0]['rota']);
        // } else {
        //     echo "O usuário NÃO tem acesso à rota $rota_atual";
        // }
        
    }

    public function pre($dados)
    {
        echo '<pre>';
        print_r($dados);
        echo '</pre>';
        die();
    }

    public function return ($status, $title = '', $message = '', $data = [])
    {
        $response = json_encode(['status' => $status, 'title' => $title, 'message' => $message, 'data' => $data]);
        echo $response;
        exit;
    }
    public function redirect($link, $status = "", $title = "", $message = "")
    {
        header('location:' . $link);
        exit;
    }

    public function verModulos()
    {
        $usuario = $this->getData('usuarios', 'id, modulos', ['id' => $_SESSION['usuario_id']]);
        $array_modulos_usuario = explode(",", $usuario[0]['modulos']);

        $modulos = array();

        foreach ($array_modulos_usuario as $id) {
            $modulo = $this->getData('modulos', '*', ['id' => $id]);
            $modulos[] = $modulo;
        }

        $modulos_liberados = array();

        foreach ($modulos as $key => $value) {
            $modulo_liberado = array();
            foreach ($value as $chave => $valor) {
                $modulo_liberado['id'] = $valor['id'];
                $modulo_liberado['rota'] = $valor['rota'];
                $modulo_liberado['ordem'] = $valor['ordem'];
                $modulo_liberado['status'] = $valor['status'];
                $modulo_liberado['label'] = $valor['label'];
                $modulo_liberado['icone'] = $valor['icone'];
            }
            $modulo_liberado['active'] = ($valor['rota'] === $_SERVER['REQUEST_URI']) ? 'active' : '';

            $modulos_liberados[] = $modulo_liberado;
        }
        $item = '';
        foreach ($modulos_liberados as $key => $value) {
            $item .= "<li class='nav-item'>
                <a class='nav-link  $value[active]' href='$value[rota]'>
                  <div class='icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center'>
                    $value[icone]
                  </div>
                  <span class='nav-link-text ms-1'>$value[label]</span>
                </a>
              </li>";
        }
        return $item;
    }

    function salvarImagemCliente($arquivo)
    {
        if ($arquivo['error'] != UPLOAD_ERR_OK) {
            return false;
        }

        if (!file_exists('public/img/img_clientes')) {
            mkdir('public/img/img_clientes', 0777, true);
        }

        $nomeArquivo = md5(time()) . '.' . $arquivo['type'];
        move_uploaded_file($arquivo['tmp_name'], 'public/img/img_clientes/' . $nomeArquivo);

        return $nomeArquivo;
    }

    public function getData($table, $columns = '', $where = [], $order = '', $join = '')
    {
        if ($order == '') {
            $order = 'DESC';
        }

        try {
            if ($columns == '') {
                $query = "SELECT * FROM $table AS a";
            } elseif ($where == '') {
                $query = "SELECT $columns FROM $table AS a ORDER BY id $order";
            } else {
                $whereClause = '';
                if (!empty($where)) {
                    $whereClause = 'WHERE ';
                    $i = 0;
                    foreach ($where as $key => $value) {
                        if ($i > 0) {
                            $whereClause .= " AND $key = :key$i";
                        } else {
                            $whereClause .= "$key = :key$i";
                        }
                        $i++;
                    }
                }

                $joinClause = ($join != '') ? "$join " : '';
                $query = "SELECT $columns FROM $table AS a $joinClause $whereClause ORDER BY ID $order";
            }

            $stmt = $this->pdo->prepare($query);

            if (!empty($where)) {
                $i = 0;
                foreach ($where as $key => $value) {
                    $stmt->bindValue(":key$i", $value);
                    $i++;
                }
            }

            $stmt->execute();
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $dados;
        } catch (PDOException $error) {
            echo "Erro: " . $error->getMessage();
            return false;
        }
    }

    public function addData($table, $data = [])
    {

        try {

            $columns = [];
            $values = [];

            foreach ($data as $key => $value) {
                $columns[] = "`$key`";
                $values[] = "'$value'";
            }

            $query = "INSERT INTO $table (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ")";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function alterData($table, array $data, array $where)
    {
        try {
            $setClause = "";
            $params = [];
            $index = 1;

            foreach ($data as $column => $value) {
                $setClause .= "$column = :param$index";
                $params[":param$index"] = $value;
                $index++;

                if ($index <= count($data)) {
                    $setClause .= ", ";
                }
            }

            $whereClause = "";
            $whereParams = [];
            $index = 1;
            $whereParam = "whereParam";

            foreach ($where as $column => $value) {
                $whereClause .= "$column = :$whereParam$index";
                $whereParams[":$whereParam$index"] = $value;
                $index++;

                if ($index <= count($where)) {
                    $whereClause .= " AND ";
                }
            }

            $query = "UPDATE $table SET $setClause WHERE $whereClause";
            $statement = $this->pdo->prepare($query);
            $statement->execute($params + $whereParams);

            return true;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }
    public function removeData($table, $where)
    {
        try {
            $whereClause = '';
            foreach ($where as $key => $value) {
                if ($whereClause !== '') {
                    $whereClause .= ' AND ';
                }
                $whereClause .= "$key = :$key";
            }
            $query = "DELETE FROM $table WHERE $whereClause";
            $stmt = $this->pdo->prepare($query);
            foreach ($where as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    function gerarToken($usuario_id, $arrayDados, $ip_usuario)
    {
        $jwtConfig = [
            'issuer' => 'novastack_com_br',
            'audience' => 'novastack',
            'expires' => strtotime('+1 day')
        ];
    
        $arrayDados['usuario_id'] = $usuario_id;
        $arrayDados['ip'] = $ip_usuario;
    
        $token = JWT::encode($arrayDados, JWT_KEY, 'HS256');
        $auth = $this->getData('usuarios_autenticados', "token, usuario_id, data", ['usuario_id' => $usuario_id]);
    
        if (!empty($auth)) {
            $alterar['data'] = date('Y-m-d', $jwtConfig['expires']);
            $atualizar = $this->alterData('usuarios_autenticados', $alterar, ['usuario_id' => $usuario_id]);
            
            if ($atualizar != '1') {
                $this->return('error', 'Erro', 'Não foi possível atualizar o token.');
                return false; 
            }
            return true;
        }
        $autenticacao = [
            'usuario_id' => $usuario_id,
            'token' => $token,
            'ip' => $ip_usuario,
            'data' => date('Y-m-d H:i:s', $jwtConfig['expires'])
        ];
        $res = $this->addData('usuarios_autenticados', $autenticacao);
    
        if ($res !== 1) {
            return $this->return('error', 'Erro', 'Não foi possível adicionar o token.');
        }
    
        return true;
    }

    public function verificaToken($token){
        try {
            $key = JWT_KEY;
            JWT::decode($token, new Key($key, 'HS256'));

            return true;
        } catch (Exception $e) {
            echo "error: " . $e->getMessage();
            return false;
        }
    }

   

}