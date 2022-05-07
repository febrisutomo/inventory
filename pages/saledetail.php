<?php

require_once 'db/Sale.php';

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


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- <div class="callout callout-info">
                <h5><i class="fas fa-info"></i> Note:</h5>
                This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div> -->

            <div class="invoice p-3 mb-3">

                <div class="row">
                    <div class="col-12">
                        <h2 class="page-header">
                            <i class="fas fa-shopping-cart"></i> KUITANSI PENJUALAN
                            <!-- <small class="float-right">Date: <?= date('d/m/Y',strtotime($sale['created_at']))  ?></small> -->
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
                        <b>Tanggal:</b> <?= date('d/m/Y',strtotime($sale['created_at']))  ?><br>
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
                        <!-- <p class="lead">Amount Due <?= date('d/m/Y',strtotime($sale['created_at']))  ?></p> -->
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


                <div class="row no-print">
                    <div class="col-12">
                        <a href="/saleslist" class="btn btn-default float-right">Kembali</a>
                        <a href="/print/sale.php?id=<?= $sale['id'] ?>" rel="noopener" target="_blank" class="btn btn-default float-right mr-2"><i class="fas fa-print"></i> Print</a>
                        <!-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                            Payment
                        </button>
                        <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                            <i class="fas fa-download"></i> Generate PDF
                        </button> -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
