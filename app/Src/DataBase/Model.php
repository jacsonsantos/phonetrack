<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 14/11/18
 * Time: 22:27
 */

namespace App\Src\DataBase;

class Model extends Repository
{
    protected $table = '';

    protected $primaryKey = '';

    protected $fill = [];

    public function __construct($pdo = null)
    {
        parent::__construct($pdo);
        $this->fill = array_fill_keys($this->fill, null);
    }

    public function __get($name)
    {
        return $this->fill[$name];
    }

    public function __set($name, $value)
    {
        $this->fill[$name] = $value;
    }

    public function fill(array $fill)
    {
        foreach ($fill as $key => $value) {

            if ($key == $this->primaryKey && !is_null($value)) {
                $this->fill[$key] = $value;
            }

            if (array_key_exists($key,$this->fill)) {
                $this->fill[$key] = $value;
            }
        }
        return $this;
    }

    public function all()
    {
        return $this->fill;
    }

    public function find($id)
    {
        return $this->get($id);
    }

    public function save()
    {
        if (isset($this->fill[$this->primaryKey])) {
            return $this->update($this->all(), $this->fill[$this->primaryKey]);
        }

        return $this->create($this->all());
    }

    protected function fillWithId()
    {
        $fills = $this->fill;
        $fills[$this->primaryKey] = null;

        return array_keys($fills);
    }
}