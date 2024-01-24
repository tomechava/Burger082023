<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Entidades\Sistema\Categoria;

class Producto extends Model{

      protected $table = 'productos';
      public $timestamps = false;

      protected $fillable = [
            'idproducto', 'nombre', 'cantidad', 'precio', 'descripcion', 'imagen', 'fk_idcategoria',
      ];
    
      protected $hidden = [

      ];

      public function cargarDesdeRequest($request) {
            $this->idproducto = $request->input('id') != "0" ? $request->input('id') : $this->idproducto;
            $this->nombre = $request->input('txtNombre');
            $this->cantidad = $request->input('txtCantidad');
            $this->precio = $request->input('txtPrecio');
            $this->descripcion = $request->input('txtDescripcion');
            $this->imagen = $request->input('imgProducto');
            $this->fk_idcategoria = $request->input('lstCategoria');
      }

      public function obtenerTodos()
      {
            $sql = "SELECT
                  idproducto,
                  nombre,
                  cantidad,
                  precio,
                  descripcion,
                  imagen,
                  fk_idcategoria
                  FROM productos ORDER BY nombre";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

      public function obtenerPorId($idProducto)
      {
            $sql = "SELECT
                  idproducto,
                  nombre,
                  cantidad,
                  precio,
                  descripcion,
                  imagen,
                  fk_idcategoria
                  FROM productos WHERE idproducto = $idProducto";
            $lstRetorno = DB::select($sql);
            
            if (count($lstRetorno) > 0) {
                  $this->idproducto = $lstRetorno[0]->idproducto;
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

            $sql = "UPDATE productos SET
                  nombre = ?,
                  cantidad = ?,
                  precio = ?,
                  descripcion = ?,
                  imagen = ?,
                  fk_idcategoria = ?
                  WHERE idproducto = ?";
            $affected = DB::update($sql, [
                  $this->nombre,
                  $this->cantidad,
                  $this->precio,
                  $this->descripcion,
                  $this->imagen,
                  $this->fk_idcategoria,
                  $this->idproducto]);

      }

      public function eliminar()
      {
            $sql = "DELETE FROM productos WHERE
            idproducto=?";
            $affected = DB::delete($sql, [$this->idproducto]);
      }

      public function insertar()
      {
            $sql = "INSERT INTO productos (
                  nombre,
                  cantidad,
                  precio,
                  descripcion,
                  imagen,
                  fk_idcategoria
                  ) VALUES (?, ?, ?, ?, ?, ?);";
            $result = DB::insert($sql, [
                  $this->nombre,
                  $this->cantidad,
                  $this->precio,
                  $this->descripcion,
                  $this->imagen,
                  $this->fk_idcategoria,
            ]);

            return $this->idproducto = DB::getPdo()->lastInsertId();
      }
      
      public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idproducto',
            1 => 'A.nombre',
            2 => 'B.nombre',
            3 => 'A.precio',
            4 => 'A.imagen',
            );
        $sql = "SELECT DISTINCT
                  A.idproducto,
                  A.nombre,
                  B.nombre as nombreCategoria,
                  A.precio,
                  A.imagen
                  FROM productos A
                  INNER JOIN categorias B ON A.fk_idcategoria = B.idcategoria
                  WHERE 1=1
                  ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR B.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.precio LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }


}

?>