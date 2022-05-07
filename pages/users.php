<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-user-lock"></i>
                    User & Roles
                </h3>
                <button class="btn btn-sm btn-primary" onclick="addUser()"><i class="fas fa-plus-square mr-2"></i>Tambah Data</button>
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tbUsers" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID User</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Insert -->
<div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUser" action="" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name='email' id="email" class="form-control" placeholder="example@mail.com" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" name="role" id="role" required>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name='password' id="password" class="form-control" placeholder="Masukkan password" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const loadUsers = function() {
        const table = $('#tbUsers');

        table.DataTable({
            responsive: true,
            ajax: {
                url: '/api.php?data=user',
                type: 'GET',
            },
            columns: [{
                    data: 'id',
                    render: function(data) {
                        return 'USR' + String(data).padStart(5, '0')
                    }
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'role'
                },
                {
                    data: 'status',
                    width: '75px',
                    targets: -2,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: {
                                'title': 'Active',
                                'class': 'badge-primary'
                            },
                            0: {
                                'title': 'Inactive',
                                'class': 'badge-danger'
                            },

                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return `<span class="badge badge-pill ${status[data].class}">${status[data].title}</span>`;
                    },
                },
                {
                    data: 'id',
                    responsivePriority: -1,
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return `<button onclick="editUser(${data})" class="btn btn-sm btn-success mb-1 btn-edit" title="Edit"><i class="fas fa-edit mr-1"></i>Edit</button>
                                <button onclick="deleteUser(${data})" class="btn btn-sm btn-danger mb-1 btn-delete" type="button" title="Hapus"><i class="fas fa-trash mr-1"></i>Hapus</button>`;
                    },
                },
            ],
        });
    };


    function reloadUsers() {
        $('#tbUsers').DataTable().ajax.reload();
    }

    function addUser() {
        $('#modalUser').modal('show');
        $('.modal-title').html('<i class="fas fa-user-plus mr-1"></i>Tambah User');
        $('#formUser').attr('action', 'store');
        $('#role').html(
            `<option value="" selected disabled>--Pilih Role--</option>
            <option value="admin">Admin</option>
            <option value="pegawai">Pegawai</option>`
        );
        $('#status').html(
            `<option value="1" selected>Active</option>
            <option value="0" selected'>Inactive</option>`
        );
        $('#password').attr('required', true);
        $('#email').attr('readonly', false);
    }

    function editUser(id) {
        $('#modalUser').modal('show');
        $('.modal-title').html('<i class="fas fa-user-edit mr-1"></i>Ubah User');
        $('#formUser').attr('action', 'update');
        $('#formUser').data('id', id);
        $('#password').attr('required', false);
        $('#email').attr('readonly', true);
        $.ajax({
            type: 'GET',
            url: 'api.php?data=user&id=' + id,
            dataType: 'JSON',
            success: function(response) {
                console.log(response.message);
                if (response.success) {
                    const data = response.data;
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#role').html(
                        `<option value="admin" ${data.role == 'admin' ? 'selected' : '' }>Admin</option>
                        <option value="pegawai" ${data.role == 'pegawai' ? 'selected' : '' }>Pegawai</option>`
                    );
                    $('#status').html(
                        `<option value="1" ${data.status == '1' ? 'selected' : '' }>Active</option>
                        <option value="0" ${data.status == '0' ? 'selected' : '' }>Inactive</option>`
                    );
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(response) {
                console.log(response.message);
            }
        });
    }

    function storeUser(data) {
        $.ajax({
            type: 'POST',
            url: "api.php?data=user",
            data: JSON.stringify(data),
            dataType: 'JSON',
            success: function(response) {
                console.log(response.message);
                if (response.success) {
                    $('#modalUser').modal('hide');
                    reloadUsers();
                    toastr.success(response.message);
                } else {
                    toastr.warning(response.message);
                }
            },
            error: function() {
                toastr.error('Terjadi Kesalahan!');
            }
        });
    }

    function updateUser(data, id) {
        console.log(data);
        $.ajax({
            type: 'PUT',
            url: 'api.php?data=user&id=' + id,
            data: JSON.stringify(data),
            headers: {
                "X-HTTP-Method-Override": "PUT"
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.success) {
                    $('#modalUser').modal('hide');
                    reloadUsers();
                    toastr.success(response.message);
                } else {
                    toastr.warning(response.message);
                }
            },
            error: function() {
                toastr.error('Terjadi Kesalahan!');
            }
        });
    }

    function deleteUser(id) {
        if (confirm('Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                type: 'DELETE',
                url: 'api.php?data=user&id=' + id,
                dataType: 'JSON',
                success: function(response) {
                    console.log(response.message);
                    if (response.success) {
                        reloadUsers();
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(response) {
                    console.log(response.message);
                }
            });
        }
    }



    $(document).ready(function() {
        loadUsers();

        $('#formUser').on('submit', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const form = new FormData(e.target);
            const data = Object.fromEntries(form.entries());
            console.log(data);
            if ($(this).attr('action') == 'store') {
                storeUser(data)
            } else {
                updateUser(data, id);
            }
        })

        $('#modalUser').on('hidden.bs.modal', function(event) {
            $('#formUser').trigger('reset');
        })



    });
</script>