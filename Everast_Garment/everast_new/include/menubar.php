<?php

use SebastianBergmann\Environment\Console;
$controllermenu = $this->router->fetch_class();
$functionmenu = uri_string();
$functionmenu2 = $this->router->fetch_method();
$menuprivilegearray = $menuaccess;

if ($functionmenu2 == 'Useraccount') {
    $addcheck = checkprivilege($menuprivilegearray, 1, 1);
    $editcheck = checkprivilege($menuprivilegearray, 1, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 1, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 1, 4);
} else if ($functionmenu2 == 'Usertype') {
    $addcheck = checkprivilege($menuprivilegearray, 2, 1);
    $editcheck = checkprivilege($menuprivilegearray, 2, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 2, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 2, 4);
} else if ($functionmenu2 == 'Userprivilege') {
    $addcheck = checkprivilege($menuprivilegearray, 3, 1);
    $editcheck = checkprivilege($menuprivilegearray, 3, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 3, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 3, 4);
} else if ($controllermenu == 'Supplier') {
    $addcheck = checkprivilege($menuprivilegearray, 4, 1);
    $editcheck = checkprivilege($menuprivilegearray, 4, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 4, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 4, 4);
} else if ($controllermenu == 'Customer') {
    $addcheck = checkprivilege($menuprivilegearray, 5, 1);
    $editcheck = checkprivilege($menuprivilegearray, 5, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 5, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 5, 4);
} else if ($controllermenu == 'Employee') {
    $addcheck = checkprivilege($menuprivilegearray, 6, 1);
    $editcheck = checkprivilege($menuprivilegearray, 6, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 6, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 6, 4);
} else if ($controllermenu == 'Location') {
    $addcheck = checkprivilege($menuprivilegearray, 7, 1);
    $editcheck = checkprivilege($menuprivilegearray, 7, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 7, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 7, 4);
} else if ($controllermenu == 'Suppliertype') {
    $addcheck = checkprivilege($menuprivilegearray, 8, 1);
    $editcheck = checkprivilege($menuprivilegearray, 8, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 8, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 8, 4);
} else if ($controllermenu == 'Reeltype') {
    $addcheck = checkprivilege($menuprivilegearray, 9, 1);
    $editcheck = checkprivilege($menuprivilegearray, 9, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 9, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 9, 4);
} else if ($controllermenu == 'Gsm') {
    $addcheck = checkprivilege($menuprivilegearray, 10, 1);
    $editcheck = checkprivilege($menuprivilegearray, 10, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 10, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 10, 4);
} else if ($controllermenu == 'Materialmaincategory') {
    $addcheck = checkprivilege($menuprivilegearray, 11, 1);
    $editcheck = checkprivilege($menuprivilegearray, 11, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 11, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 11, 4);
} else if ($controllermenu == 'Rowmaterials') {
    $addcheck = checkprivilege($menuprivilegearray, 12, 1);
    $editcheck = checkprivilege($menuprivilegearray, 12, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 12, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 12, 4);
} else if ($controllermenu == 'Measurements') {
    $addcheck = checkprivilege($menuprivilegearray, 13, 1);
    $editcheck = checkprivilege($menuprivilegearray, 13, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 13, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 13, 4);
} else if ($controllermenu == 'Mainitems') {
    $addcheck = checkprivilege($menuprivilegearray, 14, 1);
    $editcheck = checkprivilege($menuprivilegearray, 14, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 14, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 14, 4);
} else if ($controllermenu == 'Itemprofile') {
    $addcheck = checkprivilege($menuprivilegearray, 15, 1);
    $editcheck = checkprivilege($menuprivilegearray, 15, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 15, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 15, 4);
} else if ($controllermenu == 'Fliinformation') {
    $addcheck = checkprivilege($menuprivilegearray, 16, 1);
    $editcheck = checkprivilege($menuprivilegearray, 16, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 16, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 16, 4);
} else if ($controllermenu == 'Cuttype') {
    $addcheck = checkprivilege($menuprivilegearray, 17, 1);
    $editcheck = checkprivilege($menuprivilegearray, 17, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 17, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 17, 4);
} else if ($controllermenu == 'Machinetype') {
    $addcheck = checkprivilege($menuprivilegearray, 18, 1);
    $editcheck = checkprivilege($menuprivilegearray, 18, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 18, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 18, 4);
} else if ($controllermenu == 'Machine') {
    $addcheck = checkprivilege($menuprivilegearray, 19, 1);
    $editcheck = checkprivilege($menuprivilegearray, 19, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 19, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 19, 4);
} else if ($controllermenu == 'Customerinquiry') {
    $addcheck = checkprivilege($menuprivilegearray, 20, 1);
    $editcheck = checkprivilege($menuprivilegearray, 20, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 20, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 20, 4);
} else if ($controllermenu == 'Jobquotation') {
    $addcheck = checkprivilege($menuprivilegearray, 21, 1);
    $editcheck = checkprivilege($menuprivilegearray, 21, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 21, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 21, 4);
} else if ($controllermenu == 'Purchaseorder') {
    $addcheck = checkprivilege($menuprivilegearray, 22, 1);
    $editcheck = checkprivilege($menuprivilegearray, 22, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 22, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 22, 4);
} else if ($controllermenu == 'Goodreceive') {
    $addcheck = checkprivilege($menuprivilegearray, 23, 1);
    $editcheck = checkprivilege($menuprivilegearray, 23, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 23, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 23, 4);
} else if ($controllermenu == 'cartontype') {
    $addcheck = checkprivilege($menuprivilegearray, 24, 1);
    $editcheck = checkprivilege($menuprivilegearray, 24, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 24, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 24, 4);
} else if ($controllermenu == 'reelgrn') {
    $addcheck = checkprivilege($menuprivilegearray, 25, 1);
    $editcheck = checkprivilege($menuprivilegearray, 25, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 25, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 25, 4);
} else if ($controllermenu == 'Itemprice') {
    $addcheck = checkprivilege($menuprivilegearray, 26, 1);
    $editcheck = checkprivilege($menuprivilegearray, 26, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 26, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 26, 4);
} else if ($controllermenu == 'approved_inquiries') {
    $addcheck = checkprivilege($menuprivilegearray, 27, 1);
    $editcheck = checkprivilege($menuprivilegearray, 27, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 27, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 27, 4);
} else if ($controllermenu == 'colors') {
    $addcheck = checkprivilege($menuprivilegearray, 28, 1);
    $editcheck = checkprivilege($menuprivilegearray, 28, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 28, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 28, 4);
} else if ($controllermenu == 'Stocktransfer') {
    $addcheck = checkprivilege($menuprivilegearray, 29, 1);
    $editcheck = checkprivilege($menuprivilegearray, 29, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 29, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 29, 4);
} else if ($controllermenu == 'Allstockview') {
    $addcheck = checkprivilege($menuprivilegearray, 31, 1);
    $editcheck = checkprivilege($menuprivilegearray, 31, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 31, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 31, 4);
} else if ($controllermenu == 'materialavailability') {
    $addcheck = checkprivilege($menuprivilegearray, 33, 1);
    $editcheck = checkprivilege($menuprivilegearray, 33, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 33, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 33, 4);
} else if ($controllermenu == 'materialsissue') {
    $addcheck = checkprivilege($menuprivilegearray, 32, 1);
    $editcheck = checkprivilege($menuprivilegearray, 32, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 32, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 32, 4);
} else if ($controllermenu == 'Machinealloction') {
    $addcheck = checkprivilege($menuprivilegearray, 34, 1);
    $editcheck = checkprivilege($menuprivilegearray, 34, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 34, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 34, 4);
} else if ($controllermenu == 'AllocatedMachines') {
    $addcheck = checkprivilege($menuprivilegearray, 35, 1);
    $editcheck = checkprivilege($menuprivilegearray, 35, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 35, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 35, 4);
} else if ($controllermenu == 'Reelstockview') {
    $addcheck = checkprivilege($menuprivilegearray, 36, 1);
    $editcheck = checkprivilege($menuprivilegearray, 36, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 36, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 36, 4);
} else if ($controllermenu == 'ReelIn') {
    $addcheck = checkprivilege($menuprivilegearray, 37, 1);
    $editcheck = checkprivilege($menuprivilegearray, 37, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 37, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 37, 4);
} else if ($controllermenu == 'MaterialIssueReport') {
    $addcheck = checkprivilege($menuprivilegearray, 38, 1);
    $editcheck = checkprivilege($menuprivilegearray, 38, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 38, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 38, 4);
} else if ($controllermenu == 'StockReport') {
    $addcheck = checkprivilege($menuprivilegearray, 39, 1);
    $editcheck = checkprivilege($menuprivilegearray, 39, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 39, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 39, 4);
} else if ($functionmenu == 'SpareParts') {
    $addcheck = checkprivilege($menuprivilegearray, 40, 1);
    $editcheck = checkprivilege($menuprivilegearray, 40, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 40, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 40, 4);
} else if ($functionmenu == 'MachineRepairRequests') {
    $addcheck = checkprivilege($menuprivilegearray, 41, 1);
    $editcheck = checkprivilege($menuprivilegearray, 41, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 41, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 41, 4);
}
else if ($functionmenu == 'MachineService') {
    $addcheck = checkprivilege($menuprivilegearray, 42, 1);
    $editcheck = checkprivilege($menuprivilegearray, 42, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 42, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 42, 4);
} 
else if ($functionmenu2 == 'allocate') {
    $addcheck = checkprivilege($menuprivilegearray, 43, 1);
    $editcheck = checkprivilege($menuprivilegearray, 43, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 43, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 43, 4);
} 
else if ($functionmenu2 == 'issue') {
    $addcheck = checkprivilege($menuprivilegearray, 44, 1);
    $editcheck = checkprivilege($menuprivilegearray, 44, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 44, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 44, 4);
} 
else if ($functionmenu2 == 'receive') {
    $addcheck = checkprivilege($menuprivilegearray, 45, 1);
    $editcheck = checkprivilege($menuprivilegearray, 45, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 45, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 45, 4);
} 
else if ($functionmenu == 'MachineServicesCalendar') {
    $addcheck = checkprivilege($menuprivilegearray, 46, 1);
    $editcheck = checkprivilege($menuprivilegearray, 46, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 46, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 46, 4);
} else if ($functionmenu == 'MachineIn') {
    $addcheck = checkprivilege($menuprivilegearray, 47, 1);
    $editcheck = checkprivilege($menuprivilegearray, 47, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 47, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 47, 4);
} 
function checkprivilege($arraymenu, $menuID, $type)
{
    foreach ($arraymenu as $array) {
        if ($array->menuid == $menuID) {
            if ($type == 1) {
                return $array->add;
            } else if ($type == 2) {
                return $array->edit;
            } else if ($type == 3) {
                return $array->statuschange;
            } else if ($type == 4) {
                return $array->remove;
            }
        }
    }
}
?>
<textarea class="d-none" id="actiontext"><?php if ($this->session->flashdata('msg')) {
    echo $this->session->flashdata('msg');
} ?></textarea>

