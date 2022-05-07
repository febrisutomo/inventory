<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-shopping-bag"></i>
                            Transaksi Pembelian
                        </h3>
                        <!-- <button class="btn btn-primary"><i class="fas fa-file-alt mr-2"></i>Data Transaksi</button> -->
                    </div>

                </div>
                <div class="card-body">
                    <form id="formItems" action="" method="POST" class="d-flex justify-content-between align-items-center mb-3">
                        <select class="select-item form-control mr-2" name="select_item" required></select>
                        <input type="number" id="qty" name="qty" class="form-control mr-2" placeholder="Jumlah" style="max-width: 200px;" required>
                        <button class="btn btn-primary text-nowrap btn-save" type="submit"><i class="fas fa-plus-square mr-2"></i>Tambahkan</button>
                    </form>

                    <div class="items">

                    </div>

                    <div class="table-responsive">
                        <table id="tbItems" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Harga Beli</th>
                                    <th>Kuantitas</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        Pemasok
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-supplier" action="" method="POST">
                        <div class="form-group">
                            <select class="select-supplier form-control mr-2" name="supplier_select" required></select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        Total Bayar
                    </div>
                </div>
                <div class="card-body">
                    <h1 class="total"></h1>

                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <button class="btn btn-secondary text-nowrap btn-reset"><i class="fas fa-history mr-1"></i>Reset</button>
                        <button class="btn btn-primary text-nowrap btn-process"><i class="fas fa-save mr-1"></i>Proses</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


