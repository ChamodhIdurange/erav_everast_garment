<?php

// specify optional header includes in this array.
$optional_header_includes = ['magnific-popup'];

include "include/header.php";  

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
                    <div class="page-header-content d-flex align-items-center justify-content-between py-3">
                        <div class="d-inline">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="trello"></i></div>
                                <span>Restrict Months</span>
                            </h1>
                        </div>
                        <button class="btn btn-sm btn-primary form-control-sm py-0 float-right d-none" type="button" data-toggle="modal" data-target="#addMainAccountModal"><i data-feather="plus-circle"></i>  Add Main Account</button>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <form class="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-sm mb-4">
                                        <label for="branch">Branch</label>
                                        <select class="form-control form-control-sm" id="branch" name="branch">
                                            <option value = "-2">select</option>
                                            <option value = "1">Branch01</option>
                                            <option value = "2">Branch02</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-sm mb-4">
                                        <label for="branch">Financial Year</label>
                                        <select class="form-control form-control-sm" id="financialyear" name="financialyear">
                                            <option value = "-2">select</option>
                                            <option value = "1">Year01</option>
                                            <option value = "2">Year02</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="mt-2">
                            <div class="table-responsive-sm w-100">
                                <table class="table table-sm table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Year</th>
                                            <th>Restrict</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>January</td>
                                            <td>2021</td>
                                            <td>
                                                <input type="checkbox" checked="checked" name="jan2021" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>March</td>
                                            <td>2021</td>
                                            <td>
                                                <input type="checkbox" name="mar2021" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="w-100 text-right mt-3">
                                    <button class="btn btn-primary btn-sm">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class="modal fade" id="addMainAccountModal" tabindex="-1" role="dialog" aria-labelledby="addSubClassModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMainAccountModalLabel">Add Main Account</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <form class="p-3 m-2" method="post">
                            <div class="form-group form-group-sm mb-4">
                                <label for="mainclassselect" >Main Class</label>
                                <select class="form-control form-control-sm" id="mainclassselect">
                                    <option value = "0">Select</option>
                                    <option value = "01">MainClass01</option>
                                    <option value = "02">MainClass02</option>
                                </select>
                            </div>
                            <div class="form-group form-group-sm mb-4">
                                <label for="subclassselect" >Sub Class</label>
                                <select class="form-control form-control-sm" id="subclassselect">
                                    <option value = "0">Select</option>
                                    <option value = "01">SubClass01</option>
                                    <option value = "02">SubClass02</option>
                                </select>
                            </div>
                            <div class="form-group form-group-sm mb-4">
                                <label for="codeinput" >Code</label>
                                <div class="input-group input-group-sm input-group-joined input-group-solid mb-4">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        0101
                                    </span>
                                    </div>
                                    <input class="form-control form-control-sm" id="code" minlength="4" maxlength="4" name="code" type="text" placeholder="Code" value="xxxx" aria-label="Search">
                                </div>
                            </div>
                            <div class="form-group form-group-sm mb-4">
                                <label for="nameinput" >Main Account Name</label>
                                <input class="form-control form-control-sm" type="text" id="nameinput" name="nameinput" value="MainAccount01" placeholder="Your Sub CLas Name">
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm form-control-sm btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-sm form-control-sm btn-primary"  data-dismiss="modal" onclick="alert('Data added')" type="button">Add New</button></div>
                </div>
            </div>
        </div>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
        $('.image-link').magnificPopup({type:'image'});
        $('#dataTable tbody').on('click', '.btnEdit', function() {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: 'getprocess/getcomponent.php',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);

                        $('#recordID').val(obj.id);
                        $('#style').val(obj.styleId);
                        $('#component').val(obj.component);
                        $('#description').val(obj.description);
                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');

                        $('#currentImage').attr('src','uploads/'+obj.imagepath);
                        $('.tower-file-details').removeClass('d-none');
                        $('#componentimage').removeAttr('required');

                    }
                });
            }
        });
    });


</script>

<?php

// specify optional header includes in this array.
$optional_footer_includes = ['magnific-popup'];

include "include/footer.php";
?>
