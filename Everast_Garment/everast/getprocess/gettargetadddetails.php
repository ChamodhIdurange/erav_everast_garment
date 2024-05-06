<?php 
require_once('../connection/db.php');

if(!empty($_POST['categoryID'])){
    $categoryID=$_POST['categoryID'];


    $sql="SELECT `p`.`idtbl_product`, `p`.`product_name` FROM `tbl_product_category` as `c` JOIN `tbl_product` as `p` ON (`p`.`tbl_product_category_idtbl_product_category` = `c`.`idtbl_product_category`) WHERE `p`.`status`=1 AND `c`.`idtbl_product_category` = '$categoryID'";
    $result =$conn-> query($sql); 

}

?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="selectAll" name="selectAll">
                    <label class="form-check-label" for="flexCheckDefault">
                        Check All
                    </label>
                </div>
            </div>
            <div class="col-md-6">

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Default qty" value="0" id="defaultqty"
                        name="defaultqty">

                </div>
            </div>
        </div>
        <table class="table table-striped table-bordered table-sm" id="paymentDetailTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Select</th>
                    <th>Product</th>
                    <th>Qty</th>

                </tr>
            </thead>
            <tbody id="detailsbody">
                <?php while($row=$result->fetch_assoc()){ ?>
                <tr>
                    <td><?php echo $row['idtbl_product']; ?></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input selectcheckbox" type="checkbox" value="1" id="">
                        </div>
                    </td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td id="targetqty">0</td>


                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="form-group mt-2">
            <button type="button" id="addButton" class="btn btn-outline-primary btn-sm px-4 fa-pull-right"><i
                    class="far fa-save"></i>&nbsp;Add</button>
        </div>
    </div>

</div>

<script>
    $("#paymentDetailTable tr .selectcheckbox").on('change', function (e) {
        var row = $(this);

        // $(this).closest("tr").find('td:eq(3)').text('');
        if ($(this).prop('checked') == true) {
            var textbox = $('<input class = "actutalqty" type="text" id="foo" name="foo">');
            $(this).closest("tr").find('td:eq(3)').append(textbox);;
            textremove('.actutalqty', row);
            $(this).val("2")
        } else {
            // var val = $(this).closest("tr").find('td:eq(2)').html();
            // $(this).closest("tr").find('td:eq(3)').text(val);
            var val = $("#defaultqty").val();
            $(this).closest("tr").find('td:eq(3)').text(val);

            $(this).val("1")

        }

    });

    function textremove(classname, row) {
        $('#paymentDetailTable tbody').on('keyup', classname, function (e) {
            if (e.keyCode === 13) {
                var val = $(this).val();
                $(this).closest("tr").find('td:eq(3)').text(val);
            }
        });
    }

    $("#addButton").click(function () {
        if (!$("#targetform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#submitBtn").click();
        } else {
            var i = 1;

            $("#paymentDetailTable tr").each(function () {

                if (i == 1) {
                    i = 2;
                } else {
                    var $chkbox = $(this).find('input[type="checkbox"]');

                    if ($chkbox.prop('checked') == true) {
                        productID = $(this).closest("tr").find('td:eq(0)').html();
                        productName = $(this).closest("tr").find('td:eq(2)').html();
                        qty = parseFloat($(this).closest("tr").find('td:eq(3)').html());
                        // console.log(sum2)
                        console.log(productID)
                        console.log(productName)
                        console.log(qty)

                        $('#selecteddetailtable > tbody:last').append(
                            '<tr class="pointer"><td class="d-none">' + productID +
                            '</td><td>' + productName + '</td><td>' + qty + '</td></tr>');
                    }
                }

            });

            $("#detailsbody").empty();
            $('#defaultqty').val('');
            $('#selectAll').prop('checked', false)



        }
    });

    $("#selectAll").click(function () {
        if (this.checked) {
            $('.selectcheckbox').each(function () {
                defaultqty = $('#defaultqty').val();
                $(".selectcheckbox").prop('checked', true);
                $("#paymentDetailTable tr").each(function () {
                    $(this).closest("tr").find('td:eq(3)').html(defaultqty)
                });
                // $('#paymentDetailTable td').eq(3).html('new content');
            })
        } else {
            $('.selectcheckbox').each(function () {
                $(".selectcheckbox").prop('checked', false);
            })
        }
    });

    $("#defaultqty").change(function () {
        defaultqty = $('#defaultqty').val();
        $("#paymentDetailTable tr").each(function () {
            $(this).closest("tr").find('td:eq(3)').html(defaultqty)
        });

    });
</script>