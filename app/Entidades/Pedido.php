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
            $this->cantidad = $request->input('txtCantidad');
            $this->precio = $request->input('txtPrecio');
            $this->descripcion = $request->input('txtDescripcion');
            $this->imagen = $request->input('imgProducto');
            $this->fk_idcategoria = $request->input('lstCategoria');
      }

      public function obtenerTodos()
      {
            $sql = "SELECT
                  idpedido,
                  nombre,
                  cantidad,
                  precio,
                  descripcion,
                  imagen,
                  fk_idcategoria,
                  FROM pedidos ORDER BY nombre";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

      public function obtenerPorId($idPedido)
      {
            $sql = "SELECT
                  idpedido,
                  nombre,
                  cantidad,
                  precio,
                  descripcion,
                  imagen,
                  fk_idcategoria,
                  FROM pedidos WHERE idpedido == $idPedido";
            $lstRetorno = DB::select($sql);
            
            if (count($lstRetorno) > 0) {
                  $this->idpedido = $lstRetorno[0]->idpedido;
                  $this->nombre = $lstRetorno[0]->nombre;
                  $this->cantidad = $lstRetorno[0]->cantidad;
                  $this->precio = $lstRetorno[0]->precio;
                  $this->descripcion = $lstRetorno[0]->descripcion;
                  $this->imagen = $lstRetorno[0]->imagen;
                  $this->fk_idcategoria = $lstRetorno[0]->fk_idcategoria;
                  return $this;
              }
              return null;
      }

      public function guardar() {

            $sql = "UPDATE pedidos SET
                  nombre='?',
                  cantidad='?',
                  precio='?',
                  descripcion='?',
                  imagen='?',
                  fk_idcategoria='?',
                  WHERE idpedido=?";
            $affected = DB::update($sql, [
                  $this->nombre,
                  $this->cantidad,
                  $this->precio,
                  $this->descripcion,
                  $this->imagen,
                  $this->fk_idcategoria,
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
                  cantidad,
                  precio,
                  descripcion,
                  imagen,
                  fk_idcategoria
                  ) VALUES (?, ?, ?, ?, ?, ?, ?);";
            $result = DB::insert($sql, [
                  $this->nombre,
                  $this->cantidad,
                  $this->precio,
                  $this->descripcion,
                  $this->imagen,
                  $this->fk_idcategoria,
            ]);
            return $this->idpedido = DB::getPdo()->lastInsertId();
      }
    


}

?>