<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model{

      protected $table = 'carritos';
      public $timestamps = false;

      protected $fillable = [
            'idcarrito', 'fk_idcliente'
      ];
    
      protected $hidden = [

      ];

      public function cargarDesdeRequest($request) {
            $this->idcarrito = $request->input('id') != "0" ? $request->input('id') : $this->idcarrito;
            $this->fk_idcliente = $request->input('fk_idcliente');
      }

      

      public function guardar() {
                  
                  $sql = "UPDATE carritos SET
                        fk_idcliente = ?
                        WHERE idcarrito = ?";
                  $affected = DB::update($sql, [
                        $this->fk_idcliente,
                        $this->idcarrito]);

      }

      public function eliminar()
      {
            $sql = "DELETE FROM carritos WHERE
            idcarrito=?";
            $affected = DB::delete($sql, [$this->idcarrito]);

      }

      public function insertar()
      {
            $sql = "INSERT INTO carritos (
                  fk_idcliente
                  ) VALUES (?, ?);";
            $result = DB::insert($sql, [
                  $this->fk_idcliente,
            ]);
            return $this->idcarrito = DB::getPdo()->lastInsertId();
      }

      public function obtenerTodos()
      {
            $sql = "SELECT 
                        A.idcarrito,
                        A.fk_idcliente
                  FROM carritos A";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

      public function obtenerPorId($idCarrito)
      {
            $sql = "SELECT 
                        A.idcarrito,
                        A.fk_idcliente
                  FROM carritos A WHERE A.idcarrito = '$idCarrito'";
            $lstRetorno = DB::select($sql);
            if(count($lstRetorno) > 0){
                  $this->idcarrito = $lstRetorno[0]->idcarrito;
                  $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
                  return $this;
            }
            return null;
      }

      public function obtenerPorCliente($idCliente)
      {     
            
            $sql = "SELECT 
                        idcarrito,
                        fk_idcliente
                  FROM carritos WHERE fk_idcliente = $idCliente";
            $lstRetorno = DB::select($sql);
            
            if(count($lstRetorno) > 0){
                  $this->idcarrito = $lstRetorno[0]->idcarrito;
                  $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
                  return $this;
            }
            return null;
      }


}

?>