<?php
require_once 'Database.php';

class Dashboard extends Database
{

    public function count_sales()
    {

        $sql = "SELECT * FROM sales";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows;
    }

    public function count_products()
    {

        $sql = "SELECT * FROM products";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows;
    }

    public function count_customers()
    {

        $sql = "SELECT * FROM customers";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows;
    }

    public function count_categories()
    {

        $sql = "SELECT * FROM customers";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows;
    }


}
