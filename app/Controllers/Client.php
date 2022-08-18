<?php

namespace App\Controllers;

use Exception;
use App\Models\ClientModel;
use App\Models\UserModel;
use App\Models\PaisesModel;
use App\Models\DepartamentoModel;
use App\Models\MunicipioModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Client extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        return $this->getResponse([
            'message' => 'Clients retrieved successfully',
            'clients' => $model->findAll()
        ]);
    }

    public function paises()
    {
        $model = new PaisesModel();
        return $this->getResponse([
            'paises' => $model->findAll()
        ]);
    }

    public function departamentos($id)
    {
        $model = new DepartamentoModel();
        $model->departamento($id);
        return $this->getResponse([
            'departamentos' => $model->findAll()
        ]);
    }

    public function municipios($id)
    {
        $model = new MunicipioModel();
        $model->municipio($id);
        return $this->getResponse([
            'municipios' => $model->findAll()
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[client.email]',
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules)) {
            return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $clientEmail = $input['email'];

        $model = new UserModel();
        $model->save($input);


        $client = $model->where('email', $clientEmail)->first();
        //unset($client['password']);

        return $this->getResponse([
            'message' => 'Client added successfully',
            'client' => $client
        ]);
    }

    public function show($id)
    {
        try {

            $model = new UserModel();
            $client = $model->findClientById($id);
            unset($client['password']);
            
            return $this->getResponse([
                'message' => 'Client retrieved successfully',
                'client' => $client
            ]);

        } catch (Exception $e) {
            return $this->getResponse([
                'message' => 'Could not find client for specified ID'
            ], ResponseInterface::HTTP_NOT_FOUND);
        }
    }

    public function update($id)
    {
        try {

            $model = new UserModel();
            $model->findClientById($id);

            $input = $this->getRequestInput($this->request);


            $model->update($id, $input);
            $client = $model->findClientById($id);

            return $this->getResponse([
                'message' => 'Client updated successfully',
                'client' => $client
            ]);

        } catch (Exception $exception) {

            return $this->getResponse([
                'message' => $exception->getMessage()
            ], ResponseInterface::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        try {

            $model = new UserModel();
            $client = $model->findClientById($id);
            $model->delete($client);

            return $this->getResponse([
                'message' => 'Client deleted successfully',
            ]);

        } catch (Exception $exception) {
            return $this->getResponse([
                'message' => $exception->getMessage()
            ], ResponseInterface::HTTP_NOT_FOUND);
        }
    }
}