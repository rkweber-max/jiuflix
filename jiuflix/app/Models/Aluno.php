<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $table = 'aluno';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'type_graduation'];

    public $timestamps = false;
}