namespace App\Helpers;
use Config;
use DB;

class DatabaseConnection
{
    public static function setConnection($params)
    {
        config(['database.connections.onthefly' => [
            'driver' => $params->driver,
            'host' => $params->host,
            'username' => $params->username,
            'password' => $params->password
        ]]);

        return DB::connection('onthefly');
    }
}

/*use App\Helpers\DatabaseConnection;
... 

$params = Database::find( 1 );
$connection = DatabaseConnection::setConnection($params);
$users = $connection->select(...);*/