<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model{

      protected $table = 'sucursales';
      public $timestamps = false;

      protected $fillable = [
            'idsucursal', 'nombre', 'direccion', 'telefono', 'mapa', 'fk_idestadosucursal',
      ];
    
      protected $hidden = [

      ];

      public function cargarDesdeRequest($request) {
            $this->idsucursal = $request->input('id') != "0" ? $request->input('id') : $this->idsucursal;
            $this->nombre = $request->input('txtNombre');
            $this->direccion = $request->input('txtDireccion');
            $this->telefono = $request->input('txtTelefono');
            $this->mapa = $request->input('txtMapa');
            $this->fk_idestadosucursal = $request->input('lstEstadoSucursal');
      }

      public function obtenerTodos()
      {
            $sql = "SELECT
                  idsucursal,
                  nombre,
                  direccion,
                  telefono,
                  mapa,
                  fk_idestadosucursal
                  FROM sucursales ORDER BY nombre";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

      public function obtenerPorId($idSucursal)
      {
            $sql = "SELECT
                  idsucursal,
                  nombre,
                  direccion,
                  telefono,
                  mapa,
                  fk_idestadosucursal
                  FROM sucursales WHERE idsucursal == $idSucursal";
            $lstRetorno = DB::select($sql);
            
            if (count($lstRetorno) > 0) {
                  $this->idsucursal = $lstRetorno[0]->idsucursal;
                  $this->nombre = $lstRetorno[0]->nombre;
                  $this->direccion = $lstRetorno[0]->direccion;
                  $this->telefono = $lstRetorno[0]->telefono;
                  $this->mapa = $lstRetorno[0]->mapa;
                  $this->fk_idestadosucursal = $lstRetorno[0]->fk_idestadosucursal;
                  return $this;
              }
              return null;
      }

      public function guardar() {

            $sql = "UPDATE sucursales SET
                  nombre='?',
                  direccion='?',
                  telefono='?',
                  mapa='?',
                  fk_idestadosucursal='?'
                  WHERE idsucursal=?";
            $affected = DB::update($sql, [
                  $this->nombre,
                  $this->direccion,
                  $this->telefono,
                  $this->mapa,
                  $this->fk_idestadosucursal,
                  $this->idsucursal]);
      }

      public function eliminar()
      {
            $sql = "DELETE FROM sucursales WHERE
            idsucursal=?";
            $affected = DB::delete($sql, [$this->idsucursal]);
      }

      public function insertar()
      {
            $sql = "INSERT INTO sucursales (
                  nombre,
                  direccion,
                  telefono,
                  mapa,
                  fk_idestadosucursal
                  ) VALUES (?, ?, ?, ?, ?);";
            $result = DB::insert($sql, [
                  $this->nombre,
                  $this->direccion,
                  $this->telefono,
                  $this->mapa,
                  $this->fk_idestadosucursal,
            ]);
            return $this->idsucursal = DB::getPdo()->lastInsertId();
      }

      public function obtenerFiltrado()
      {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idsucursal',
            1 => 'A.nombre',
            2 => 'A.direccion',
            3 => 'A.telefono',
            4 => 'A.mapa',
            5 => 'nombreEstado',
            );
        $sql = "SELECT DISTINCT
                  'A.idsucursal',
                  'A.nombre',
                  'A.direccion',
                  'A.telefono',
                  'A.mapa',
                  'B.nombre' as nombreEstado
                  FROM sucursales A
                  LEFT JOIN estados_sucursales B ON A.fk_idestadosucursal = B.idestadosucursal
                  WHERE 1=1
                  ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.idsucursal LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.direccion LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR A.telefono LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR A.mapa LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR nombreEstado LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
    


}

?>