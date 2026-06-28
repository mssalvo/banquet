<?php

namespace Banquet\Driver;

final class Postgre
{
    private $link;

    public function __construct($hostname,$port, $username, $password, $database)
    {
        $conn_string = "host=".$hostname." port=".$port." dbname=".$database." user=".$username." password=".$password;

        $this->link = pg_connect($conn_string);

        if (!$this->link) {
            trigger_error('Errore: Impossibile connettersi al database di ' . $database);
        }

        pg_query($this->link, "SET CLIENT_ENCODING TO 'UTF8'");
    }

    public function query($sql)
    {
        $resource = pg_query($this->link, $sql);

        if ($resource === false) {
            trigger_error('Errore: ' . pg_last_error($this->link) . '<br />' . $sql);
            exit();
        }

        $data = pg_fetch_all($resource);

        if ($data !== false) {
            $query = new \stdClass();
            $query->row = isset($data[0]) ?$data[0]: [];
            $query->rows = $data;
            $query->num_rows = count($data);

            pg_free_result($resource);

            return $query;
        }

        return true;
    }



    public function escape($value)
    {
        return pg_escape_string($this->link, $value);
    }

    public function countAffected()
    {
        return pg_affected_rows($this->link);
    }

    public function getLastId()
    {
        $query = $this->query("SELECT LASTVAL() AS `id`");

        return $query->row['id'];
    }

    public function __destruct()
    {
        pg_close($this->link);
    }
}

?>