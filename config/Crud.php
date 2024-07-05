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
        public function selectAll(){
            $sql="SELECT * FROM produtos";
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
                $res=(function($res){
                    return $res->fetch_array();
                })($stmt->get_result());
                $pass=(function($res){
                    if($res!=null)return $res['senha'];return "";
                })($res);
                $id=(function($res){
                    if($res!=null)return $res['id'];return "";
                })($res);
                if(password_verify($this->senha,$pass))return $id;return false;
            }return false;
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
        public $id_produto;
        public $valor_carrinho;

        public function __construct($db)
        {
            $this->conn=$db;   
        }

        public function insert(){
            $sql="INSERT INTO carrinho (id_cliente,id_produto,valor_carrinho) VALUES (?,?,?)";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("iis",$this->id_cliente,$this->id_produto,$this->valor_carrinho);
            if($stmt->execute())return true;return false;
        }
        public function update(){
            $sql="UPDATE carrinho SET id_cliente=?,id_produto=?,valor_carrinho=? WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("iisi",$this->id_cliente,$this->id_produto,$this->valor_carrinho,$this->id);
            if($stmt->execute())return true; return false;
        }
        public function selectAll(){
            $sql="SELECT * FROM carrinho";
            $stmt=$this->conn->prepare($sql);
            if($stmt->execute())return $stmt->get_result();return false;
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

    class Pedidos{
        private $conn;
        public $id;
        public $id_produto;
        public $id_cliente;
        public $id_vendedor;
        public $valor_compra;

        public function __construct($db)
        {
            $this->conn=$db;
        }           
        public function insert(){
            $sql="INSERT INTO pedidos (id_produto,id_cliente,id_vendedor)
            VALUES (?,?,?,?,?,?)";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("iiiiis",$this->id_produto,$this->id_cliente,$this->id_vendedor,$this->valor_compra);
            if($stmt->execute())return true;return false;
        }
        public function update(){
            $sql="UPDATE pedidos SET id_produto=?,id_cliente=?,id_vendedor=? WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("iiiisi",$this->id_produto,$this->id_cliente,$this->id_vendedor,$this->id);
            if($stmt->execute())return true;return false;

        }
        public function selectAll(){
            $sql="SELECT * FROM pedidos";
            $stmt=$this->conn->prepare($sql);
            if($stmt->execute())return $stmt->get_result();return false;
        }
        public function delete(){
            $sql="DELETE FROM pedidos WHERE id=?";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("i",$this->id);
            if($stmt->execute())return true;return false;
        }
        public function getPedidos(){
            $sql="  SELECT pedidos.id AS id, cliente.nome AS nome, pedidos.valor_compra AS valor, pedidos.status AS status, vendedor.nome AS vendedor
                    FROM vendedor INNER JOIN pedidos ON vendedor.id=pedidos.id_vendedor
                    INNER JOIN cliente ON pedidos.id_cliente=cliente.id WHERE vendedor.id=?
                ";
            $stmt=$this->conn->prepare($sql);
            $stmt->bind_param("i",$this->id_vendedor);
            if($stmt->execute())return $stmt->get_result();return false;
        }              
    }

    ?>