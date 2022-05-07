<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-shopping-bag"></i>
                    Daftar Pembelian
                </h3>
                <a href="/purchases" class="btn btn-sm btn-primary"><i class="fas fa-plus-square mr-2"></i>Pembelian Baru</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tbPurchases" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <!-- <th>No</th> -->
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Nama Pemasok</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<script>

    const loadPurchases = function() {
        const table = $('#tbPurchases');
        table.DataTable({
            responsive: true,
            order: [[ 1, "desc" ]],
            ajax: {
                url: '/api.php?data=purchase',
                type: 'GET',
            },
            columns: [{
                    data: 'id',
                    render: function(data) {
                        return 'BL-' + String(data).padStart(5, '0')
                    }
                },
               
                {
                    data: 'created_at',
                    render: function(data){
                        // const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                        const date = new Date(data);
                        return date.toLocaleDateString('id-ID')
                    }
                },
                {
                    data: 'supplier_name',
                },
                {
                    data: 'total',
                    render: function(data) {
                        return rupiah(data);
                    }
                },
                {
                    data: 'id',
                    responsivePriority: -1,
                    orderable: false,
                    render: function(data) {
                        return `<button class="btn btn-sm btn-success mb-1" title="Cetak"><i class="fas fa-print"></i></button>
                                <button onclick="deleteProduct(${data})" class="btn btn-sm btn-danger mb-1 btn-delete" type="button" title="Hapus"><i class="fas fa-trash"></i></button>`;
                    },
                },
            ],
        });
    };


    function reloadPurchases() {
        $('#tbPurchases').DataTable().ajax.reload();
    }


    function deleteProduct(id) {
        if (confirm('Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                type: 'DELETE',
                url: 'api.php?data=purchase&id=' + id,
                dataType: 'JSON',
                success: function(response) {
                    console.log(response.message);
                    if (response.success) {
                        reloadPurchases();
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
        loadPurchases()
    });

</script>