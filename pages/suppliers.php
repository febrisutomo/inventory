<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-store"></i>
                    Data Pemasok
                </h3>
                <button class="btn btn-sm btn-primary" onclick="addSupplier()"><i class="fas fa-plus-square mr-2"></i>Tambah Data</button>
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tbSuppliers" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
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
<div class="modal fade" id="modalSupplier" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formSupplier" action="" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan Nama" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">No. Telepon</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Masukkan No. Telepon" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea class="form-control" name="address" id="address" cols="30" rows="3" placeholder="Masukkan Alamat" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
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
    let i = 1;

    const loadSuppliers = function() {
        const table = $('#tbSuppliers');

        table.DataTable({
            responsive: true,
            ajax: {
                url: '/api.php?data=supplier',
                type: 'GET',
            },
            columns: [
                {
                    data: 'id',
                    render: function(data) {
                        return 'SP-' + String(data).padStart(5, '0')
                    }
                },
                {
                    data: 'name'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'address'
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
                        return `<button onclick="editSupplier(${data})" class="btn btn-sm btn-success mb-1 btn-edit" title="Edit"><i class="fas fa-edit mr-1"></i>Edit</button>
                                <button onclick="deleteSupplier(${data})" class="btn btn-sm btn-danger mb-1 btn-delete" type="button" title="Hapus"><i class="fas fa-trash mr-1"></i>Hapus</button>`;
                    },
                },
            ],
        });
    };


    function reloadSuppliers() {
        $('#tbSuppliers').DataTable().ajax.reload();
        i = 1;
    }

    function addSupplier() {
        $('#modalSupplier').modal('show');
        $('.modal-title').html('<i class="fas fa-plus-square mr-1"></i>Tambah Supplier');
        $('#formSupplier').attr('action', 'store');
        $('#status').html(
            `<option value="1" selected>Active</option>
            <option value="0" selected'>Inactive</option>`
        );
    }

    function editSupplier(id) {
        $('#modalSupplier').modal('show');
        $('.modal-title').html('<i class="fas fa-edit mr-1"></i>Ubah Supplier');
        $('#formSupplier').attr('action', 'update');
        $('#formSupplier').data('id', id);
        $.ajax({
            type: 'GET',
            url: 'api.php?data=supplier&id=' + id,
            dataType: 'JSON',
            success: function(response) {
                console.log(response.message);
                if (response.success) {
                    const data = response.data;
                    $('#name').val(data.name);
                    $('#phone').val(data.phone);
                    $('#address').text(data.address);
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

    function storeSupplier(data) {
        $.ajax({
            type: 'POST',
            url: "api.php?data=supplier",
            data: JSON.stringify(data),
            dataType: 'JSON',
            success: function(response) {
                console.log(response.message);
                if (response.success) {
                    $('#modalSupplier').modal('hide');
                    reloadSuppliers();
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

    function updateSupplier(data, id) {
        console.log(data);
        $.ajax({
            type: 'PUT',
            url: 'api.php?data=supplier&id=' + id,
            data: JSON.stringify(data),
            headers: {
                "X-HTTP-Method-Override": "PUT"
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.success) {
                    $('#modalSupplier').modal('hide');
                    reloadSuppliers();
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

    function deleteSupplier(id) {
        if (confirm('Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                type: 'DELETE',
                url: 'api.php?data=supplier&id=' + id,
                dataType: 'JSON',
                success: function(response) {
                    console.log(response.message);
                    if (response.success) {
                        reloadSuppliers();
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
        loadSuppliers();

        $('#formSupplier').on('submit', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const form = new FormData(e.target);
            const data = Object.fromEntries(form.entries());

            if ($(this).attr('action') == 'store') {
                storeSupplier(data)
            } else {
                updateSupplier(data, id);
            }
        })

        $('#modalSupplier').on('hidden.bs.modal', function(event) {
            $('#formSupplier').trigger('reset');
            $('#address').empty();
        })



    });
</script>