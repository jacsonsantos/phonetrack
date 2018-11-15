<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 12/11/18
 * Time: 21:59
 */

namespace App\Controller;

use App\Model\Cliente;
use App\Src\Http\HttpRequest\Request;

class IndexController
{
    public function index(Request $request, Cliente $cliente)
    {
        $cliente->notFinalized(_token());

        return view('index', compact('cliente'));
    }

    public function store(Request $request, Cliente $cliente)
    {
        $data = $request->all();

        if (isset($data['data_nascimento'])) {
            $data['data_nascimento'] = dateFormat('Y-m-d', $data['data_nascimento'],'d/m/Y');
        }

        $cliente->notFinalized($data['token']);
        $cliente->fill($data);
        $cliente->save();

        return responseJson($cliente->all());
    }

    public function done(Request $request,Cliente $cliente)
    {
        $cliente->notFinalized($request->get('token'));
        $cliente->status = 1;
        $cliente->save();

        return responseJson($cliente->all());
    }
}