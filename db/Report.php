<?php
require_once 'Database.php';

class Report extends Database
{

    public function sales()
    {
        try {
            $sql = "SELECT products.*, SUM(sale_items.qty) AS sold, SUM(products.sell_price * sale_items.qty) AS total FROM products INNER JOIN sale_items ON products.id = sale_items.product_id GROUP BY products.name";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                    $data[] = $row;
                }
                $response = [
                    'success' => true,
                    'message' => $result->num_rows . ' data ditemukan!',
                    'data' => $data,
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Data tidak ditemukan!',
                ];
            }
        } catch (mysqli_sql_exception $exception) {

            $response = [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
        }

        return $response;
    }

    public function items()
    {
        $sql = "SELECT products.*,
                 SUM(sale_items.qty) AS qty_out,
                 SUM(purchase_items.qty) AS qty_in,
                 SUM(products.sell_price * sale_items.qty) AS total
                 FROM products LEFT JOIN sale_items
                 ON products.id = sale_items.product_id
                 LEFT JOIN purchase_items
                 ON products.id = purchase_items.product_id
                ";

        if ($_POST["start_date"] && $_POST["end_date"]) {
            $sql .= "WHERE sale_items.created_at BETWEEN '{$_POST["start_date"]}' AND '{$_POST["end_date"]}' ";
        }

        $sql .= "GROUP BY products.name";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = array();

        while ($row = $result->fetch_array()) {
            $sub_array = array();
            $sub_array[] = "BL-" . str_pad($row["id"], 5, "0", STR_PAD_LEFT);
            $sub_array[] = $row["name"];
            $sub_array[] = $row["qty_in"];
            $sub_array[] = $row["qty_out"];
            $sub_array[] = $row["stock"];
            $sub_array[] = rupiah($row["total"]);
            $data[] = $sub_array;
        }


        $output = array(
            "draw"    => intval($_POST["draw"]),
            "recordsTotal"  =>  $result->num_rows,
            "recordsFiltered" => $result->num_rows,
            "data"    => $data
        );

        echo json_encode($output);
    }
}
