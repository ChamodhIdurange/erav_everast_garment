<?php 
require_once('../connection/db.php');

$productID=$_POST['productID'];

$sql="SELECT `imgpath` FROM `tbl_catalog` WHERE `idtbl_catalog`='$productID' AND `status`=1";
$result=$conn->query($sql);
?>
<table class="table table-striped table-bordered table-sm" id="productimagetable">
    <tbody>
        <?php while($row=$result->fetch_assoc()){ ?>
        <tr>
            <td>
                <img src="<?php echo $row['imgpath'] ?>" width="150" height="150">
            </td>
            <td class="text-center">
                <button class="btn btn-outline-danger btn-sm btnremoveimage mt-5" id="<?php echo $row['idtbl_catalog'] ?>"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>