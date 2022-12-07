<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model {

    use HasFactory;
  
    protected $table = 'empresa';

    protected $fillable = [
        'id_empresa',
        'nome',
        'CNPJ',
        'DDD',
        'num_municipal',
        'num_externo',
        'ramal_inicial',
        'ramal_final',
        'created_at',
        'updated_at'
    ];

}