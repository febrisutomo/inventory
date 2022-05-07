<div class="container-fluid">
    <div class="col-lg-8 mx-auto">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-folder"></i>
                        Data Kategori
                    </h3>
                    <!-- <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalInsert"><i class="fas fa-plus-square mr-2"></i>Tambah Data</button> -->
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form id="formCategory" action="store" method="POST" class="d-flex justify-content-between align-items-center mb-3">
                        <input class="form-control mr-2" id="name" name="name" value="" placeholder="Nama Kategori" required>
                        <button class="btn btn-primary text-nowrap btn-save" type="submit"><i class="fas fa-plus-square mr-2"></i>Tambahkan</button>
                        <button class="btn btn-secondary text-nowrap btn-cancel ml-2 d-none" type="button"><i class="fas fa-times mr-2"></i>Batal</button>
                    </form>
                    <table id="tbCategories" class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Kategori</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    let no = 1;

    const loadCategories = function() {
        const table = $('#tbCategories');
        table.DataTable({
            responsive: true,
            searching: false,
            lengthChange: false,
            ajax: {
                url: '/api.php?data=category',
                type: 'GET',
            },
            columns: [
                // {
                //     render: function() {
                //         return no++;
                //     }
                // },
                {
                    data: 'id',
                    render: function(data) {
                        return 'KT-' + String(data).padStart(5, '0')
                    }
                },
                {
                    data: 'name'
                },
                {
                    data: {},
                    responsivePriority: -1,
                    orderable: false,
                    render: function(data) {
                        return `<button onclick="editCategory(${data.id}, '${data.name}')" class="btn btn-sm btn-success mb-1 btn-edit" title="Edit"><i class="fas fa-edit"></i></button>
                            <button onclick="deleteCategory(${data.id})" class="btn btn-sm btn-danger mb-1 btn-delete" type="button" title="Hapus"><i class="fas fa-trash"></i></button>`;
                    },
                },
            ],
        });
    };


    function reloadCategories() {
        $('#tbCategories').DataTable().ajax.reload();
        no = 1;
    }

    function storeCategory(data) {
        $.ajax({
            type: 'POST',
            url: "api.php?data=category",
            data: JSON.stringify(data),
            dataType: 'JSON',
            success: function(response) {
                console.log(response.message);
                if (response.success) {
                    $("#formCategory").trigger("reset");
                    reloadCategories();
                    toastr.success(response.message);
                } else {
                    toastr.warning(response.message);
                }
            },
            error: function() {
                toastr.error('Terjadi Kesalahan!');;
            }
        });
    }

    function editCategory(id, name) {
        $('.btn-cancel').removeClass('d-none').addClass('d-block');
        $('#name').val(name);
        $('#formCategory').attr('action', 'update');
        $('#formCategory').data('id', id);
        $('.btn-save').html(`<i class="fas fa-edit mr-2"></i>Update`);
    }

    function insertMode() {
        $('#formCategory').trigger('reset');
        $('#formCategory').attr('action', 'store');
        $('.btn-cancel').removeClass('d-block').addClass('d-none');
        $('.btn-save').html(`<i class="fas fa-plus-square mr-2"></i>Tambahkan`);
    }

    function updateCategory(data, id) {
        $.ajax({
            type: 'PUT',
            url: 'api.php?data=category&id=' + id,
            data: JSON.stringify(data),
            headers: {
                "X-HTTP-Method-Override": "PUT"
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.success) {
                    insertMode();
                    reloadCategories();
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

    function deleteCategory(id) {
        if (confirm('Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                type: 'DELETE',
                url: 'api.php?data=category&id=' + id,
                dataType: 'JSON',
                success: function(response) {
                    console.log(response.message);
                    if (response.success) {
                        reloadCategories();
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
        loadCategories()

        $('#formCategory').on('submit', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const form = new FormData(e.target);
            const data = Object.fromEntries(form.entries());
            if ($(this).attr('action') == 'store') {
                storeCategory(data)
            } else {
                updateCategory(data, id);
            }
        })

        $('.btn-cancel').on('click', function() {
            insertMode();
        })

    })
</script>