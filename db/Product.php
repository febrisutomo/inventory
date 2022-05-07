<?php
require_once 'Database.php';

class Product extends Database
{

    protected $tableName = 'products';

    public function getAll()
    {
        try {
            $sql = "SELECT
                    products.*,
                    categories.name AS category_name
                FROM
                    products INNER JOIN categories ON products.category_id = categories.id";
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

    public function insert($request)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO {$this->tableName} (name, category_id, buy_price, sell_price, stock, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('siiiii', $request['name'], $request['category_id'], $request['buy_price'], $request['sell_price'], $request['stock'], $request['status']);

            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $response = [
                    'success' => true,
                    'message' => 'Data berhasil ditambahkan!',
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Data gagal ditambahkan!',
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

    public function delete($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM {$this->tableName} WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response = [
                    'success' => true,
                    'message' => 'Data berhasil dihapus!',
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Data gagal dihapus!',
                ];
            }
        } catch (mysqli_sql_exception $exception) {

            $response = [
                'success' => false,
                'message' => $exception->getCode(),
            ];

            if($exception->getCode() == 1451){
                $response['message'] = 'Data terhubung ke tabel lain!';
            }
        }


        return $response;
    }

    public function update($request, $id)
    {
        try {
            $stmt = $this->db->prepare("UPDATE {$this->tableName} SET name = ?, category_id = ?, buy_price = ?, sell_price = ?, stock = ?, status = ? WHERE id = ?");
            $stmt->bind_param('siiiiii', $request['name'], $request['category_id'], $request['buy_price'], $request['sell_price'], $request['stock'], $request['status'],  $id);

            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $response = [
                    'success' => true,
                    'message' => 'Data berhasil diupdate!',
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Tidak ada perubahan data!',
                ];
            }
        } catch (mysqli_sql_exception $exception) {

            $response = [
                'success' => false,
                'message' => 'Error '.$exception->getCode(),
            ];
            
        }

        return $response;
    }

    
    
}





// $p = new Product;

// $r =$p->delete(6);
// var_dump($r);
