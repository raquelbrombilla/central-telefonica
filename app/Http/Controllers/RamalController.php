<?php 

namespace App\Http\Controllers;

use App\Models\Ramal;
use App\Models\Empresa;
use Illuminate\Http\Request;

class RamalController extends Controller {

    public function index($id_empresa){
        $empresa = Empresa::where('id_empresa', $id_empresa)->first();

        return view('ramal')->with('empresa', $empresa);
    }

    public function ajaxRamal($id_empresa){
        $ramais = Ramal::where('id_empresa', $id_empresa)->get();
        return $ramais;
    }

    public function show($id){
        if($id != 0){
            $ramal = Ramal::where('id_ramal', $id)->get();
        }
      
        if (isset($ramal)) {
            return json_encode(
                array(
                    "id_ramal" => $ramal[0]->id_ramal,
                    "descricao" => $ramal[0]->descricao,
                    "numero" => $ramal[0]->numero,
                    "ativo" => $ramal[0]->ativo,
                ) 
            );
        } else {
            return json_encode(
                array(
                    "id_ramal" => 0,
                    "descricao" => '',
                    "numero" => '',
                    "ativo" => 0,
                ) 
            );
        }
    }

    public function update(Request $request, $id){

        $ativo = $request->ativo == 'on' ? 1 : 0;

        $update = Ramal::where('id_ramal', $id)->update([
            'descricao' => $request->descricao,
            'ativo' => $ativo
        ]);
        
        $ramal = Ramal::where('id_ramal', $id)->first();

        $retorno = array();
        if($update){
            $retorno['status'] = true;
            $retorno['msg'] = 'Ramal atualizado com sucesso!';
            $retorno['url'] = '/ramal/'.$ramal->id_empresa;
            return $retorno;
        } else {                  
            $retorno['status'] = false;
            $retorno['msg'] = 'Não foi possível atualizar as informações desse ramal.';
            $retorno['url'] = '';
            return $retorno;
        }
    }
}