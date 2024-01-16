<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model{

      protected $table = 'pedidos';
      public $timestamps = false;

      protected $fillable = [
            'idpedido', 'fecha', 'total', 'fk_idcliente', 'fk_idsucursal', 'fk_idestadopedido', 'metodo_pago',
      ];
    
      protected $hidden = [

      ];

      public function cargarDesdeRequest($request) {
            $this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
            $this->fecha = $request->input('txtFecha');
            $this->total = $request->input('txtTotal');
            $this->fk_idcliente = $request->input('lstCliente');
            $this->fk_idsucursal = $request->input('lstSucursal');
            $this->fk_idestadopedido = $request->input('lstEstadoPedido');
            $this->metodo_pago = $request->input('lstMetodoPago');
      }

      public function obtenerTodos()
      {
            $sql = "SELECT
                  idpedido,
                  fecha,
                  total,
                  fk_idcliente,
                  fk_idsucursal,
                  fk_idestadopedido,
                  metodo_pago
                  FROM pedidos ORDER BY fecha";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

      public function obtenerPorId($idPedido)
      {
            $sql = "SELECT
                  idpedido,
                  fecha,
                  total,
                  fk_idcliente,
                  fk_idsucursal,
                  fk_idestadopedido,
                  metodo_pago
                  FROM pedidos WHERE idpedido == $idPedido";
            $lstRetorno = DB::select($sql);
            
            if (count($lstRetorno) > 0) {
                  $this->idpedido = $lstRetorno[0]->idpedido;
                  $this->fecha = $lstRetorno[0]->fecha;
                  $this->total = $lstRetorno[0]->total;
                  $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
                  $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
                  $this->fk_idestadopedido = $lstRetorno[0]->fk_idestadopedido;
                  $this->metodo_pago = $lstRetorno[0]->metodo_pago;
                  return $this;
              }
              return null;
      }

      public function guardar() {

            $sql = "UPDATE pedidos SET
                  nombre='?',
                  fecha='?',
                  total='?',
                  fk_idcliente='?',
                  fk_idsucursal='?',
                  fk_idestadopedido='?',
                  metodo_pago='?'
                  WHERE idpedido=?";
            $affected = DB::update($sql, [
                  $this->nombre,
                  $this->fecha,
                  $this->total,
                  $this->fk_idcliente,
                  $this->fk_idsucursal,
                  $this->fk_idestadopedido,
                  $this->metodo_pago,
                  $this->idpedido]);

      }

      public function eliminar()
      {
            $sql = "DELETE FROM pedidos WHERE 
                  idpedido=?";
            $affected = DB::delete($sql, [$this->idpedido]);
      }

      public function insertar()
      {
            $sql = "INSERT INTO pedidos (
                  nombre,
                  fecha,
                  total,
                  fk_idcliente,
                  fk_idsucursal,
                  fk_idestadopedido,
                  metodo_pago
                  ) VALUES (?, ?, ?, ?, ?, ?, ?);";
            $result = DB::insert($sql, [
                  $this->nombre,
                  $this->fecha,
                  $this->total,
                  $this->fk_idcliente,
                  $this->fk_idsucursal,
                  $this->fk_idestadopedido,
                  $this->metodo_pago,
            ]);
            return $this->idpedido = DB::getPdo()->lastInsertId();
      }
    


}

?>