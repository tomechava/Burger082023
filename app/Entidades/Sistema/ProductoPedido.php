<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class ProductoPedido extends Model{

      protected $table = 'clientes';
      public $timestamps = false;

      protected $fillable = [
            'idproductopedido', 'fk_idproducto', 'fk_idpedido', 'precio_unitario', 'cantidad', 'total',
      ];
    
      protected $hidden = [

      ];

      public function cargarDesdeRequest($request) {
            $this->idproductopedido = $request->input('id') != "0" ? $request->input('id') : $this->idproductopedido;
            $this->fk_idproducto = $request->input('txtIdProducto');
            $this->fk_idpedido = $request->input('txtIdPedido');
            $this->precio_unitario = $request->input('txtPrecioUnitario');
            $this->cantidad = $request->input('txtCantidad');
            $this->total = $request->input('txtTotal');
            $this->clave = $request->input('txtClave')!= ""? password_hash($request->input('txtClave'), PASSWORD_DEFAULT): "";
      }

      

      public function guardar() {

            $sql = "UPDATE productos_pedidos SET
                  fk_idproducto = ?,
                  fk_idpedido = ?,
                  precio_unitario = ?,
                  cantidad = ?,
                  total = ?
                  WHERE idproductopedido = ?";
            $affected = DB::update($sql, [
                  $this->fk_idproducto,
                  $this->fk_idpedido,
                  $this->precio_unitario,
                  $this->cantidad,
                  $this->total,
                  $this->idproductopedido]);

      }

      public function eliminar()
      {
            $sql = "DELETE FROM productos_pedidos WHERE
            idproductopedido=?";
            $affected = DB::delete($sql, [$this->idproductopedido]);
      }

      public function insertar()
      {
            $sql = "INSERT INTO productos_pedidos (
                  fk_idproducto,
                  fk_idpedido,
                  precio_unitario,
                  cantidad,
                  total
                  ) VALUES (?, ?, ?, ?, ?);";
            $result = DB::insert($sql, [
                  $this->fk_idproducto,
                  $this->fk_idpedido,
                  $this->precio_unitario,
                  $this->cantidad,
                  $this->total,
            ]);
            return $this->idproductopedido = DB::getPdo()->lastInsertId();
      }

      public function obtenerTodos()
      {
            $sql = "SELECT
                  idproductopedido,
                  fk_idproducto,
                  fk_idpedido,
                  precio_unitario,
                  cantidad,
                  total
                  FROM productos_pedidos ORDER BY idproductopedido";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

      public function obtenerPorId($idProductoPedido)
      {
            $sql = "SELECT
                  idproductopedido,
                  fk_idproducto,
                  fk_idpedido,
                  precio_unitario,
                  cantidad,
                  total
                  FROM productos_pedidos WHERE idproductopedido = $idProductoPedido";
            $lstRetorno = DB::select($sql);
            
            if (count($lstRetorno) > 0) {
                  $this->idproductopedido = $lstRetorno[0]->idproductopedido;
                  $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
                  $this->fk_idpedido = $lstRetorno[0]->fk_idpedido;
                  $this->precio_unitario = $lstRetorno[0]->precio_unitario;
                  $this->cantidad = $lstRetorno[0]->cantidad;
                  $this->total = $lstRetorno[0]->total;
                  return $this;
              }
              return null;
      }

      public function obtenerPorPedido($idPedido)
      {
            $sql = "SELECT
                  A.idproductopedido,
                  A.fk_idproducto,
                  A.fk_idpedido,
                  A.precio_unitario,
                  A.cantidad,
                  A.total,
                  B.idproducto,
                  B.nombre,
                  B.descripcion,
                  B.precio,
                  B.imagen,
                  B.fk_idcategoria
                  FROM productos_pedidos A 
                  INNER JOIN productos B ON A.fk_idproducto = B.idproducto
                  WHERE fk_idpedido = $idPedido";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

}

?>