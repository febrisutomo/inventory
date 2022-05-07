<?php

require_once '../db/Sale.php';

$objSale = new Sale;

$sale = [];

if (isset($_GET['id']) && $_GET['id'] != '') {
    $sale = $objSale->find($_GET['id'])['data'];
}

function rupiah($angka)
{
    $hasil = 'Rp ' . number_format($angka, 2, ",", ".");
    return $hasil;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Invoice Print</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css" integrity="sha512-IuO+tczf4J43RzbCMEFggCWW5JuX78IrCJRFFBoQEXNvGI6gkUw4OjuwMidiS4Lm9Q2lILzpJwZuMWuSEeT9UQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="wrapper">

        <section class="invoice">

            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        <i class="fas fa-shopping-cart"></i> KUITANSI PENJUALAN
                        <!-- <small class="float-right">Date: <?= date('d/m/Y', strtotime($sale['created_at']))  ?></small> -->
                    </h2>
                </div>

            </div>

            <div class="row invoice-info">
                <!-- <div class="col-sm-4 invoice-col">
                        <address>
                            <strong>PT Inventory Barang</strong><br>
                            Banyumas, Indonesia<br>
                            Phone: (0281) 123-5432<br>
                        </address>
                    </div> -->

                <div class="col-sm-6 invoice-col">
                    Customer
                    <address>
                        <strong><?= $sale['customer_name'] ?></strong><br>
                        795 Folsom Ave, Suite 600<br>
                        Phone: (555) 539-1037<br>
                    </address>
                </div>

                <div class="col-sm-6 invoice-col">
                    <b>Invoice:</b> TRX-<?= str_pad($sale['id'], 5, "0", STR_PAD_LEFT);  ?><br>
                    <b>Tanggal:</b> <?= date('d/m/Y', strtotime($sale['created_at']))  ?><br>
                    <b>Admin:</b> Febri Sutomo<br>
                </div>

            </div>


            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Product</th>
                                <th>Serial #</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sale['items'] as $item) : ?>
                                <tr>
                                    <td><?= $item['qty'] ?></td>
                                    <td><?= $item['product_name'] ?></td>
                                    <td>BR-<?= str_pad($item['product_id'], 5, "0", STR_PAD_LEFT);  ?></td>
                                    <td><?= rupiah($item['sell_price']) ?></td>
                                    <td><?= rupiah($item['subtotal']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="row">

                <div class="col-6">
                    <!-- <p class="lead">Payment Methods:</p>
                        <img src="../../dist/img/credit/visa.png" alt="Visa">
                        <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                        <img src="../../dist/img/credit/american-express.png" alt="American Express">
                        <img src="../../dist/img/credit/paypal2.png" alt="Paypal">
                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
                            jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                        </p> -->
                </div>

                <div class="col-6">
                    <!-- <p class="lead">Amount Due <?= date('d/m/Y', strtotime($sale['created_at']))  ?></p> -->
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Total:</th>
                                <td><?= rupiah($sale['total']) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>


        </section>


    </div>


    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>