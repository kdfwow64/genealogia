<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use LaravelEnso\Multitenancy\Enums\Connections;

trait ConnectionTrait
{
    public function setConnection($conn='mysql', $db='enso', $user_id='')
    {
        $dbname = $db;
        if($conn == Connections::Tenant) {
            $key = 'database.connections.tenant.database';
            $dbname = Connections::Tenant.$user_id."_".$db;
            config([$key => $db]);
        }
        \Session::put('conn', $conn);
        \Session::put('db', $dbname);
    }

    public function getConnection()
    {
        $conn = \Session::get('conn');
        $db = \Session::get('db');
        if($conn == 'tenant') {
            $key = 'database.connections.tenant.database';
            $value = $db;
            config([$key => $value]);
        }
        return $conn;
    }

    public function getDB()
    {
        $db = \Session::get('db');
        return $db;
    }

    public function checkDBExist() {
        $conn = \Session::get('conn');
        $db_name = \Session::get('db');
        if($conn == 'tenant') {
            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$db_name."'";
            $db = \DB::select($query);
            if (empty($db)) {
                return false;
            } else {
                return true;
            }        
        }else {
            return true;
        }
    }
}
