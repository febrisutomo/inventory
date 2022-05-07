<?php
require_once 'Database.php';

class Sale extends Database
{

    protected $tableName = 'sales';

    public function getAll()
    {
        try {
            $sql = "SELECT sales.*, customers.name AS customer_name
                    FROM sales INNER JOIN customers ON sales.customer_id = customers.id
                    ORDER BY created_at DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_object()) {
                    $data[] = $row;
                }
                $response = [
                    'success' => true,
                    'message' => $result->num_rows . ' data available',
                    'data' => $data,
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No data available',
                    'data' => [],
                ];
            }
        } catch (mysqli_sql_exception $exception) {

            $response = [
                'success' => false,
                'message' => 'Error ' . $exception->getCode(),
                'data' => [],
            ];
        }

        return $response;
    }

    public function find($id)
    {
        try {

            $stmt = $this->db->prepare("SELECT sales.*, customers.name AS customer_name
            FROM sales INNER JOIN customers ON sales.customer_id = customers.id WHERE sales.id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                $stmt2 = $this->db->prepare("SELECT sale_items.*, products.sell_price, (products.sell_price * sale_items.qty) AS subtotal
            FROM sale_items INNER JOIN products ON sale_items.product_id = products.id WHERE sale_id = ?");
                $stmt2->bind_param('i', $id);
                $stmt2->execute();
                $result2 = $stmt2->get_result();

                while($item = $result2->fetch_assoc() ){
                    $items[] = $item;
                }

                $data = $result->fetch_assoc();
                $data['items'] = $items;

                $response = [
                    'success' => true,
                    'message' => $result->num_rows . ' data available',
                    'data' => $data,
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No data available',
                    'data' => [],
                ];
            }
        } catch (mysqli_sql_exception $exception) {

            $response = [
                'success' => false,
                'message' => 'Error ' . $exception->getMessage(),
                'data' => [],
            ];
        }

        return $response;
    }


    protected function insertSale($data)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->tableName} (customer_id, total) VALUES (?, ?)");
        $stmt->bind_param('ii', $data['customer_id'], $data['total']);

        $stmt->execute();
        $last_id = $this->db->insert_id;
        return $last_id;
    }

    protected function insertItems($items, $id)
    {
        $stmt = $this->db->prepare("INSERT INTO sale_items (sale_id, product_id, product_name, qty ) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('iisi', $id, $product_id, $product_name, $qty);


        foreach ($items as $item) {
            $product_id = $item['product_id'];
            $product_name = $item['product_name'];
            $qty = $item['qty'];
            $stmt->execute();

            $stmt2 = $this->db->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            $stmt2->bind_param('ii', $item['qty'], $item['product_id']);
            $stmt2->execute();
        }

        if ($stmt->affected_rows > 0) {
            $response = [
                'success' => true,
                'message' => 'Transaksi berhasil ditambahkan!',
                'data' => $id,
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Transaksi gagal ditambahkan!',
            ];
        }

        return $response;
    }

    public function insert($request)
    {

        $this->db->begin_transaction();

        try {
            $last_id = $this->insertSale($request);

            $response = $this->insertItems($request['items'], $last_id);

            $this->db->commit();

        } catch (mysqli_sql_exception $exception) {

            $this->db->rollback();

            $response = [
                'success' => false,
                'message' => 'Error ' . $exception->getMessage(),
            ];
        }

        return $response;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->tableName} WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = [
                'success' => true,
                'message' => 'Transaksi berhasil dihapus!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Transaksi gagal dihapus!',
            ];
        }

        return $response;
    }

    public function update($request, $id)
    {

        $stmt = $this->db->prepare("UPDATE {$this->tableName} SET customer_id = ?, product_id = ?, qty = ? WHERE id = ?");
        $stmt->bind_param('iiii', $request['customer_id'], $request['product_id'], $request['qty'], $id);

        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $response = [
                'success' => true,
                'message' => 'Transaksi berhasil diupdate!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Transaksi gagal diupdate',
            ];
        }

        return $response;
    }
}
