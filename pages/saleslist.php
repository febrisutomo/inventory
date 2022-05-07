<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-shopping-bag"></i>
                    Daftar Penjualan
                </h3>
                <a href="/sales" class="btn btn-sm btn-primary"><i class="fas fa-plus-square mr-2"></i>Penjualan Baru</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tbSales" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <!-- <th>No</th> -->
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Nama Pelanggan</th>
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

    const loadSales = function() {
        const table = $('#tbSales');
        table.DataTable({
            responsive: true,
            order: [[ 1, "desc" ]],
            ajax: {
                url: '/api.php?data=sale',
                type: 'GET',
            },
            columns: [{
                    data: 'id',
                    render: function(data) {
                        return 'TRX-' + String(data).padStart(5, '0')
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
                    data: 'customer_name',
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
                        return `<a href="/saledetail/${data}" class="btn btn-sm btn-primary mb-1" title="Detail"><i class="fas fa-eye"></i></a>
                                <a href="/print/sale.php?id=${data}" target="_blank" class="btn btn-sm btn-success mb-1" title="Print"><i class="fas fa-print"></i></a>
                                <button onclick="deleteProduct(${data})" class="btn btn-sm btn-danger mb-1 btn-delete" type="button" title="Hapus"><i class="fas fa-trash"></i></button>`;
                    },
                },
            ],
        });
    };


    function reloadSales() {
        $('#tbSales').DataTable().ajax.reload();
    }


    function deleteProduct(id) {
        if (confirm('Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                type: 'DELETE',
                url: 'api.php?data=sale&id=' + id,
                dataType: 'JSON',
                success: function(response) {
                    console.log(response.message);
                    if (response.success) {
                        reloadSales();
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
        loadSales()
    });

</script>