<?php 

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Ramal;
use Illuminate\Http\Request;

class EmpresaController extends Controller {

    protected $view;

    public function __construct(){
        $this->view = 'empresa';
    }

    public function index(){
        return view($this->view);
    }

    public function ajaxEmpresas(){
        $empresas = Empresa::all();
        return $empresas;
    }

    public function show($id){
        if($id != 0){
            $empresa = Empresa::where('id_empresa', $id)->get();
        }
      
        if (isset($empresa)) {
            return json_encode(
                array(
                    "id_empresa" => $empresa[0]->id_empresa,
                    "nome" => $empresa[0]->nome,
                    "cnpj" => $empresa[0]->CNPJ,
                    "ddd" => $empresa[0]->DDD,
                    "num_municipal" => $empresa[0]->num_municipal,
                    "num_externo" => $empresa[0]->num_externo,
                    "ramal_inicial" => $empresa[0]->ramal_inicial,
                    "ramal_final" => $empresa[0]->ramal_final,
                ) 
            );
        } else {
            return json_encode(
                array(
                    "id_empresa" => 0,
                    "nome" => '',
                    "cnpj" => '',
                    "ddd" => '',
                    "num_municipal" => '',
                    "num_externo" => '',
                    "ramal_inicial" => '',
                    "ramal_final" => '',
                ) 
            );
        }
    }

    public function store(Request $request){
        $retorno = array();

        $search = Empresa::where('CNPJ', $request->cnpj)->get();

        if(count($search) > 0){
            $retorno['status'] = false;
            $retorno['msg'] = 'Esse CNPJ já está cadastrado.';
            $retorno['url'] = '';
            return $retorno;
        }

        if( ($request->ramal_inicial > $request->ramal_final) 
            || 
            ($request->ramal_inicial == $request->ramal_final) ){

            $retorno['status'] = false;
            $retorno['msg'] = 'O ramal inicial deve ser menor que o ramal final e eles não podem ser iguais.';
            $retorno['url'] = '';
            return $retorno;
        }

        $insert = Empresa::create([
            'nome' => $request->empresa,
            'CNPJ' => $request->cnpj,
            'DDD' => $request->ddd,
            'num_municipal' => $request->num_municipal,
            'num_externo' => $request->num_externo,
            'ramal_inicial' => $request->ramal_inicial,
            'ramal_final' => $request->ramal_final
        ]);

        $id = $insert->id;

        $array = array();
        for($i = $request->ramal_inicial; $i <= $request->ramal_final; $i++){
            $ramal = Ramal::create([
                'descricao' => 'Ramal '.$i,
                'numero' => $i,
                'id_empresa' => $id,
                'ativo' => 0
            ]);
        }   

        if ($insert) {
            $retorno['status'] = true;
            $retorno['msg'] = 'Empresa cadastrada com sucesso!';
            $retorno['url'] = '/empresas';
            return $retorno;
        } else {                  
            $retorno['status'] = false;
            $retorno['msg'] = 'Não foi possível cadastrar essa empresa.';
            $retorno['url'] = '';
            return $retorno;
        }
    }

    public function update(Request $request, $id){

        $retorno = array();
        $search = Empresa::where('CNPJ', $request->cnpj)
            ->where('id_empresa', '!=', $request->id_empresa)->get();

        if(count($search) > 0){
            $retorno['status'] = false;
            $retorno['msg'] = 'Esse CNPJ já está cadastrado.';
            $retorno['url'] = '';
            return $retorno;
        }
        
        $update = Empresa::where('id_empresa', $id)->update([
            'nome' => $request->empresa,
            'CNPJ' => $request->cnpj,
            'DDD' => $request->ddd,
            'num_municipal' => $request->num_municipal,
            'num_externo' => $request->num_externo,
        ]);

        if($update){
            $retorno['status'] = true;
            $retorno['msg'] = 'Empresa atualizada com sucesso!';
            $retorno['url'] = '/empresas';
            return $retorno;
        } else {                  
            $retorno['status'] = false;
            $retorno['msg'] = 'Não foi possível atualizar as informações dessa empresa.';
            $retorno['url'] = '';
            return $retorno;
        }
    }

    public function delete($id){
        $deleteRamais = Ramal::where('id_empresa', $id)->delete();

        $ramais = Ramal::where('id_empresa', $id)->get();
        
        $retorno = array();
        if(count($ramais) == 0){
            $delete = Empresa::where('id_empresa', $id)->delete();

            if($delete){
                $retorno['status'] = true;
                $retorno['msg'] = 'Empresa e ramais excluídos!';
                $retorno['url'] = '/empresas';
                return $retorno;
            } else {
                $retorno['status'] = false;
                $retorno['msg'] = 'Erro ao excluir empresa!';
                $retorno['url'] = '/empresas';
                return $retorno;
            }

        } else {
            $retorno['status'] = false;
            $retorno['msg'] = 'Erro ao excluir empresa!';
            $retorno['url'] = '/empresas';
            return $retorno;
        }

    }
}