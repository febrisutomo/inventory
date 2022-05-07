<?php
require_once 'Database.php';

class Category extends Database
{

    protected $tableName = 'categories';

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->tableName}");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }

        if ($data) {
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

        return $response;
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->tableName} WHERE id = ?");
        $stmt->bind_param('i', $id);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_object();

        if ($data) {
            $response = [
                'success' => true,
                'message' => 'success',
                'data' => $data,
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Data Found',
            ];
        }

        return $response;
    }

    public function insert($request)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->tableName} (name) VALUES (?)");
        $stmt->bind_param('s', $request['name']);

        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $response = [
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Kategori gagal ditambahkan!',
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
                    'message' => 'Kategori berhasil dihapus!',
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Kategori gagal dihapus!',
                ];
            }
        } catch (mysqli_sql_exception $exception) {
            $response = [
                'success' => false,
                'message' => 'Error ' . $exception->getCode(),
            ];
            if ($exception->getCode() == 1451) {
                $response['message'] = "Kategori masih digunakan oleh beberapa barang!";
            }
        }

        return $response;
    }

    public function update($request, $id)
    {

        $stmt = $this->db->prepare("UPDATE {$this->tableName} SET name = ? WHERE id = ?");
        $stmt->bind_param('si', $request['name'], $id);

        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $response = [
                'success' => true,
                'message' => 'Kategori berhasil diupdate!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Kategori gagal diupdate',
            ];
        }

        return $response;
    }
}
