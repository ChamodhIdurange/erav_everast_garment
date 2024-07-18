<?php
require_once('../connection/db.php');

$id = $_POST['id'];

$sql = "SELECT `d`.`idtbl_return_details`, `p`.`idtbl_product`, `p`.`product_name`, `d`.`unitprice`, `d`.`qty`, `d`.`discount`, `d`.`total` AS `return_total`, `i`.`total`, `d`.`tbl_invoice_idtblinvoice` FROM `tbl_return` as `r` LEFT JOIN `tbl_return_details` as `d` ON (`r`.`idtbl_return` = `d`.`tbl_return_idtbl_return`) LEFT JOIN `tbl_product` as `p` ON (`d`.`tbl_product_idtbl_product` = `p`.`idtbl_product`) LEFT JOIN `tbl_invoice` as `i` ON (`i`.`idtbl_invoice` = `d`.`tbl_invoice_idtblinvoice`) WHERE `d`.`tbl_return_idtbl_return` = '$id'";
$result = $conn->query($sql);


?>

<div class="row">
    <div class="col-12">
        <input type="hidden" id="hiddenID" name="hiddenID" value="<?php echo $record ?>">
        <table id="returndetailstable" class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    
                    <th>INV</th>
                    <th class="text-center">Inv. Total</th>
                    <th class="text-center">Rtn. Total</th>
                    <th class="text-center">Actions</th>

                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { 
                    $return_total_discount = $row['return_total'] * $row['discount'] /100 ;
                    $return_fulltotal = $row['return_total'] - $return_total_discount;
                    ?>
                    <tr>
                    
                        <td><?php echo $row['tbl_invoice_idtblinvoice'] ?></td>
                        <td><?php echo number_format($row['total'], 2)?></td>
                        <td class="d-none"><?php echo $row['total'] ?></td>
                        <td class="text-center"><?php echo number_format($return_fulltotal, 2)?></td>
                        <td class="d-none"><?php echo $return_fulltotal ?></td>

                        <td>
                            <div class="custom-control custom-checkbox"><input type="checkbox" class="form-check-input checkinvoice" id="<?php echo $row['idtbl_return_details']; ?>"></div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $('#qty').change(function() {
        // alert("asd")
        var qty = $("#qty").val();
        var unitprice = $("#unitprice").val();

        var sum = qty * unitprice;
        $("#total").val(sum);
    });

    $("#returndetailstable tr .testradio").on('change', function(e) {
        var row = $(this);
        $(this).closest("tr").find('td:eq(3)').text('');
        if ($(this).val() == 1) {
            var val = $(this).closest("tr").find('td:eq(2)').html();
            $(this).closest("tr").find('td:eq(3)').text(val);
        } else {
            var textbox = $('<input class = "actutalqty" type="text" id="foo" name="foo">');
            $(this).closest("tr").find('td:eq(3)').append(textbox);;
            textremove('.actutalqty', row);
        }

    });

    function textremove(classname, row) {
        $('#returndetailstable tbody').on('keyup', classname, function(e) {
            if (e.keyCode === 13) {
                var val = $(this).val();
                $(this).closest("tr").find('td:eq(3)').text(val);
            }
        });
    }

    $('#btnAddQty').click(function() { //alert('IN');
        var tbody = $("#returndetailstable tbody");

        if (tbody.children().length > 0) {
            jsonObj = [];
            $("#returndetailstable tbody tr").each(function() {
                item = {}
                $(this).find('td').each(function(col_idx) {
                    item["col_" + (col_idx + 1)] = $(this).text();
                });
                jsonObj.push(item);
            });
            // console.log(jsonObj);
            // alert(jsonObj);
            var hiddenID = $('#hiddenID').val();

            $.ajax({
                type: "POST",
                data: {
                    tableData: jsonObj,
                    recordID: hiddenID
                },
                url: 'process/qtyCheckProcess.php',
                success: function(result) {
                    //alert(result);

                    location.reload();
                }
            });
        }
    });
</script>