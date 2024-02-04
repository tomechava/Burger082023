<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class ProductoCarrito extends Model{

      protected $table = 'productos_carritos';
      public $timestamps = false;

      protected $fillable = [
            'idproductocarrito', 'fk_idcarrito', 'fk_idproducto',  'cantidad',
      ];
    
      protected $hidden = [

      ];

      public function cargarDesdeRequest($request) {
            $this->idproductocarrito = $request->input('id') != "0" ? $request->input('id') : $this->idproductocarrito;
            $this->fk_idcarrito = $request->input('fk_idcarrito');
            $this->fk_idproducto = $request->input('fk_idproducto');
            $this->cantidad = $request->input('cantidad');
      }

      

      public function guardar() {
                        
                        $sql = "UPDATE productos_carritos SET
                              fk_idcarrito = ?,
                              fk_idproducto = ?,
                              cantidad = ?
                              WHERE idproductocarrito = ?";
                        $affected = DB::update($sql, [
                              $this->fk_idcarrito,
                              $this->fk_idproducto,
                              $this->cantidad,
                              $this->idproductocarrito]);
            }
            

      public function eliminar()
      {
            $sql = "DELETE FROM productos_carritos WHERE
            idproductocarrito=?";
            $affected = DB::delete($sql, [$this->idproductocarrito]);
      }

      public function insertar()
      {
            $sql = "INSERT INTO productos_carritos (
                  fk_idcarrito,
                  fk_idproducto,
                  cantidad
                  ) VALUES (?, ?, ?);";
            $result = DB::insert($sql, [
                  $this->fk_idcarrito,
                  $this->fk_idproducto,
                  $this->cantidad
            ]);
            return $this->idproductocarrito = DB::getPdo()->lastInsertId();
      }

      public function obtenerTodos()
      {
            $sql = "SELECT 
                        A.idproductocarrito,
                        A.fk_idcarrito,
                        A.fk_idproducto,
                        A.cantidad
                        FROM productos_carritos A";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

      public function obtenerPorId($idProductoCarrito)
      {
            $sql = "SELECT 
                        A.idproductocarrito,
                        A.fk_idcarrito,
                        A.fk_idproducto,
                        A.cantidad
                        FROM productos_carritos A WHERE A.idproductocarrito = '$idProductoCarrito'";
            if(count($lstRetorno) > 0){
                  $this->idproductocarrito = $lstRetorno[0]->idproductocarrito;
                  $this->fk_idcarrito = $lstRetorno[0]->fk_idcarrito;
                  $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
                  $this->cantidad = $lstRetorno[0]->cantidad;
                  return $this;
            }
            return null;

      }

      public function obtenerPorCarrito($idCarrito)
      {
            $sql = "SELECT 
                        A.idproductocarrito,
                        A.fk_idcarrito,
                        A.fk_idproducto,
                        A.cantidad,
                        B.idproducto,
                        B.nombre,
                        B.descripcion,
                        B.precio,
                        B.imagen
                  FROM productos_carritos A
                  INNER JOIN productos B ON A.fk_idproducto = B.idproducto
                  WHERE A.fk_idcarrito = '$idCarrito'";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

}

?>