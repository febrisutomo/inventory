<?php
require_once 'Database.php';

class Supplier extends Database
{

    protected $tableName = 'suppliers';

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->tableName} ORDER BY name");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $data[] = $row;
            }
        } else {
            $data = [];
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
                'message' => 'Failed',
                'data' => [],
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

        // var_dump($data[->name);

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

        try {
            $stmt = $this->db->prepare("INSERT INTO {$this->tableName} (name, phone, address, status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('sssi', $request['name'], $request['phone'], $request['address'], $request['status']);

            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response = [
                    'success' => true,
                    'message' => 'Supplier berhasil ditambahkan!',
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Supplier gagal ditambahkan!',
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
        $stmt = $this->db->prepare("DELETE FROM {$this->tableName} WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = [
                'success' => true,
                'message' => 'Supplier berhasil dihapus!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Supplier gagal dihapus!',
            ];
        }

        return $response;
    }

    public function update($request, $id)
    {
        $stmt = $this->db->prepare("UPDATE {$this->tableName} SET name = ?, phone = ?, address = ?, status= ? WHERE id = ?");
        $stmt->bind_param('sssii', $request['name'], $request['phone'], $request['address'], $request['status'], $id);

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = [
                'success' => true,
                'message' => 'Supplier berhasil diupdate!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Supplier gagal diupdate!',
            ];
        }

        return $response;
    }
}
