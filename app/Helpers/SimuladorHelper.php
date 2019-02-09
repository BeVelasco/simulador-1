<?php namespace App\Helpers;

    use App\Producto;
    use App\Etapa;
    use App\Pronostico;
    use App\Costeo;
    use Auth;
    use Lang;
    use Session;

    /**
     * Class Helper 
     */
    class SimuladorHelper
    {
        public function setProdSession($idUsu, $idProd)
        {
            if ($idUsu == null || $idProd == null)
            {
                return Lang::get('reloader.datosIncompletos');
            }
            $producto = Producto::where(['id' => $idProd, 'id_user_r' => $idUsu]) -> first();
            if ($producto == null)
            {
                return Lang::get('reloader.datosIncorrectos');
             }
            if ($producto -> id_user_r == Auth::user() -> id)
            {
                $this->deleteSessionVariables();
                Session::put('prodSeleccionado', $producto->id);
                return "true";
            } 
            else 
            { 
                return Lang::get('reloader.datosIncorrectos'); 
            }
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
            $costoUnitario = json_decode($costoUnitario, true);
            return $costoUnitario["costoUnitario"];
        }
        
        /**
         * Checks for ingredients existence
         *
         * @param [array] $jExcel
         * @return Response
         */
        function checkIngredients($jExcel)
        {
            if (count($jExcel) <= 0)
            {
                return response()->json([
                    'errors' => [
                        'jExcel'=> Lang::get('messages.jExcelSinDatos'),
                    ],
                ],401);
            }
            return "true";
        }

        /**
         * Checks for not zero ingredient cost
         *
         * @param [array] $jExcel
         * @return Response
         */
        function notZeroIngredient($jExcel)
        {
            foreach ($jExcel as $key=>$ingredient)
            {
                $totIng = substr($ingredient[5],2);
                $totIng = (str_replace(',', '', $totIng))*1;
                if ($totIng <= 0)
                {
                    return response()->json([
                        'errors' => [
                            'jExcel' => str_replace('%num%',$key+1, Lang::Get('validacion.jExcelConCeros')),
                        ]
                    ],401);
                }
            }
            return "true";
        }

        /**
         * Gets CI
         *
         * @param [array] $jExcel
         * @return Response
         */
        public function getCI($jExcel)
        {
            $sumCI = 0;
            $largo  = count($jExcel);
            for ($i=0;$i<$largo;$i++){
                $costoIng  = substr($jExcel[$i][5],2);
                $costoIng  = str_replace(',', '', $costoIng );
                $sumCI    += $costoIng;
            }
            return $sumCI;
        }
    }