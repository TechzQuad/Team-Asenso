<?php

class Model{
    private $servername = "localhost";
    private $username = "u722023368_techzquad";
    private $password = "@TechzQuad1";
    private $dbname = "u722023368_toboso";
    private $conn;
    
    public function __construct()
    {
        try {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        } catch (\Throwable $th) {
            //throw $th;
            echo "Connection error " . $th->getMessage();
        }
    }
    
    public function fetch()
    {
        $data = [];

        $query = "SELECT election.name,election.standing, election.pn, election.pos, election.brgy, election.prk, election.status , attendance.* from attendance INNER JOIN election ON attendance.v_id=election.id";
        if ($sql = $this->conn->query($query)) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $data[] = $row;
            }
        }

        return $data;
    }
    
    
    public function fetch_filter_date($date)
    {
        $data = [];

        $query = "SELECT election.name,election.standing, election.pn, election.pos, election.brgy, election.prk , attendance.* from attendance INNER JOIN election ON attendance.v_id=election.id where date like '$date%'";
        if ($sql = $this->conn->query($query)) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $data[] = $row;
            }
        }

        return $data;
    }
    
    
    
    public function fetch_date()
    {
        $data = [];

        $query = "SELECT DISTINCT SUBSTRING_INDEX(date, ' ', 1) as date FROM attendance order by date ASC";
        if ($sql = $this->conn->query($query)) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function delete_attendance($id)
    {
        $rows = mysql_query("DELETE FROM attendance WHERE id=$id");
        return $rows;
    }


    
    
    
    
}
?>









