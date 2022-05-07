<?php
require_once 'Database.php';

class Purchase extends Database
{

    protected $tableName = 'purchases';

    public function getAll()
    {
        try {
            $sql = "SELECT purchases.*, suppliers.name AS supplier_name
                    FROM purchases INNER JOIN suppliers ON purchases.supplier_id = suppliers.id
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
            $stmt = $this->db->prepare("SELECT * FROM {$this->tableName} WHERE id = ?");
            $stmt->bind_param('i', $id);

            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $data = $result->fetch_object();
                $response = [
                    'success' => true,
                    'message' => $result->num_rows . ' data found',
                    'data' => $data,
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'No Data Found',
                ];
            }
        } catch (mysqli_sql_exception $exception) {

            $response = [
                'success' => false,
                'message' => 'Error ' . $exception->getCode(),
            ];
        }

        return $response;
    }


    protected function insertPurchase($data)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->tableName} (supplier_id, total) VALUES (?, ?)");
        $stmt->bind_param('ii', $data['supplier_id'], $data['total']);

        $stmt->execute();
        $last_id = $this->db->insert_id;
        return $last_id;
    }

    protected function insertItems($items, $id)
    {
        $stmt = $this->db->prepare("INSERT INTO purchase_items (purchase_id, product_id, product_name, qty ) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('iisi', $id, $product_id, $product_name, $qty);


        foreach ($items as $item) {
            $product_id = $item['product_id'];
            $product_name = $item['product_name'];
            $qty = $item['qty'];
            $stmt->execute();

            $stmt2 = $this->db->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
            $stmt2->bind_param('ii', $item['qty'], $item['product_id']);
            $stmt2->execute();
        }

        if ($stmt->affected_rows > 0) {
            $response = [
                'success' => true,
                'message' => 'Transaksi berhasil ditambahkan!',
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
        // var_dump($request);

        $this->db->begin_transaction();

        try {
            $last_id = $this->insertPurchase($request);

            $response = $this->insertItems($request['items'], $last_id );

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

        $stmt = $this->db->prepare("UPDATE {$this->tableName} SET supplier_id = ?, product_id = ?, qty = ? WHERE id = ?");
        $stmt->bind_param('iiii', $request['supplier_id'], $request['product_id'], $request['qty'], $id);

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