<script>
    // let items = [{
    //     product_id: "15",
    //     product_name: "Mesin Cuci",
    //     buy_price: 1222,
    //     qty: 3,
    //     subtotal: 3666
    // }, {
    //     product_id: "1",
    //     product_name: "Laptop",
    //     buy_price: 10000,
    //     qty: 2,
    //     subtotal: 20000
    // }];

    let items = [];

    let supplier = [];

    let total = 0;

    function rupiah(number) {
        return 'Rp' + new Intl.NumberFormat(['ban', 'id']).format(number);
    };

    function removeItem(id) {
        items = items.filter((item) => item.product_id != id);
        $('#tbItems').dataTable().fnClearTable();
        if (items.length != 0) {
            $('#tbItems').dataTable().fnAddData(items);
        }
        localStorage.setItem('buyItems', JSON.stringify(items));
        calcTotal(items);
    }

    function calcTotal(items) {
        if (items) {
            total = items.reduce((sum, item) => sum + item.subtotal, 0);
        } else {
            total = 0;
        }
        $('.total').text(rupiah(total));
    }

    $(document).ready(function() {


        calcTotal(items);


        if (localStorage.getItem('buyItems')) {
            items = JSON.parse(localStorage.getItem('buyItems'));
            console.log(items);
            calcTotal(items);
        }
        if (localStorage.getItem('supplier')) {
            supplier = JSON.parse(localStorage.getItem('supplier'));
            console.log(supplier);
            var newOption = new Option(supplier.name, supplier.id, false, false);
            $('.select-supplier').append(newOption).trigger('change');
        }

        $('#tbItems').DataTable({
            data: items,
            searching: false,
            lengthChange: false,
            columns: [{
                    data: 'product_id',
                    width: '50px',
                    render: function(data) {
                        return 'PRD' + String(data).padStart(5, '0')
                    }
                },
                {
                    data: 'product_name'
                },
                {
                    data: 'buy_price',
                    render: function(data) {
                        return rupiah(data);
                    }
                },
                {
                    data: 'qty',
                    width: '75px',
                },
                {
                    data: 'subtotal',
                    render: function(data) {
                        return rupiah(data);
                    }
                },
                {
                    data: 'product_id',
                    width: '75px',
                    responsivePriority: -1,
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return `<button onclick="removeItem(${data})" class="btn btn-sm btn-danger mb-1 btn-delete text-nowrap" type="button" title="Hapus"><i class="fas fa-trash mr-2"></i>Hapus</button>`;
                    },
                },
            ],


        });

        $(".select-supplier").select2({
            ajax: {
                url: "/api.php?data=supplier",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term // search term
                    };
                },
                processResults: function(response, params) {
                    var resData = [];
                    response.data.forEach(function(value) {
                        if (value.name.toLowerCase().indexOf(params.term.toLowerCase()) != -1 && value.status == 1)
                            resData.push(value)
                    })
                    return {
                        results: $.map(resData, function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                            }
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1,
            placeholder: 'Pilih Supplier',
        })

        $(".select-item").select2({
            ajax: {
                url: "/api.php?data=product",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term // search term
                    };
                },
                processResults: function(response, params) {
                    var resData = [];
                    response.data.forEach(function(value) {
                        if (value.name.toLowerCase().indexOf(params.term.toLowerCase()) != -1 && value.status == 1 && value.stock > 0)
                            resData.push(value)
                    })
                    return {
                        results: resData
                    };
                },
                cache: true
            },
            minimumInputLength: 1,
            placeholder: 'Masukkan Nama Produk',
            templateResult: formatRepo,
            templateSelection: formatRepoSelection

        })

        function formatRepo(repo) {
            if (repo.loading) {
                return repo.text;
            }

            var $container = $(
                "<div>" +
                "<div class='name'></div>" +
                "</div>"
            );

            $container.find(".name").text('BR-' + String(repo.id).padStart(5, '0') + ' - ' + repo.name);

            return $container;
        }

        function formatRepoSelection(repo) {
            let obj = $('.select-item').data('obj', repo);
            return repo.id ? ('PRD' + String(repo.id).padStart(5, '0') + ' - ' + repo.name) : repo.text
        }



        $('#formItems').on('submit', function(e) {
            e.preventDefault();
            $('.select-item').empty();
            const item = $('.select-item').data('obj');
            const qty = $('#qty').val();
            const subtotal = qty * item.buy_price;
            let json = {
                product_id: item.id,
                product_name: item.name,
                buy_price: item.buy_price,
                qty: qty,
                subtotal: subtotal,
            };

            const index = items.findIndex(element => {
                if (element.product_id == item.id) {
                    return true;
                }
            });
            if (index == -1) {
                items.push(json);
            } else {
                alert('Produk sudah ditambahkan!')
            }

            $(this).trigger('reset');

            $('#tbItems').dataTable().fnClearTable();
            $('#tbItems').dataTable().fnAddData(items);
            localStorage.setItem('buyItems', JSON.stringify(items));
            calcTotal(items);
        });

        function reset() {
            items = [];
            supplier = [];
            $('#tbItems').dataTable().fnClearTable();
            localStorage.removeItem('buyItems');
            localStorage.removeItem('supplier');
            calcTotal(items);
            $('.select-supplier').empty();
        }

        $('.btn-reset').on('click', function() {
            reset();
        })


        $('.select-supplier').on('change', function() {
            let data = $('.select-supplier').select2('data');
            supplier = {
                id: data[0].id,
                name: data[0].text,
            }
            localStorage.setItem('supplier', JSON.stringify(supplier));
        })

        function storePurchase(data) {
            $.ajax({
                type: 'POST',
                url: "api.php?data=purchase",
                data: data,
                dataType: 'JSON',
                success: function(response) {
                    console.log(response.message);
                    if (response.success) {
                        reset();
                        toastr.success(response.message);
                        window.location.href = '/purchaseslist';
                    } else {
                        toastr.warning(response.message);
                    }
                },
                error: function() {
                    toastr.error('Terjadi Kesalahan!');
                }
            });
        }

        $('.btn-process').on('click', function() {
            if (supplier.length == 0) {
                alert('Mohon pilih supplier!');
                $('.select-supplier').focus();
            } else {
                let purchase = {
                    supplier_id: supplier.id,
                    items: items,
                    total: total,
                }
                storePurchase(JSON.stringify(purchase));
            }

        })
    });
</script>