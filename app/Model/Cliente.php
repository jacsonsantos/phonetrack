<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 13/11/18
 * Time: 15:12
 */

namespace App\Model;


use App\Src\DataBase\Model;

class Cliente extends Model
{
    protected $table = 'cliente';

    protected $primaryKey = 'id';

    protected $fill = [
        'nome_completo',
        'data_nascimento',
        'rua',
        'numero',
        'cep',
        'cidade',
        'estado',
        'telefone_fixo',
        'telefone_celular',
        'step',
        'token',
        'status',
    ];

    public function hasToken($token)
    {
        $fields = $this->fillWithId();

        $sql = "SELECT ".implode(',', $fields)." FROM ".$this->table." WHERE token = :token";

        $prepare = $this->connection()->prepare($sql);
        $prepare->bindValue(':token', $token, \PDO::PARAM_STR);

        $data = self::run($prepare, true);
        $data = $data ? $data : $this->all();

        $this->fill($data);

        return $this;
    }

    public function notFinalized($token)
    {
        $fields = $this->fillWithId();

        $sql = "SELECT ".implode(',', $fields)." FROM ".$this->table." WHERE token = :token AND status is NULL";

        $prepare = $this->connection()->prepare($sql);
        $prepare->bindValue(':token', $token, \PDO::PARAM_STR);

        $data = self::run($prepare, true);
        $data = $data ? $data : $this->all();

        $this->fill($data);

        return $this;
    }
}