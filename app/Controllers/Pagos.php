<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
class Pagos extends BaseController
{
    public function pagos(){
        $input = $this->getRequestInput($this->request);

        if(!isset($_POST['fechaEntrada'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($_POST['fechaSalida'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($_POST['idServicio'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($_POST['idUsuario'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($_POST['total'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($_POST['banco'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($_POST['cuenta'])){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        if(!isset($_POST['pin'])){
            return $this->getResponse([
                'message' => 'error'
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
                    'alpha_space' => 'Caracteres no permitidos'
            ],
            'cuenta' => [
                'required' => 'Digite una cuenta',
                'numeric' => 'Solo digite numeros',
                'min_length'=>'No puede ser menor a 8 digitos',
                'max_length'=>'No puede ser mayor a 12 digitos'
            ],
            'pin' => [
                'required' => 'Digite un pin',
                'numeric' => 'Solo digite numeros',
                'min_length'=>'Solo 3 digitos',
                'max_length'=>'Solo 3 digitos'
            ],
        ]);

        if(!$rules->withRequest($this->request)->run()){
            return $this->getResponse($rules->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $pagoModel = model('PagosModel');
        $reservaModel = model('ReservasModel');
        $serviciosModel = model('ServiciosModel');

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

        $idPago = $pagoModel->getInsertID();

        $dataReserva = [
            'idPago' => $idPago,
        ];

        if(!$reservaModel->save($dataReserva)){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }

        $actualizarServicio = [
            'idServicio' => $input['idServicio'], 
            'disponibilidad' => 1,
        ];
        
        if(!$serviciosModel->save($actualizarServicio)){
            return $this->getResponse([
                'message' => 'error'
            ]);
        }
        
        return $this->getResponse([
            'message' => 'Pago realizado con exito',
        ]);
    }
}