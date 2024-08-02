<?php
    class Adm{
        private $conn;
        public $id;
        public $user;
        public $pass;
        public function __construct($db)
        {
            $this->conn=$db;            
        }
        public function insert(){
            $sql="INSERT INTO adm (user,pass) VALUES (?,?)";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("ss",$this->user,$this->pass);
            if($stmt->execute())return true;return false;
        }
        public function fazerLogin(){
            $sql="SELECT * FROM adm WHERE user = ?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("s",$this->user);
            if($stmt->execute()){
                $res=(function($stmt){
                    return $stmt->fetch_array();
                })($stmt->get_result());                
                $pass=(function($res){
                   if($res!=null)return $res['pass'];return "";
                })($res);
                $id=(function($res){
                    if($res!=null)return $res['id'];return "";
                })($res);
                if(password_verify($this->pass,$pass))return $id;return false;            
            }return false;
        }
        public function read(){
            $sql="SELECT * FROM adm";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->get_result();
        }
    }

    class Produto{
        private $conn;
        public $id;
        public $nome;
        public $valor;
        public $desc;
        public $foto;
        public $status;
        
        public function __construct($db)
        {
            $this->conn=$db;   
        }
        public function insert(){
            $sql="INSERT INTO produtos (nome,valor,descricao,status) VALUES (?,?,?,?)";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("sssi",$this->nome,$this->valor,$this->desc,$this->status);
            if($stmt->execute())return true;return false;
        }
        public function update(){
            $sql="UPDATE produtos SET nome=?,valor=?,descricao=?,status=? WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("sssii",$this->nome,$this->valor,$this->desc,$this->status,$this->id);
            if($stmt->execute())return true;return false;
        }
        public function selectById($id){
            $sql="SELECT * FROM produtos WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("i",$id);
            if($stmt->execute())return $stmt->get_result();return false;
        }        
        public function selectAll(){
            $sql="SELECT * FROM produtos";
            $stmt=$this->conn->prepare($sql);
            if($stmt->execute())return $stmt->get_result();return false;
        }
        public function selectAllAtive(){
            $sql="SELECT * FROM produtos WHERE status=1";
            $stmt=$this->conn->prepare($sql);
            if($stmt->execute())return $stmt->get_result();return false;
        }
        public function delete(){
            $sql="DELETE FROM produtos WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("i",$this->id);
            if($stmt->execute()){
                //unlink("../../public/uploads/$this->id.png");
                return true;
            }return false;
        }
        public function selectMaxId($table) {
            $sql = "SELECT MAX(id) as id FROM ".$table;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_array();
            return $data['id'];
        }
    }
    class Vendedor{
        private $conn;
        public $id;
        public $senha;
        public $nome;
        public $email;
        public $st;
        public $id_end;
        public function __construct($db)
        {
            $this->conn=$db;
        }
        public function fazerLogin(){
            $sql="SELECT senha, id, status as st FROM vendedor WHERE email=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param('s',$this->email);
            if($stmt->execute()){
                $res=$stmt->get_result()->fetch_assoc();
                if($res['st']==1){
                    if(password_verify($this->senha,$res['senha']))return $res['id'];return false;
                }else return false;            
                
            }
        }
        public function insert(){
            $sql="INSERT INTO vendedor (senha,nome,email,status,id_endereco) VALUES (?,?,?,?,?)";
            $stmt=$this->conn->prepare($sql);
            $this->senha=password_hash($this->senha,PASSWORD_DEFAULT);
            $stmt->bind_param("sssii",$this->senha,$this->nome,$this->email,$this->st,$this->id_end);
            if($stmt->execute())return true;return false;

        }
        public function update(){
            $sql="UPDATE vendedor SET senha=?,nome=?,email=?,status=?,id_endereco=? WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("sssiii",$this->senha,$this->nome,$this->email,$this->st,$this->id_end,$this->id);
            if($stmt->execute())return true;return false;

        }
        public function SelectAll(){
            $sql="SELECT * FROM vendedor";
            $stmt=$this->conn->prepare($sql);
            if($stmt->execute())return $stmt->get_result();return false;
        }
        public function delete(){
            $sql="DELETE FROM vendedor WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("i",$this->id);
            if($stmt->execute())return true;return false;
        }
    }

    class Cliente{
        private $conn;
        public $id;
        public $nome;
        public $email;
        public $senha;
        public $id_endereco;
        
       public function __construct($db)
       {
            $this->conn=$db;
       }
       public function fazerLogin(){
            $sql="SELECT * FROM cliente WHERE email=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("s",$this->email);
            if($stmt->execute()){
                $res=$stmt->get_result()->fetch_array();
                if($res!=null){
                    if(password_verify($this->senha,$res['senha']))return $res['id'];return false;
                }return false;
            }
       }
       public function insert(){
            $sql="INSERT INTO cliente (nome,email,senha,id_endereco) VALUES (?,?,?,?)";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("sssi",$this->nome,$this->email,$this->senha,$this->id_endereco);
            if($stmt->execute())return true;return false;
       }
       public function update(){
            $sql="UPDATE cliente SET nome=?,email=?,senha=?,id_endereco=? WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("sssii",$this->nome,$this->email,$this->senha,$this->id_endereco,$this->id);
            if($stmt->execute())return true;return false;
       }
       public function selectAll(){
            $sql="SELECT * FROM cliente";
            $stmt=$this->conn->prepare($sql);
            if($stmt->execute())return $stmt->get_result();return false;
        }
        public function delete(){
            $sql="DELETE FROM cliente WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("i",$this->id);
            if($stmt->execute())return true;return false;
        }
    }

    class Carrinho{        
        private $conn;
        public $id;
        public $id_cliente;
        public $id_vendedor;
        public $id_produto;
        public $id_pagamento;
        public $valor;
        public $quantidade;

        public function __construct($db)
        {
            $this->conn=$db;
        }
        public function insert(){
            $sql="INSERT INTO carrinho(id_cliente,id_vendedor,id_produto,id_pagamento,valor,quantidade)VALUES(?,?,?,?,?,?)";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("iiissi",$this->id_cliente,$this->id_vendedor,$this->id_produto,$this->id_pagamento,$this->valor,$this->quantidade);
            if($stmt->execute())return true;return false;
        }
        public function update(){
            $sql="UPDATE carrinho SET valor=?,quantidade=? WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("sii",$this->valor,$this->quantidade,$this->id);
            if($stmt->execute())return true;return false;

        }
        public function selectAll(){
            $sql="SELECT * FROM carrinho";
            $stmt=$this->conn->prepare($sql);
            if($stmt->execute())return $stmt->get_result();return false;
        }
        public function selectById($id){
            $sql="SELECT * FROM carrinho WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("i",$id);
            if($stmt->execute())return $stmt->get_result();return false;
        }
        public function selectByIdClient($id){
            $sql="SELECT * FROM carrinho WHERE id_cliente=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("i",$id);
            if($stmt->execute())return $stmt->get_result();return false;
        }
        public function compare($id_cliente,$id_produto){
            $sql="SELECT * FROM carrinho WHERE id_cliente=? AND id_produto=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("ii",$id_cliente,$id_produto);
            if($stmt->execute())return $stmt->get_result()->fetch_assoc();return false;
        }
        private function getClientName($id){
            $sql="SELECT nome FROM cliente WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("i",$id);
            if($stmt->execute())return $stmt->get_result()->fetch_assoc()['nome'];return false;
        }
        public function getCars(){
            
            $sql="SELECT 
                    id_cliente as idC, SUM(valor) AS total_valor, SUM(quantidade) AS quantidade_total
                FROM 
                    carrinho
                GROUP BY 
                    id_cliente;
                "
            ;
            $stmt=$this->conn->prepare($sql);
            if($stmt->execute()){
                $res=$stmt->get_result();
                $cont=0;
                $dados=array(
                    "nome"  => "",
                    "valor" => "",
                    "qnt"   => ""
                );
                while($row = $res->fetch_array()){
                    
                    $dados[$cont]['nome']=$this->getClientName($row['idC']);
                    $dados[$cont]['valor']=$row['total_valor'];
                    $dados[$cont]['qnt']=$row['quantidade_total'];
                    $cont=$cont+1;                    
                }return $dados;
            }else return false;
        }
        public function getCarsByIdClient($id){
            $sql="SELECT 
                carrinho.id AS id,
                carrinho.id_cliente AS idC,
                carrinho.valor AS valor,
                produtos.nome AS Pnome,
                produtos.id AS idP,
                carrinho.quantidade AS qnt,
                SUM(carrinho.valor) OVER() AS valor_total,
                SUM(carrinho.quantidade) OVER() AS qnt_total
                FROM carrinho INNER JOIN produtos
                ON carrinho.id_produto=produtos.id
                WHERE carrinho.id_cliente=?
            ";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("s",$id);
            if($stmt->execute())return $stmt->get_result();return false;
        }
        private function valor_sum($id){
            $sql="SELECT valor, quantidade as qnt FROM carrinho WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("i",$id);
            if($stmt->execute()){
                $res=$stmt->get_result()->fetch_assoc();
                $valor=$res['valor'];
                $qnt=$res['qnt'];
                if($qnt==1){
                    $valor=$valor*2;
                    $qnt=$qnt+1;
                    return array($valor,$qnt);
                }else{
                    $valor=$valor+($valor/$qnt);
                    $qnt=$qnt+1;
                    return array($valor,$qnt);
                }
            }return false;
        }
        private function valor_sub($id){
            $sql="SELECT valor, quantidade as qnt FROM carrinho WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("i",$id);
            if($stmt->execute()){
                $res=$stmt->get_result()->fetch_assoc();
                $valor=$res['valor'];
                $qnt=$res['qnt'];
                $valor=$valor-($valor/$qnt);
                $qnt=$qnt-1;
                return array($valor,$qnt);          
            }return false;
        }
        public function sum($id){     
            $sql="UPDATE carrinho SET quantidade=?,valor=? WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $dado=$this->valor_sum($id);
            $v=$dado[0];$q=$dado[1];
            $stmt->bind_param("isi",$q,$v,$id);
            if($stmt->execute())return true;return false;

        }
        public function sub($id){
            $sql="UPDATE carrinho SET quantidade=?,valor=? WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $dado=$this->valor_sub($id);
            $v=$dado[0];$q=$dado[1];
            $stmt->bind_param("isi",$q,$v,$id);
            if($stmt->execute())return true;return false;

        }
    }

    class Avaliacoes{
        private $conn;
        public $id;
        public $nota;
        public $nome;
        public $email;
        public $text;
        public $hora;

        public function __construct($db)
        {
            $this->conn=$db;   
        }
        public function insert(){
            $sql="INSERT INTO avaliacoes (nota,nome,email,texto,hora) VALUES (?,?,?,?,?)";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("issss",$this->nota,$this->nome,$this->email,$this->text,$this->hora);
            if($stmt->execute())return true;return false;
        }
        public function update(){
            $sql="UPDATE avaliacoes SET nota=?,nome=?,email=?,texto=?,hora=? WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("issssi",$this->nota,$this->nome,$this->email,$this->text,$this->hora,$this->id);
            if($stmt->execute())return true;return false;
        }
        public function selectAll(){
            $sql="SELECT * FROM avaliacoes";
            $stmt=$this->conn->prepare($sql);
            if($stmt->execute())return $stmt->get_result();return false;
        }
        public function delete(){
            $sql="DELETE FROM avaliacoes WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("i",$this->id);
            if($stmt->execute())return true;return false;
        }
    }

    class Endereco{
        private $conn;
        public $id;
        public $pais;
        public $estado;
        public $cidade;
        public $rua;
        public $bairro;
        public $numero;
        public $complemento;

        public function __construct($db)
        {
            $this->conn=$db;
        }

        public function insert(){//fazer teste
            $sql="INSERT INTO endereco 
            (pais,estado,cidade,rua,bairro,numero,complemento)
            VALUES (?,?,?,?,?,?,?)";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("sssssis",$this->pais,$this->estado,$this->cidade,$this->rua,$this->bairro,$this->numero,$this->complemento);
            if($stmt->execute())return true;return false;
        }

        public function update(){
            $sql="UPDATE endereco SET pais=?,estado=?,cidade=?,rua=?,bairro=?,numero=?,complemento=?
            WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("sssssisi",$this->pais,$this->estado,$this->cidade,$this->rua,$this->bairro,$this->numero,$this->complemento,$this->id);
            if($stmt->execute())return true;return false;
        }

        public function delete(){
            $sql="DELETE FROM endereco.0";
        }
    }

    

    

    ?>