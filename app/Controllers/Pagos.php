<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
class Pagos extends BaseController
{
    public function pagos(){
        $input = $this->getRequestInput($this->request);

        if(!isset($input['fechaEntrada'])){
            return $this->getResponse([
                'errors' => [
                    'message' => 'error no existe fechaEntrada'
                ]
            ]);
        }
        if(!isset($input['fechaSalida'])){
            return $this->getResponse([
                'errors' => [
                    'message' => 'error no existe fechaSalida'
                ]
            ]);
        }
        if(!isset($input['idServicio'])){
            return $this->getResponse([
                'errors' => [
                    'message' => 'error no existe servicio'
                ]
            ]);
        }
        if(!isset($input['idUsuario'])){
            return $this->getResponse([
                'errors' => [
                    'message' => 'error no existe usuario'
                ]
            ]);
        }
        if(!isset($input['total'])){
            return $this->getResponse([
                'errors' => [
                    'message' => 'error no existe total'
                ]
            ]);
        }
        if(!isset($input['banco'])){
            return $this->getResponse([
                'errors' => [
                    'message' => 'error no existe banco'
                ]
            ]);
        }
        if(!isset($input['cuenta'])){
            return $this->getResponse([
                'errors' => [
                    'message' => 'error no existe cuenta'
                ]
            ]);
        }
        if(!isset($input['pin'])){
            return $this->getResponse([
                'errors' => [
                    'message' => 'error no existe pin'
                ]
            ]);
        }


        $rules = service('validation');
        $rules->setRules([
            'banco'=>'required|alpha_space',
            'cuenta'=>'required|numeric|min_length[8]|max_length[12]',
            'pin'=>'required|numeric|min_length[3]|max_length[3]',
        ],[
            'banco' => [
                    'required' => 'Digite un banco',
                    'alpha_space' => 'Banco caracteres no permitidos'
            ],
            'cuenta' => [
                'required' => 'Digite una cuenta',
                'numeric' => 'En cuenta solo digite numeros',
                'min_length'=>'Cuenta no puede ser menor a 8 digitos',
                'max_length'=>'Cuenta no puede ser mayor a 12 digitos'
            ],
            'pin' => [
                'required' => 'Digite un pin',
                'numeric' => 'Pin solo digite numeros',
                'min_length'=>'Pin solo puede contener 3 digitos',
                'max_length'=>'Pin solo puede contener 3 digitos'
            ],
        ]);

        if(!$rules->withRequest($this->request)->run()){
            return $this->getResponse([
                'errors' => $rules->getErrors()
            ]);
        }

        $pagoModel = model('PagosModel');
        $reservaModel = model('ReservasModel');
        $serviciosModel = model('ServiciosModel');
        $fechaReservaModel = model('FechasReservasModel');

        $dataPago = [
            'fechaEntrada' => $input['fechaEntrada'],
            'fechaSalida' => $input['fechaSalida'],
            'total' => $input['total'],
            'idServicio' => $input['idServicio'],
            'idUsuario' => $input['idUsuario'],
        ];

        if(!$pagoModel->save($dataPago)){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }

        $dataFechaReserva = [
            'fechaEntrada' => $input['fechaEntrada'],
            'fechaSalida' => $input['fechaSalida'],
            'idServicio' => $input['idServicio'],
        ];

        if(!$fechaReservaModel->save($dataFechaReserva)){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }

        $idPago = $pagoModel->getInsertID();

        $dataReserva = [
            'idPago' => $idPago,
        ];

        if(!$reservaModel->save($dataReserva)){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }

        /*$actualizarServicio = [
            'idServicio' => $input['idServicio'], 
            'disponibilidad' => 1,
        ];
        
        if(!$serviciosModel->save($actualizarServicio)){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }*/
        
        return $this->getResponse([
            'message' => 'Pago realizado con exito',
        ]);
    }

    public function confirmarPago(){
        $input = $this->getRequestInput($this->request);
        
        if(!isset($input['fechaEntrada'])){
            return $this->getResponse([
                'errors' => [
                    'message' => 'error no existe fechaEntrada'
                ]
            ]);
        }
        if(!isset($input['fechaSalida'])){
            return $this->getResponse([
                'errors' => [
                    'message' => 'error no existe fechaSalida'
                ]
            ]);
        }
        if(!isset($input['idServicio'])){
            return $this->getResponse([
                'errors' => [
                    'message' => 'error no existe servicio'
                ]
            ]);
        }

        $fechaReservaModel = model('FechasReservasModel');

        $fechaEntrada = $input['fechaEntrada'].' 00:00:00';
        $fechaSalida = $input['fechaSalida'].' 00:00:00';

        $diasReserva = $fechaReservaModel->where('idServicio',$input['idServicio'])->where('fechaSalida >=', $fechaEntrada)->where('fechaEntrada <=', $fechaSalida)->findColumn('idFecha');

        if($diasReserva != null){
            return $this->getResponse([
                'message' => 'Ya esta reservado',
                'dias' => $diasReserva,
            ]);
        }

        return $this->getResponse([
            'message' => 'Esta libre',
            'dias' => $diasReserva,
        ]);

        
    }
}