<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-chart-line"></i>
                    Laporan
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center mb-3 ">
                <label for="daterange" class="mr-2">Rentang Tanggal</label>
                <div id="reportrange" style="cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>

            </div>
            <div class="table-responsive">
                <table id="tbProducts" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <!-- <th>No</th> -->
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Tersedia</th>
                            <th>Total Penjualan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#tbProducts').DataTable().destroy();
            fetch_data(start.format('YYYY-MM-DD'), end.add(1, 'days').format('YYYY-MM-DD'));
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.add(1, 'days').format('YYYY-MM-DD'));
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        
        cb(start, end)
    })


    function fetch_data(start_date = '', end_date = '') {
        var dataTable = $('#tbProducts').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "responsive": true,
            "searching": false,
            "lengthChange": false,
            "ajax": {
                url: "/pages/_datareport.php",
                type: "POST",
                data: {
                    start_date: start_date,
                    end_date: end_date
                }
            },
        });
    }
</script>