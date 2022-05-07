<?php
require_once 'Database.php';

class User extends Database
{

    protected $tableName = 'users';

    public function getAll()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->tableName} ORDER BY name");
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
                    'data' => [],
                ];
            }
        } catch (mysqli_sql_exception $exception) {

            $response = [
                'success' => false,
                'message' => $exception->getMessage(),
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
                'data' => [],
            ];
        }

        return $response;
    }

    protected function findEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->tableName} WHERE email = ?");
        $stmt->bind_param('s', $email);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }

    public function insert($request)
    {
        $checkEmail = $this->findEmail($request['email'])->num_rows;

        if ($checkEmail > 0) {
            $response = [
                'success' => false,
                'message' => 'Email sudah terdaftar!',
            ];
        } else {
            $password = password_hash($request['password'], PASSWORD_DEFAULT);

            try {
                $stmt = $this->db->prepare("INSERT INTO {$this->tableName} (name, email, role, password, status) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param('ssssi', $request['name'], $request['email'], $request['role'], $password, $request['status']);

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
                'message' => $exception->getMessage(),
            ];
        }
        return $response;
    }

    public function update($request, $id)
    {
        try {
            if ($request['password'] == '') {
                $stmt = $this->db->prepare("UPDATE {$this->tableName} SET name = ?, role = ?, status = ? WHERE id = ?");
                $stmt->bind_param('ssii', $request['name'], $request['role'], $request['status'], $id);
            } else {
                $stmt = $this->db->prepare("UPDATE {$this->tableName} SET name = ?, role = ?, status = ?, password = ? WHERE id = ?");
                $stmt->bind_param('sssii', $request['name'], $request['role'], $request['status'], $request['password'], $id);
            }

            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $response = [
                    'success' => true,
                    'message' => 'Data berhasil diubah!',
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Tidak ada data yang diubah!',
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

    public function login($request)
    {
        $findEmail = $this->findEmail($request['email']);

        if ($findEmail->num_rows > 0) {
            $user = $findEmail->fetch_object();

            if (password_verify($request['password'], $user->password)) {
                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user->id;
                $_SESSION["name"] = $user->name;

                // Redirect user to welcome page
                header("location: index.php");
                return true;
            }
        }
        return false;
    }
}

