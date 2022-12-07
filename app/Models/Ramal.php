<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ramal extends Model {

    use HasFactory;
  
    protected $table = 'ramal';

    protected $fillable = [
        'id_ramal',
        'descricao',
        'numero',
        'ativo',
        'id_empresa',
        'created_at',
        'updated_at'
    ];

}