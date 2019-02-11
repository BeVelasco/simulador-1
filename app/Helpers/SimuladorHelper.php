<?php namespace App\Helpers;

    use App\Producto;
    use App\Etapa;
    use App\Pronostico;
    use App\Inventario;
    use App\Costeo;
    use App\Mercadotecnia;
    use Auth;
    use Lang;
    use Session;

    class SimuladorHelper
    {
        /**
         * Agrega a la sesión el producto seleccionado 
         *
         * @param [Numeric] $idUsu
         * @param [Numeric] $idProd
         * @return string
         */
        public function setProdSession($idUsu, $idProd)
        {
            /* Verifica que no se hayan enviado datos nulos */
            if ($idUsu == null || $idProd == null)
            {
                return Lang::get('reloader.datosIncompletos'); 
            }
            /* Verifica que el producto pertenezca al usuario*/
            $producto = Producto::where([
                'id'        => $idProd,
                'id_user_r' => $idUsu
                ])->first();
            if ($producto == null)
            {
                return Lang::get('reloader.datosIncorrectos');
            }
            /* Si todo es correcto se agrega el id del producto a la sesión */
            if ($producto->id_user_r == Auth::user()->id)
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

        /* Obtiene el avance del usuario en el simulador. */
        function getAvance($id_user, $id_prod)
        {
            $avance = Etapa::where([
                'id_user'     => $id_user,
                'id_producto' => $id_prod,
                'realizado'   => 1
                ])
                ->orderBy('updated_at','DESC')
                ->first();
            if ($avance==null) return null; else return $avance->seccion;
        }

        /* Elimina las variables de la sesión. */
        function deleteSessionVariables(){
            Session::forget([
                'prodSeleccionado','datosCalculados','PBBDData','PBBD','precioVenta','sumCI','costoUnitario','mesInicio',
                'ventasMensuales','pronostico','segmentacion','NivelSocioEcon','estimacionDemanda','proyeccionVentas',
                'tasaCreVen','regionObjetivo','prodAvance']);
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

        /**
         * Verifica que el usuario sea dueño del producto.
         *
         * @param [Integer] $idProd
         * @param [Integer] $idUser
         * @return boolean
         */
        function isOwner($idProd, $idUser)
        {
            $res = Producto::where([
                'id'        => $idProd,
                'id_user_r' => $idUser
                ])->first();
            if($res == null)
            {
                return Lang::get('messages.prodNoPertence');
            }
            return true;
        }

        function getEtapasTerminadas($id)
        {
            $etapas = [
                0 => 'Aún no ha finalizado ninguna etapa.',
                1 => 'Costeo', 
                2 => 'Segmentación',
                3 => 'Inventario',
                4 => 'Mercadotecnia',
            ];
            for ($i=0;$i<=$id;$i++)
            {
                $terminadas[]=$etapas[$i];
            }
            return $terminadas;
        }

        function getEtapaReport($etapa)
        {
            $idUser = Auth::user()->id;
            $idProd = Session::get('prodAvance');
            $avance = $this->getAvance($idUser,$idProd);
            if ($etapa > $avance)
            {
                return Lang::get('messages.etapaIncompleta');
            }
            switch ($etapa)
            {
                case 1:
                    $vista[0] = 'costeo';
                    $vista[1] = Costeo::where([
                        "id_user" => $idUser,
                        "id_producto" => $idProd,
                    ])->first();
                    return $vista;
                break;
                case 2:
                    $vista[0] = 'segmentacion';
                    return $vista;
                break;
                case 3:
                    $vista[0] = 'inventario';
                    $vista[1] = Inventario::where([
                        "id_producto" => $idProd,
                        "id_user"     => $idUser
                    ])->first();
                    $vista[2] = $this->getCostoUnitario($idProd);
                    return $vista;
                break;
                case 4:
                    $vista[0] = 'mercadotecnia';
                    $vista[1] = Mercadotecnia::where([
                        "id_producto" => $idProd,
                        "id_user"     => $idUser
                    ])->first();
                    return $vista;
                break;
            }
        }
    }