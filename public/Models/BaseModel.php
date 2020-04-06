<?php

namespace App\Models;

use App\Base;
use App\Helpers\Env;
use App\Helpers\Registry;
use Pixie\QueryBuilder\QueryBuilderHandler;

class BaseModel extends Base {

    public $env;
    public $db;

    public function __construct()
    {
        $this->env = new Env();

        if (is_null($this->db)) {
            $config = array(
                'driver'   => 'mysql', // Db driver
                'host'     => $this->env->get('db.host'),
                'database' => $this->env->get('db.name'),
                'username' => $this->env->get('db.user'),
                'password' => $this->env->get('db.pass'),
            );

            if (!class_exists('QB')) {
                try {
                    new \Pixie\Connection('mysql', $config, 'QB');
                } catch (\Exception $e) {
                    // do something with the exception
                }
            }

            try {
                $this->db = new QueryBuilderHandler();
            } catch (\Exception $e) {
                print_r($e);die();
            }

        }
    }

    public function asObjects(array $results, $type, $orderBy = 'getId')
    {
        $resultData = [];

        foreach ($results as $result) {
            $object = $this->asObject($result, $type);

            $resultData[] = $object;
        }

        return $resultData;
    }


    public function asObject($result, $type)
    {
        $result = (array) $result;

        $primaryKey = '';

        $cleanType = trim($type, '\\');

        $tableMappings = [
            'App\Entity\Page'     => 'u_',
            'App\Entity\UserRole' => 'ur_',
            'App\Entity\Role'     => 'r_',
        ];
        if (!empty(Registry::$tableMappings[$cleanType])) {

            $primaryKey = Registry::$tableMappings[$cleanType].'id';

            if (!empty($result[$primaryKey])) {
                if (Registry::hasObject($cleanType, $result[$primaryKey])) {
                    return Registry::getObject($cleanType, $result[$primaryKey]);
                }
            }
        }

        if (empty($result)) {
            return new $type;
        }

        $classObject = new $type($result);

        if (!empty($primaryKey) && !empty($result[$primaryKey])) {
            Registry::setObject($type, $result[$primaryKey], $classObject);
        }

        return $classObject;
    }
}
