<?php 
include "include/header.php";  

 

$sql="SELECT * FROM `tbl_offer` WHERE `status` in ('1','2')";
$result=$conn->query($sql);

$sqlelectrician="SELECT `idtbl_electrician`, `name` FROM `tbl_electrician` WHERE `status` in (1,2)";
$resultelectrician =$conn-> query($sqlelectrician); 

; 

include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="briefcase"></i></div>
                            <span>Selected Electricians</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <form id="searchform" action="process/offerprocess.php" enctype="multipart/form-data"
                            method="post" autocomplete="off">
                            <div class="row">

                                <div class="col-md-4"> <label class="sm
                        
                          all font-weight-bold text-dark">From*</label>
                                    <input type="date" class="form-control form-control-sm" name="from"
                                        id="from" required></div>
                                <div class="col-md-4"> <label class="small font-weight-bold text-dark">To*</label>
                                    <input type="date" class="form-control form-control-sm" name="to"
                                        id="to" required></div>
                                <div class="col-md-4"> <button type = "button"class="btn btn-outline-primary btn-sm btnsearch" style = "margin-top : 30px" id="addbtn"
                                        data-toggle="modal" data-target="#modelform">
                                        <i class="fa fa-search"></i>&nbsp;Search
                                    </button>
                                    <input type="submit" class = "d-none" id = "hiddensubmit">
                                </div>

                            </div>
                        </form>

                        <div  id = "searchbody" class="row">


                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>

<!-- Model -->
<div class="modal fade" id="modalofferdetails" tabindex="-1" role="dialog" aria-labelledby="modelshow"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalviewtitle">Selected Electricians</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalbody"></div>
            </div>
        </div>
    </div>
</div>


</div>

<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function () {

        $('#dataTable').DataTable();

    });


    $('#searchform').on('click', '.btnsearch', function () {
        if (!$("#searchform")[0].checkValidity()) {
                $("#hiddensubmit").click();
        } else{
        var to = $('#to').val();
        var from = $('#from').val();

        $.ajax({
            type: "POST",
            data: {
                from: from,
                to: to,
            },
            url: 'getprocess/getsearcheddata.php',
            success: function (result) { //alert(result);

                $('#searchbody').html(result);
     
            }
        });
        }

    });
</script>
<?php include "include/footer.php"; ?>