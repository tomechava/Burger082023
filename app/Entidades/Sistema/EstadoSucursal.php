<?php

namespace App\Entidades\Sistema;

use DB;
use Illuminate\Database\Eloquent\Model;

class EstadoSucursal extends Model{

      protected $table = 'estados_sucursales';
      public $timestamps = false;

      protected $fillable = [
            'idestadosucursal', 'nombre',
      ];
    
      protected $hidden = [

      ];

      public function cargarDesdeRequest($request) {
            $this->idestadosucursal = $request->input('id') != "0" ? $request->input('id') : $this->idestadosucursal;
            $this->nombre = $request->input('txtNombre');
            
      }

      public function obtenerTodos()
      {
            $sql = "SELECT
                  idestadosucursal,
                  nombre
                  FROM estados_sucursales ORDER BY nombre";
            $lstRetorno = DB::select($sql);
            return $lstRetorno;
      }

      public function obtenerPorId($idEstadoSucursal)
      {
            $sql = "SELECT
                  idestadosucursal,
                  nombre
                  FROM estados_sucursales WHERE idestadosucursal == $idEstadoSucursal";
            $lstRetorno = DB::select($sql);
            
            if (count($lstRetorno) > 0) {
                  $this->idestadosucursal = $lstRetorno[0]->idestadosucursal;
                  $this->nombre = $lstRetorno[0]->nombre;
                  return $this;
              }
              return null;
      }

      public function guardar() {

            $sql = "UPDATE estados_sucursales SET
                  nombre='?'
                  WHERE idestadosucursal=?";
            $affected = DB::update($sql, [
                  $this->nombre,
                  $this->idestadosucursal]);

      }

      public function eliminar()
      {
            $sql = "DELETE FROM estados_sucursales WHERE
            idestadosucursal=?";
            $affected = DB::delete($sql, [$this->idestadosucursal]);
      }

      public function insertar()
      {
            $sql = "INSERT INTO estados_sucursales (
                  nombre
                  ) VALUES (?);";
            $result = DB::insert($sql, [
                  $this->nombre,
            ]);
            return $this->idestadosucursal = DB::getPdo()->lastInsertId();
      }
    


}

?>