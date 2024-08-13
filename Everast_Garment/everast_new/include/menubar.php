<?php
$getUrl = $_SERVER['SCRIPT_NAME'];
$url = explode('/', $getUrl);
$lastElement = end($url);

if ($lastElement == 'useraccount.php') {
    $addcheck = checkprivilege($menuprivilegearray, 1, 1);
    $editcheck = checkprivilege($menuprivilegearray, 1, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 1, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 1, 4);
} else if ($lastElement == 'usertype.php') {
    $addcheck = checkprivilege($menuprivilegearray, 2, 1);
    $editcheck = checkprivilege($menuprivilegearray, 2, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 2, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 2, 4);
} else if ($lastElement == 'userprivilege.php') {
    $addcheck = checkprivilege($menuprivilegearray, 3, 1);
    $editcheck = checkprivilege($menuprivilegearray, 3, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 3, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 3, 4);
} else if ($lastElement == 'location.php') {
    $addcheck = checkprivilege($menuprivilegearray, 4, 1);
    $editcheck = checkprivilege($menuprivilegearray, 4, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 4, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 4, 4);
}  else if ($lastElement == 'productcatalog.php') {
    $addcheck = checkprivilege($menuprivilegearray, 5, 1);
    $editcheck = checkprivilege($menuprivilegearray, 5, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 5, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 5, 4);
} else if ($lastElement == 'catalogcategoies.php') {
    $addcheck = checkprivilege($menuprivilegearray, 6, 1);
    $editcheck = checkprivilege($menuprivilegearray, 6, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 6, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 6, 4);
} else if ($lastElement == 'customer.php') {
    $addcheck = checkprivilege($menuprivilegearray, 7, 1);
    $editcheck = checkprivilege($menuprivilegearray, 7, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 7, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 7, 4);
} else if ($lastElement == 'supplier.php') {
    $addcheck = checkprivilege($menuprivilegearray, 8, 1);
    $editcheck = checkprivilege($menuprivilegearray, 8, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 8, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 8, 4);
} else if ($lastElement == 'product.php') {
    $addcheck = checkprivilege($menuprivilegearray, 9, 1);
    $editcheck = checkprivilege($menuprivilegearray, 9, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 9, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 9, 4);
} else if ($lastElement == 'productcategory.php') {
    $addcheck = checkprivilege($menuprivilegearray, 10, 1);
    $editcheck = checkprivilege($menuprivilegearray, 10, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 10, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 10, 4);
} else if ($lastElement == 'groupcategory.php') {
    $addcheck = checkprivilege($menuprivilegearray, 11, 1);
    $editcheck = checkprivilege($menuprivilegearray, 11, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 11, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 11, 4);
} else if ($lastElement == 'subproductcategory.php') {
    $addcheck = checkprivilege($menuprivilegearray, 12, 1);
    $editcheck = checkprivilege($menuprivilegearray, 12, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 12, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 12, 4);
} else if ($lastElement == 'sizecategories.php') {
    $addcheck = checkprivilege($menuprivilegearray, 13, 1);
    $editcheck = checkprivilege($menuprivilegearray, 13, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 13, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 13, 4);
} else if ($lastElement == 'sizematrix.php') {
    $addcheck = checkprivilege($menuprivilegearray, 14, 1);
    $editcheck = checkprivilege($menuprivilegearray, 14, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 14, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 14, 4);
} else if ($lastElement == 'porder.php') {
    $addcheck = checkprivilege($menuprivilegearray, 15, 1);
    $editcheck = checkprivilege($menuprivilegearray, 15, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 15, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 15, 4);
} else if ($lastElement == 'grn.php') {
    $addcheck = checkprivilege($menuprivilegearray, 16, 1);
    $editcheck = checkprivilege($menuprivilegearray, 16, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 16, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 16, 4);
}  else if ($lastElement == 'customerporder.php') {
    $addcheck = checkprivilege($menuprivilegearray, 17, 1);
    $editcheck = checkprivilege($menuprivilegearray, 17, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 17, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 17, 4);
} else if ($lastElement == 'invoiceview.php') {
    $addcheck = checkprivilege($menuprivilegearray, 18, 1);
    $editcheck = checkprivilege($menuprivilegearray, 18, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 18, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 18, 4);
} else if ($lastElement == 'invoicepayment.php') {
    $addcheck = checkprivilege($menuprivilegearray, 19, 1);
    $editcheck = checkprivilege($menuprivilegearray, 19, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 19, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 19, 4);
} else if ($lastElement == 'invoicerecovery.php') {
    $addcheck = checkprivilege($menuprivilegearray, 20, 1);
    $editcheck = checkprivilege($menuprivilegearray, 20, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 20, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 20, 4);
} else if ($lastElement == 'paymentreceipt.php') {
    $addcheck = checkprivilege($menuprivilegearray, 21, 1);
    $editcheck = checkprivilege($menuprivilegearray, 21, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 21, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 21, 4);
} else if ($lastElement == 'cancelledinvoice.php') {
    $addcheck = checkprivilege($menuprivilegearray, 22, 1);
    $editcheck = checkprivilege($menuprivilegearray, 22, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 22, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 22, 4);
} else if ($lastElement == 'productreturn.php') {
    $addcheck = checkprivilege($menuprivilegearray, 23, 1);
    $editcheck = checkprivilege($menuprivilegearray, 23, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 23, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 23, 4);
} else if ($lastElement == 'customerreturn.php') {
    $addcheck = checkprivilege($menuprivilegearray, 24, 1);
    $editcheck = checkprivilege($menuprivilegearray, 24, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 24, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 24, 4);
} else if ($lastElement == 'supplierreturn.php') {
    $addcheck = checkprivilege($menuprivilegearray, 25, 1);
    $editcheck = checkprivilege($menuprivilegearray, 25, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 25, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 25, 4);
} else if ($lastElement == 'damagereturns.php') {
    $addcheck = checkprivilege($menuprivilegearray, 26, 1);
    $editcheck = checkprivilege($menuprivilegearray, 26, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 26, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 26, 4);
} else if ($lastElement == 'employee.php') {
    $addcheck = checkprivilege($menuprivilegearray, 27, 1);
    $editcheck = checkprivilege($menuprivilegearray, 27, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 27, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 27, 4);
} else if ($lastElement == 'area.php') {
    $addcheck = checkprivilege($menuprivilegearray, 28, 1);
    $editcheck = checkprivilege($menuprivilegearray, 28, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 28, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 28, 4);
}  else if ($lastElement == 'company.php') {
    $addcheck = checkprivilege($menuprivilegearray, 29, 1);
    $editcheck = checkprivilege($menuprivilegearray, 29, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 29, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 29, 4);
}  else if ($lastElement == 'companybranch.php') {
    $addcheck = checkprivilege($menuprivilegearray, 30, 1);
    $editcheck = checkprivilege($menuprivilegearray, 30, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 30, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 30, 4);
} else if ($lastElement == 'stock.php') {
    $addcheck = checkprivilege($menuprivilegearray, 31, 1);
    $editcheck = checkprivilege($menuprivilegearray, 31, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 31, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 31, 4);
} else if ($lastElement == 'bincard.php') {
    $addcheck = checkprivilege($menuprivilegearray, 32, 1);
    $editcheck = checkprivilege($menuprivilegearray, 32, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 32, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 32, 4);
} else if ($lastElement == 'customeroutstanding.php') {
    $addcheck = checkprivilege($menuprivilegearray, 33, 1);
    $editcheck = checkprivilege($menuprivilegearray, 33, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 33, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 33, 4);
} else if ($lastElement == 'dailysale.php') {
    $addcheck = checkprivilege($menuprivilegearray, 34, 1);
    $editcheck = checkprivilege($menuprivilegearray, 34, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 34, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 34, 4);
} else if ($lastElement == 'dailycash.php') {
    $addcheck = checkprivilege($menuprivilegearray, 35, 1);
    $editcheck = checkprivilege($menuprivilegearray, 35, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 35, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 35, 4);
} else if ($lastElement == 'salereportcustomer.php') {
    $addcheck = checkprivilege($menuprivilegearray, 36, 1);
    $editcheck = checkprivilege($menuprivilegearray, 36, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 36, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 36, 4);
} else if ($lastElement == 'salereportproduct.php') {
    $addcheck = checkprivilege($menuprivilegearray, 37, 1);
    $editcheck = checkprivilege($menuprivilegearray, 37, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 37, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 37, 4);
} else if ($lastElement == 'bufferstockmaintainreport.php') {
    $addcheck = checkprivilege($menuprivilegearray, 38, 1);
    $editcheck = checkprivilege($menuprivilegearray, 38, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 38, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 38, 4);
} else if ($lastElement == 'ouritemrange.php') {
    $addcheck = checkprivilege($menuprivilegearray, 39, 1);
    $editcheck = checkprivilege($menuprivilegearray, 39, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 39, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 39, 4);
} else if ($lastElement == 'vatinfo.php') {
    $addcheck = checkprivilege($menuprivilegearray, 40, 1);
    $editcheck = checkprivilege($menuprivilegearray, 40, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 40, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 40, 4);
} else if ($lastElement == 'accountpettycashreimburse.php') {
    $addcheck = checkprivilege($menuprivilegearray, 41, 1);
    $editcheck = checkprivilege($menuprivilegearray, 41, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 41, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 41, 4);
} else if ($lastElement == 'accountpettycashexpenses.php') {
    $addcheck = checkprivilege($menuprivilegearray, 42, 1);
    $editcheck = checkprivilege($menuprivilegearray, 42, 2);
    $statuscheck = checkprivilege($menuprivilegearray, 42, 3);
    $deletecheck = checkprivilege($menuprivilegearray, 42, 4);
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
<textarea class="d-none" id="actiontext"><?php echo $actionJSON; ?></textarea>
<input type="hidden" id="userType" value="<?php echo $_SESSION['type']; ?>">
<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <div class="sidenav-menu-heading">Core</div>
            <a class="nav-link p-0 px-3 py-2" href="dashboardtable.php">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Dashboard
            </a>
            <!-- Added by Chamodh-->
            <a class="nav-link p-0 px-3 py-2" href="locations.php">
                <div class="nav-link-icon"><i data-feather="map-pin"></i></div>
                <?php if (menucheck($menuprivilegearray, 4) == 1) { ?>
                    Locations
            </a>
            <?php }
                if (menucheck($menuprivilegearray, 7) == 1 | menucheck($menuprivilegearray, 8) == 1 | menucheck($menuprivilegearray, 27) == 1 | menucheck($menuprivilegearray, 28) == 1 | menucheck($menuprivilegearray, 29) == 1 | menucheck($menuprivilegearray, 30) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapsemasterdata" aria-expanded="false" aria-controls="collapsemasterdata">
                    <div class="nav-link-icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                    Master Data
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($lastElement == "supplier.php" | $lastElement == "customer.php" | $lastElement == "employee.php" | $lastElement == "area.php" | $lastElement == "company.php" | $lastElement == "companybranch.php") {echo 'show';} ?>" id="collapsemasterdata" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php if (menucheck($menuprivilegearray, 8) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="customer.php">Customer</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 7) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="supplier.php">Supplier</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 27) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="employee.php">Employee</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 28) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="area.php">Area</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 29) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="company.php">Company</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 30) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="companybranch.php">Company Branch</a>
                        <?php } ?>
                    </nav>
                </div>
            <?php }
                if (menucheck($menuprivilegearray, 9) == 1 | menucheck($menuprivilegearray, 10) == 1 | menucheck($menuprivilegearray, 11) == 1 | menucheck($menuprivilegearray, 12) == 1 | menucheck($menuprivilegearray, 13) == 1 | menucheck($menuprivilegearray, 14) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseproductdata" aria-expanded="false" aria-controls="collapseproductdata">
                    <div class="nav-link-icon"><i data-feather="shopping-cart" aria-hidden="true"></i></div>
                    Product Data
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($lastElement == "product.php" | $lastElement == "productcategory.php" | $lastElement == "groupcategory.php" | $lastElement == "subproductcategory.php" | $lastElement == "sizecategories.php" | $lastElement == "sizematrix.php") {echo 'show';} ?>" id="collapseproductdata" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php if (menucheck($menuprivilegearray, 9) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="product.php">Product</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 10) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="productcategory.php">Category</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 11) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="groupcategory.php">Group Category</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 12) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="subproductcategory.php">Sub Category</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 13) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="sizecategories.php">Size Categories</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 14) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="sizematrix.php">Size Matrix</a>
                        <?php } ?>
                    </nav>
                </div>
            <?php }
                if (menucheck($menuprivilegearray, 5) == 1 | menucheck($menuprivilegearray, 6) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseproductcatalog" aria-expanded="false" aria-controls="collapseproductcatalog">
                    <div class="nav-link-icon"><i class="fa fa-puzzle-piece" aria-hidden="true"></i></div>
                    Product Catalog
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($lastElement == "productcatalog.php" | $lastElement == "catalogcategoies.php") {echo 'show';} ?>" id="collapseproductcatalog" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php if (menucheck($menuprivilegearray, 6) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="catalogcategoies.php">Categories</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 5) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="productcatalog.php">Catalog Display</a>
                        <?php } ?>
                    </nav>
                </div>
                <?php }
                if (menucheck($menuprivilegearray, 15) == 1) { ?>
                    <a class="nav-link p-0 px-3 py-2" href="porder.php">
                        <div class="nav-link-icon"><i data-feather="archive"></i></div>
                        Purchsing Order
                    </a>
                <?php }
                        if (menucheck($menuprivilegearray, 16) == 1) { ?>
                    <a class="nav-link p-0 px-3 py-2" href="grn.php">
                        <div class="nav-link-icon"><i data-feather="truck"></i></div>
                        Good Receive
                    </a>
                <?php }
                    if (menucheck($menuprivilegearray, 40) == 1) { ?>
                    <a class="nav-link p-0 px-3 py-2" href="vatinfo.php">
                        <div class="nav-link-icon"><i data-feather="archive"></i></div>
                        Vat Info
                    </a>
                <?php }
                    if (menucheck($menuprivilegearray, 17) == 1) { ?>
                    <a class="nav-link p-0 px-3 py-2" href="customerporder.php">
                        <div class="nav-link-icon"><i data-feather="archive"></i></div>
                        Customer Porder
                    </a>
                    <?php }
                if (menucheck($menuprivilegearray, 18) == 1 | menucheck($menuprivilegearray, 19) == 1 | menucheck($menuprivilegearray, 20) == 1 | menucheck($menuprivilegearray, 21) == 1 | menucheck($menuprivilegearray, 22) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseinvoice" aria-expanded="false" aria-controls="collapseinvoice">
                    <div class="nav-link-icon"><i data-feather="file"></i></div>
                    Invoice
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($lastElement == "invoiceview.php" | $lastElement == "invoicepayment.php" | $lastElement == "invoicerecovery.php" | $lastElement == "paymentreceipt.php" | $lastElement == "cancelledinvoice.php") {echo 'show';} ?>" id="collapseinvoice" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php if (menucheck($menuprivilegearray, 18) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="invoiceview.php">Invoice View</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 19) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="invoicepayment.php">Invoice Payment</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 20) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="invoicerecovery.php">Invoice Recovery</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 21) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="paymentreceipt.php">Payment Receipt</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 22) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="cancelledinvoice.php">Cancelled Invoice</a>
                        <?php } ?>
                    </nav>
                </div>
                <?php }
                if (menucheck($menuprivilegearray, 23) == 1 | menucheck($menuprivilegearray, 24) == 1 | menucheck($menuprivilegearray, 25) == 1 | menucheck($menuprivilegearray, 26) == 1) { ?>
                <a class="nav-link p-0 px-3 py-2 collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseproductreturn" aria-expanded="false" aria-controls="collapseproductreturn">
                    <div class="nav-link-icon"><i data-feather="corner-down-left"></i></div>
                    Product Return
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php if ($lastElement == "productreturn.php" | $lastElement == "customerreturn.php" | $lastElement == "supplierreturn.php" | $lastElement == "damagereturns.php") {echo 'show';} ?>" id="collapseproductreturn" data-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <?php if (menucheck($menuprivilegearray, 23) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="productreturn.php">New Return</a>
                        <?php }
                        if (menucheck($menuprivilegearray, 24) == 1) { ?>
                            <a class="nav-link p-0 px-3 py-1" href="customerreturn.php">All Returns</a>
                        <?php //}
                        // if (menucheck($menuprivilegearray, 25) == 1) { ?>
                        <!-- //     <a class="nav-link p-0 px-3 py-1" href="supplierreturn.php">Supplier Return</a> -->
                        // <?php //}
                        // if (menucheck($menuprivilegearray, 26) == 1) { ?>
                        <!-- //     <a class="nav-link p-0 px-3 py-1" href="damagereturns.php">Damage Return</a> -->
                        <?php } ?>
                    </nav>
                </div>
                <?php }
                if (menucheck($menuprivilegearray, 41) == 1 | menucheck($menuprivilegearray, 42) == 1) { ?>
                    <a class="nav-link p-0 px-3 py-2 collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapsepettycash" aria-expanded="false" aria-controls="collapsepettycash">
                        <div class="nav-link-icon"><i data-feather="corner-down-left"></i></div>
                        Petty Cash
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?php if ($lastElement == "accountpettycashreimburse.php" | $lastElement == "accountpettycashexpenses.php") {echo 'show';} ?>" id="collapsepettycash" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                            <?php if (menucheck($menuprivilegearray, 41) == 1) { ?>
                                <a class="nav-link p-0 px-3 py-1" href="accountpettycashreimburse.php">Petty Cash Reimburse</a>
                            <?php }
                            if (menucheck($menuprivilegearray, 42) == 1) { ?>
                                <a class="nav-link p-0 px-3 py-1" href="accountpettycashexpenses.php">Petty Cash Expenses</a>
                            <?php } ?>
                        </nav>
                    </div>
                    <?php }
                if (menucheck($menuprivilegearray, 31) == 1 | menucheck($menuprivilegearray, 32) == 1 | menucheck($menuprivilegearray, 33) == 1 | menucheck($menuprivilegearray, 34) == 1 | menucheck($menuprivilegearray, 35) == 1 | menucheck($menuprivilegearray, 36) == 1 | menucheck($menuprivilegearray, 37) == 1 | menucheck($menuprivilegearray, 38) == 1 | menucheck($menuprivilegearray, 39) == 1 ) { ?> 
                    <a class="nav-link p-0 px-3 py-2 collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapsereport" aria-expanded="false" aria-controls="collapsereport">
                        <div class="nav-link-icon"><i data-feather="file"></i></div>
                        Reports
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?php if ($lastElement == "stock.php" | $lastElement == "customeroutstanding.php" | $lastElement == "dailysale.php" | $lastElement == "dailycash.php" | $lastElement == "salereportcustomer.php" | $lastElement == "salereportproduct.php" | $lastElement == "bufferstockmaintainreport.php" | $lastElement == "ouritemrange.php" | $lastElement == "salesorder.php" | $lastElement == "bincard.php") {echo 'show';} ?>" id="collapsereport" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                            <?php if (menucheck($menuprivilegearray, 31) == 1) { ?>
                                <a class="nav-link p-0 px-3 py-1" href="stock.php">Stock</a>
                            <?php }
                                    if (menucheck($menuprivilegearray, 32) == 1) { ?>
                                <a class="nav-link p-0 px-3 py-1" href="bincard.php">Bin Card</a>
                            <?php }
                                    if (menucheck($menuprivilegearray, 33) == 1) { ?>
                                <a class="nav-link p-0 px-3 py-1" href="customeroutstanding.php">Customer Outstanding</a>
                            <?php }
                                    if (menucheck($menuprivilegearray, 34) == 1) { ?>
                                <!-- <a class="nav-link p-0 px-3 py-1" href="dailysale.php">Daily Sale</a> -->
                            <?php }
                                    if (menucheck($menuprivilegearray, 35) == 1) { ?>
                                <a class="nav-link p-0 px-3 py-1" href="dailycash.php">Daily Cash & Cheque</a>
                            <?php }
                                    if (menucheck($menuprivilegearray, 36) == 1) { ?>
                                <a class="nav-link p-0 px-3 py-1" href="salereportcustomer.php">Sale Report Customer</a>
                            <?php }
                                    if (menucheck($menuprivilegearray, 37) == 1) { ?>
                                <!-- <a class="nav-link p-0 px-3 py-1" href="salereportproduct.php">Sale Report Product</a> -->
                            <?php }
                                    if (menucheck($menuprivilegearray, 38) == 1) { ?>
                                <!-- <a class="nav-link p-0 px-3 py-1" href="bufferstockmaintainreport.php">Buffer Maintainance</a> -->
                            <?php }
                                    if (menucheck($menuprivilegearray, 39) == 1) { ?>
                                <a class="nav-link p-0 px-3 py-1" href="ouritemrange.php">Our Item Range</a>
                            <?php } ?>
                        </nav>
                    </div>
                <?php }
                if (menucheck($menuprivilegearray, 1) == 1 | menucheck($menuprivilegearray, 2) == 1 | menucheck($menuprivilegearray, 3) == 1) { ?>
                    <a class="nav-link p-0 px-3 py-2 collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
                        <div class="nav-link-icon"><i data-feather="user"></i></div>
                        User Account
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?php if ($lastElement == "useraccount.php" | $lastElement == "usertype.php" | $lastElement == "userprivilege.php") {echo 'show';} ?>" id="collapseUser" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                            <?php if (menucheck($menuprivilegearray, 1) == 1) { ?>
                                <a class="nav-link p-0 px-3 py-1" href="useraccount.php">User Account</a>
                            <?php }
                            if (menucheck($menuprivilegearray, 2) == 1) { ?>
                                <a class="nav-link p-0 px-3 py-1" href="usertype.php">Type</a>
                            <?php }
                            if (menucheck($menuprivilegearray, 3) == 1) { ?>
                                <a class="nav-link p-0 px-3 py-1" href="userprivilege.php">Privilege</a>
                            <?php } ?>
                        </nav>
                    </div>
                <?php } ?>
        </div>
    </div>
    <div class="sidenav-footer bg-laugfs">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title"><?php echo ucfirst($_SESSION['name']); ?></div>
        </div>
    </div>
</nav>