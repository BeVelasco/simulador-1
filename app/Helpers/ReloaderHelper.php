<?php
    namespace App\Helpers;

    use App\Producto, App\Etapa, App\Pronostico, App\Costeo, Auth, Lang, Session;

    class ReloaderHelper{
        public function setProdSession($idUsu, $idProd){
            if ($idUsu == null || $idProd == null){ return Lang::get('reloader.datosIncompletos'); }
            $producto = Producto::where(['id' => $idProd, 'id_user_r' => $idUsu]) -> first();
            if ($producto == null) { return Lang::get('reloader.datosIncorrectos'); }
            if ($producto -> id_user_r == Auth::user() -> id){
                $this->deleteSessionVariables();
                Session::put('prodSeleccionado', $producto->id);
                return "true";
            } else { return Lang::get('reloader.datosIncorrectos'); }
        }

        function getAvance($id_user, $id_prod){
            $avance = Etapa::where(['id_user'=>$id_user, 'id_producto'=>$id_prod, 'realizado'=>1])->orderBy('updated_at','DESC')->first();
            if ($avance==null) return null; else return $avance->seccion;
        }

        function deleteSessionVariables(){
            Session::forget([
                'prodSeleccionado','datosCalculados','PBBDData','PBBD','precioVenta','sumCI','costoUnitario','mesInicio',
                'ventasMensuales','pronostico','segmentacion','NivelSocioEcon','estimacionDemanda','proyeccionVentas',
                'tasaCreVen','regionObjetivo']);
            return;
        }

        function getPronostico($idUser, $idProducto){
            $pronostico = Pronostico::where(['id_user' => $idUser, 'id_producto' => $idProducto])->first();
            return $pronostico;
        }
        
        function getCostoUnitario($idProd){
            $costoUnitario = Costeo::where("id_producto", $idProd)->pluck("dataPrecioVenta")->first();
            $e             = json_decode($costoUnitario, true);
            $costoUnitario = substr($e["costoUnitario"],2);
            return $costoUnitario;
        }
    }