<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <div class="sidenav-menu-heading">Core</div>
            <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url() . 'Welcome/Dashboard'; ?>">
                <div class="nav-link-icon"><i class="fas fa-desktop"></i></div>
                Dashboard
            </a>

            <?php if (menucheck($menuprivilegearray, 4) == 1 | menucheck($menuprivilegearray, 5) == 1 | menucheck($menuprivilegearray, 6) == 1 | menucheck($menuprivilegearray, 7) == 1 | menucheck($menuprivilegearray, 8) == 1 | menucheck($menuprivilegearray, 9) == 1 | menucheck($menuprivilegearray, 10) == 1 | menucheck($menuprivilegearray, 13) == 1 | menucheck($menuprivilegearray, 28) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                    data-target="#collapsemaster" aria-expanded="false" aria-controls="collapsemaster">
                    <div class="nav-link-icon"><i class="fa fa-shopping-bag"></i></div>
                    Master Files
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($functionmenu == "Supplier" | $functionmenu == "Customer" | $functionmenu == "Employee" | $functionmenu == "Location" | $functionmenu == "Suppliertype" | $functionmenu == "Reeltype" | $functionmenu == "Gsm" | $functionmenu == "Measurements" | $functionmenu == "cartontype" | $functionmenu == "colors") {
                    echo 'show';
                } ?>" id="collapsemaster" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php if (menucheck($menuprivilegearray, 4) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'Supplier'; ?>">Suppliers</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 5) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'Customer'; ?>">Customers</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 6) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'Employee'; ?>">Employees</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 7) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'Location'; ?>">Location</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 8) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'Suppliertype'; ?>">Supplier
                                Type</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 9) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Reeltype'; ?>">Reel
                                Type</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 10) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Gsm'; ?>">GSM</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 13) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'Measurements'; ?>">Measurments</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 24) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'cartontype'; ?>">Carton
                                Type</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 28) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Color'; ?>">Colors
                            </a>
                        <?php }

                        ?>
                    </nav>
                </div>
            <?php }
            if (menucheck($menuprivilegearray, 11) == 1 | menucheck($menuprivilegearray, 12) == 1 | menucheck($menuprivilegearray, 16) == 1 | menucheck($menuprivilegearray, 17) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                    data-target="#collapsematerial" aria-expanded="false" aria-controls="collapsematerial">
                    <div class="nav-link-icon"><i class="fa fa-cogs"></i></div>
                    Material Data
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($functionmenu == "Materialmaincategory" | $functionmenu == "Rowmaterials" | $functionmenu == "Fliinformation" | $functionmenu == "Cuttype") {
                    echo 'show';
                } ?>" id="collapsematerial" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php if (menucheck($menuprivilegearray, 11) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'Materialmaincategory'; ?>">Material Main Category</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 12) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Rowmaterials'; ?>">Row
                                Materials</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 16) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Fliinformation'; ?>">Fli
                                Information</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 17) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Cuttype'; ?>">Flute
                                Type</a>
                        <?php } ?>
                    </nav>
                </div>
            <?php }
            if (menucheck($menuprivilegearray, 18) == 1 | menucheck($menuprivilegearray, 19) == 1 |menucheck($menuprivilegearray, 47)==1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                    data-target="#collapsemachine" aria-expanded="false" aria-controls="collapsemachine">
                    <div class="nav-link-icon"><i class="fa fa-cubes"></i></div>
                    Machine Data
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($functionmenu == "Machinetype" | $functionmenu == "Machine" |$controllermenu=="MachineIn") {
                    echo 'show'; 
                } ?>" id="collapsemachine" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php if (menucheck($menuprivilegearray, 18) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Machinetype'; ?>">Machine
                                Type</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 19) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'Machine'; ?>">Machines</a>
                        <?php } 
                        if(menucheck($menuprivilegearray, 47)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'MachineIn'; ?>">Machine In</a>
                    <?php }
                        
                        ?>
                    </nav>
                </div>
            <?php }
            if (menucheck($menuprivilegearray, 14) == 1 | menucheck($menuprivilegearray, 15) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                    data-target="#collapsemainitem" aria-expanded="false" aria-controls="collapsemainitem">
                    <div class="nav-link-icon"><i class="fa fa-cubes"></i></div>
                    Item Data
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($functionmenu == "Mainitems" | $functionmenu == "Itemprofile") {
                    echo 'show';
                } ?>" id="collapsemainitem" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php if (menucheck($menuprivilegearray, 14) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Mainitems'; ?>">Main
                                Items</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 15) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Itemprofile'; ?>">Item
                                Profiles</a>
                        <?php } ?>
                    </nav>
                </div>
                <!-- Delete Item Menu New Added -->
            <?php }
            if (menucheck($menuprivilegearray, 20) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                    data-target="#collapseCustomerInquiry" aria-expanded="false" aria-controls="collapseCustomerInquiry">
                    <div class="nav-link-icon"><i class="fas fa-search-dollar"></i></div>
                    Customer Inquiry
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($functionmenu == 'Customerinquiry' | $functionmenu == 'Itemprice' | $functionmenu == 'Approve_inquiries') {
                    echo 'show';
                } ?>" id="collapseCustomerInquiry" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php if (menucheck($menuprivilegearray, 20) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Customerinquiry'; ?>">
                                Customer Inquiry Create
                            </a>
                        <?php } ?>

                        <?php if (menucheck($menuprivilegearray, 27) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Approve_inquiries'; ?>">
                                Approved Inquiries
                            </a>
                        <?php } ?>
                        <?php if (menucheck($menuprivilegearray, 20) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Itemprice'; ?>">
                                Price to Inquiry item

                            </a>
                        <?php } ?>


                    </nav>
                </div>
            <?php }
            if (menucheck($menuprivilegearray, 21) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url() . 'Jobquotation'; ?>">
                    <div class="nav-link-icon"><i class="fas fa-search-dollar"></i></div>
                    Job Quotation
                </a>
            <?php }
            if (menucheck($menuprivilegearray, 22) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url() . 'Purchaseorder'; ?>">
                    <div class="nav-link-icon"><i class="fas fa-search-dollar"></i></div>
                    Supplier Purchase Order
                </a>
            <?php }
            if (menucheck($menuprivilegearray, 30) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url() . 'Customerporder'; ?>">
                    <div class="nav-link-icon"><i class="fas fa-search-dollar"></i></div>
                    Customer Purchase Order
                </a>
            <?php }

            if (menucheck($menuprivilegearray, 23) == 1 | menucheck($menuprivilegearray, 25) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                    data-target="#goodReceiveSubmenu" aria-expanded="false" aria-controls="goodReceiveSubmenu">
                    <div class="nav-link-icon"><i class="fa fa-cubes"></i></div>
                    Good Recieve
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($functionmenu == "Goodreceive" | $functionmenu == "reelgrn") {
                    echo 'show';
                } ?>" id="goodReceiveSubmenu" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php if (menucheck($menuprivilegearray, 23) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Goodreceive'; ?>">Good
                                Receive Note</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 25) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'reelgrn'; ?>">Reel data
                                add
                            </a>
                        <?php }
                        ?>
                    </nav>
                </div>
                <!-- Delete Item Menu New Added -->
            <?php }

            if (menucheck($menuprivilegearray, 29) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url() . 'Stocktransfer'; ?>">
                    <div class="nav-link-icon"><i class="fas fa-exchange-alt"></i></div>
                    Stock Transfer
                </a>
            <?php }


            if (menucheck($menuprivilegearray, 31) == 1 | menucheck($menuprivilegearray, 33) == 1 | menucheck($menuprivilegearray, 32) == 1 | menucheck($menuprivilegearray, 35) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                    data-target="#collapsematerialavailability" aria-expanded="false"
                    aria-controls="collapsematerialavailability">
                    <div class="nav-link-icon"><i class="fa fa-cubes"></i></div>
                    Stock Management
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($functionmenu == "Allstockview" | $functionmenu == "materialavailability" | $functionmenu == "materialsissue" | $functionmenu == "Reelstockview") {
                    echo 'show';
                } ?>" id="collapsematerialavailability" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php
                        if (menucheck($menuprivilegearray, 31) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Allstockview'; ?>">
                                All Material Stock </a>
                        <?php }
                        if (menucheck($menuprivilegearray, 35) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'Reelstockview'; ?>">
                                Reel Stock </a>
                        <?php }
                        if (menucheck($menuprivilegearray, 33) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-2 text-dark"
                                href="<?php echo base_url() . 'materialavailability'; ?>">
                                Material Availability
                            </a>
                        <?php }
                        if (menucheck($menuprivilegearray, 32) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url() . 'materialsissue'; ?>">
                                Materials Issue
                            </a>
                        <?php }
                        ?>
                    </nav>
                </div>
            <?php }
            if (menucheck($menuprivilegearray, 34) == 1 | menucheck($menuprivilegearray, 35) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                    data-target="#collapseMachinealloction" aria-expanded="false" aria-controls="collapseMachinealloction">
                    <div class="nav-link-icon"><i class="fa fa-cubes"></i></div>
                    Machine Allocation
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($functionmenu == "AllocatedMachines" | $functionmenu == "Machinealloction") {
                    echo 'show';
                } ?>" id="collapseMachinealloction" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php

                        if (menucheck($menuprivilegearray, 34) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'Machinealloction'; ?>">Machine Allocation</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 35) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'AllocatedMachines'; ?>">Allocated Machines</a>
                        <?php }
                        ?>
                    </nav>
                </div>
            <?php }
            if (menucheck($menuprivilegearray, 40) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url() . 'SpareParts'; ?>">
                    <div class="nav-link-icon"><i class="fas fa-tools"></i></div>
                    Spare Parts
                </a>
            <?php }

            if(menucheck($menuprivilegearray, 42)==1 | menucheck($menuprivilegearray, 43)==1 | menucheck($menuprivilegearray, 44)==1 | menucheck($menuprivilegearray, 45)==1 | menucheck($menuprivilegearray, 46)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseMachineServices">
                <div class="nav-link-icon"><i class="fas fa-wrench"></i></div>
                Machine Services
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($controllermenu=="MachineService" | $controllermenu=="allocate" | $controllermenu=="issue" | $controllermenu=="receive" | $controllermenu=="MachineServicesCalendar"){echo 'show';} ?>" id="collapseMachineServices" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav">
                    <?php if(menucheck($menuprivilegearray, 42)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'MachineService'; ?>">Machine Service</a>
                    <?php } if(menucheck($menuprivilegearray, 43)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'MachineService/allocate'; ?>">Service Item Allocate</a>
                    <?php } if(menucheck($menuprivilegearray, 44)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'MachineService/issue'; ?>">Service Item Issue</a>
                    <?php } if(menucheck($menuprivilegearray, 45)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'MachineService/receive'; ?>">Service Item Receive</a>
                    <?php } if(menucheck($menuprivilegearray, 46)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url().'MachineServicesCalendar'; ?>">Service Calendar</a>
                    <?php } ?>
                </nav>
            </div>
            <?php }

            if(menucheck($menuprivilegearray, 41)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-dark" href="<?php echo base_url().'MachineRepairRequests'; ?>">
                <div class="nav-link-icon"><i class="fas fa-tools"></i></div>
                Machine Repairs
            </a>
            <?php }

            if (menucheck($menuprivilegearray, 37) == 1 | menucheck($menuprivilegearray, 38) == 1 | menucheck($menuprivilegearray, 39) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                    data-target="#collapseReport" aria-expanded="false" aria-controls="collapseReport">
                    <div class="nav-link-icon"><i class="fa fa-cubes"></i></div>
                    Reports
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($functionmenu == "ReelIn" | $functionmenu == "MaterialIssueReport" | $functionmenu == "StockReport") {
                    echo 'show';
                } ?>" id="collapseReport" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php

                        if (menucheck($menuprivilegearray, 37) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark" href="<?php echo base_url() . 'ReelIn'; ?>">Reel In</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 38) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'MaterialIssueReport'; ?>">Material Issue</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 39) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'StockReport'; ?>">Stock</a>
                        <?php }
                        ?>
                    </nav>
                </div>
            <?php }
            if (menucheck($menuprivilegearray, 1) == 1 | menucheck($menuprivilegearray, 2) == 1 | menucheck($menuprivilegearray, 3) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed text-dark" href="javascript:void(0);" data-toggle="collapse"
                    data-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
                    <div class="nav-link-icon"><i class="fas fa-user"></i></div>
                    User Account
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($functionmenu == "Useraccount" | $functionmenu == "Usertype" | $functionmenu == "Userprivilege") {
                    echo 'show';
                } ?>" id="collapseUser" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php if (menucheck($menuprivilegearray, 1) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'User/Useraccount'; ?>">User
                                Account</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 2) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'User/Usertype'; ?>">Type</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 3) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1 text-dark"
                                href="<?php echo base_url() . 'User/Userprivilege'; ?>">Privilege</a>
                        <?php } ?>
                    </nav>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title"><?php echo ucfirst($_SESSION['name']); ?></div>
        </div>
    </div>
</nav>