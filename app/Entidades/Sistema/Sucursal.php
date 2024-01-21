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
    


}

?>