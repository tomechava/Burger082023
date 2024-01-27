<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class EstadoPedido extends Model{

      protected $table = 'estados_pedidos';
      public $timestamps = false;

      protected $fillable = [
            'idestadopedido', 'nombre',
      ];
    
      protected $hidden = [

      ];

      public function cargarDesdeRequest($request) {
            $this->idestadopedido = $request->input('id') != "0" ? $request->input('id') : $this->idestadopedido;
            $this->nombre = $request->input('txtNombre');
            
      }

      public function obtenerTodos()
      {
            $sql = "SELECT
                  idestadopedido,
                  nombre
                  FROM estados_pedidos ORDER BY nombre";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

      public function obtenerPorId($idEstadoPedido)
      {
            $sql = "SELECT
                  idestadopedido,
                  nombre
                  FROM estados_pedidos WHERE idestadopedido == $idEstadoPedido";
            $lstRetorno = DB::select($sql);
            
            if (count($lstRetorno) > 0) {
                  $this->idestadopedido = $lstRetorno[0]->idestadopedido;
                  $this->nombre = $lstRetorno[0]->nombre;
                  return $this;
              }
              return null;
      }

      public function guardar() {

            $sql = "UPDATE estados_pedidos SET
                  nombre='?'
                  WHERE idestadopedido=?";
            $affected = DB::update($sql, [
                  $this->nombre,
                  $this->idestadopedido]);

      }

      public function eliminar()
      {
            $sql = "DELETE FROM estados_pedidos WHERE
            idestadopedido=?";
            $affected = DB::delete($sql, [$this->idestadopedido]);
      }

      public function insertar()
      {
            $sql = "INSERT INTO estados_pedidos (
                  nombre
                  ) VALUES (?);";
            $result = DB::insert($sql, [
                  $this->nombre,
            ]);
            return $this->idestadopedido = DB::getPdo()->lastInsertId();
      }
    


}

?>