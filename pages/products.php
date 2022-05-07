<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-dolly"></i>
                    Data Barang
                </h3>
                <button class="btn btn-sm btn-primary" onclick="addProduct()"><i class="fas fa-plus-square mr-2"></i>Tambah Data</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-striped">
                <table id="tbProducts" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalProduct" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formProduct" action="" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Kategori</label>
                        <select class="form-control" name="category_id" id="category">
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="buyPrice">Harga Beli</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="buy_price" id="buyPrice" class="form-control" placeholder="Masukkan harga beli" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="sellPrice">Harga Jual</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="sell_price" id="sellPrice" class="form-control" placeholder="Masukkan harga jual" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="stock">Stok</label>
                        <input type="number" name="stock" id="stock" class="form-control" placeholder="Masukkan stok" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">

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

    let categories = {};

    $.ajax({
        type: 'GET',
        url: 'api.php?data=category',
        dataType: 'JSON',
        success: function(response) {
            if (response.success) {
                categories = response.data;
                // console.log(categories);
            }
        }
    })

    const loadProducts = function() {
        const table = $('#tbProducts');
        table.DataTable({
            responsive: true,
            ajax: {
                url: '/api.php?data=product',
                type: 'GET',
            },
            columns: [{
                    data: 'id',
                    render: function(data) {
                        return 'BR-' + String(data).padStart(5, '0')
                    }
                },
                {
                    data: 'name'
                },
                {
                    data: 'category_name'
                },
                {
                    data: 'buy_price',
                    render: function(data) {
                        return rupiah(data);
                    }
                },
                {
                    data: 'sell_price',
                    render: function(data) {
                        return rupiah(data);
                    }
                },
                {
                    data: 'stock',
                    render: function(data){
                        return `<span class="${(data <= 5) ? 'text-danger' : ''}">${data}</span>`;
                    }
                },
                {
                    data: 'status',
                    width: '75px',
                    targets: -2,
                    render: function(data) {
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
                    render: function(data) {
                        return `<button onclick="editProduct(${data})" class="btn btn-sm btn-success mb-1 btn-edit" title="Edit"><i class="fas fa-edit"></i></button>
                                <button onclick="deleteProduct(${data})" class="btn btn-sm btn-danger mb-1 btn-delete" type="button" title="Hapus"><i class="fas fa-trash"></i></button>`;
                    },
                },
            ],
        });
    };


    function reloadProducts() {
        $('#tbProducts').DataTable().ajax.reload();
        no = 1;
    }

    function addProduct() {
        $('#modalProduct').modal('show');
        $('.modal-title').html('<i class="fas fa-plus-square mr-1"></i>Tambah Produk');
        $('#formProduct').attr('action', 'store');
        let options = `<option value="" selected disabled>--Pilih Kategori--</option>`;
        $.each(categories, function(i, cat) {
            options += `<option value="${cat.id}">${cat.name}</option>`;
        })
        $('#category').html(options);
        $('#status').html(
            `<option value="1" selected>Active</option>
            <option value="0">Inactive</option>`
        )
    }


    function editProduct(id) {
        $('#modalProduct').modal('show');
        $('.modal-title').html('<i class="fas fa-edit mr-1"></i>Ubah Produk');
        $('#formProduct').attr('action', 'update');
        $('#formProduct').data('id', id);
        $.ajax({
            type: 'GET',
            url: 'api.php?data=product&id=' + id,
            dataType: 'JSON',
            success: function(response) {
                console.log(response.message);
                if (response.success) {
                    const data = response.data;
                    $('#name').val(data.name);
                    let options = '';
                    $.each(categories, function(i, cat) {
                        options += `<option value="${cat.id}" ${cat.id == data.category_id ? 'selected' : '' }>${cat.name}</option>`;
                    })
                    $('#category').html(options);
                    $('#buyPrice').val(data.buy_price);
                    $('#sellPrice').val(data.sell_price);
                    $('#stock').val(data.stock);
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

    function storeProduct(data) {
        $.ajax({
            type: 'POST',
            url: "api.php?data=product",
            data: data,
            dataType: 'JSON',
            success: function(response) {
                console.log(response.message);
                if (response.success) {
                    $('#modalProduct').modal('hide');
                    reloadProducts();
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

    function updateProduct(data, id) {

        $.ajax({
            type: 'PUT',
            url: 'api.php?data=product&id=' + id,
            data: data,
            headers: {
                "X-HTTP-Method-Override": "PUT"
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.success) {
                    $('#modalProduct').modal('hide');
                    reloadProducts();
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

    function deleteProduct(id) {
        if (confirm('Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                type: 'DELETE',
                url: 'api.php?data=product&id=' + id,
                dataType: 'JSON',
                success: function(response) {
                    console.log(response.message);
                    if (response.success) {
                        reloadProducts();
                        toastr.success(response.message);
                    } else {
                        toastr.warning(response.message);
                    }
                },
                error: function(response) {
                    toastr.error('Terjadi Kesalahan!');
                    console.log(response.message);
                }
            });
        }
    }

    $(document).ready(function() {
        loadProducts()

        $('#formProduct').on('submit', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const form = new FormData(e.target);
            const data = Object.fromEntries(form.entries());
            console.log(data);
            
            if ($(this).attr('action') == 'store') {
                storeProduct(JSON.stringify(data))
            } else {
                updateProduct(JSON.stringify(data), id);
            }
        })

        $('#modalProduct').on('hidden.bs.modal', function(event) {
            $('#formProduct').trigger('reset');
        })


    })
</script>