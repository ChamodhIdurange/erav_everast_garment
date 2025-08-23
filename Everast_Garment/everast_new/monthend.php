<?php 
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
          <div class="page-header-content py-3">
            <h1 class="page-header-title">
              <div class="page-header-icon"><i class="far fa-calendar-alt"></i></div>
              <span>Month End</span>
            </h1>
          </div>
        </div>
      </div>

      <div class="container-fluid mt-2 p-0 p-2">
        <div class="card">
          <div class="card-body p-0 p-2">
            <div class="row">
              <div class="col-3">
                <form id="formmonthend" action="process/monthendprocess.php" method="post" autocomplete="off">
                  <div class="form-group mb-1">
                    <label class="small font-weight-bold text-dark">Month*</label>
                    <div class="input-group input-group-sm">
                      <input type="month" class="form-control" name="monthend_ym" id="monthend_ym" required>
                      <div class="input-group-append">
                        <span class="btn btn-light border-gray-500"><i class="far fa-calendar"></i></span>
                      </div>
                    </div> 
                    <small id="monthLabel" class="text-muted d-block mt-1"></small>
                  </div>

                  <div class="form-group mt-3">
                    <button type="button" id="submitBtn" class="btn btn-outline-primary btn-sm px-3 fa-pull-right">
                      <i class="far fa-save"></i>&nbsp;Month End
                    </button>
                    <input type="submit" class="d-none" id="hidebtnsubmit">
                  </div>

                  <input type="hidden" name="recordOption" id="recordOption" value="1">
                  <input type="hidden" name="recordID" id="recordID" value="">
                </form>

                <div class="mt-3">
                  <?php if(!empty($_SESSION['msg'])): ?>
                    <div class="alert alert-info py-2 px-3"><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
                  <?php endif; ?>
                  <div id="inlineAlert" class="alert d-none py-2 px-3"></div>
                </div>
              </div>

              <div class="col-9">
                <table class="table table-bordered table-striped table-sm nowrap small w-100" id="dataTable">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Month</th>
                    <th>Status</th>
                    <!-- <th>Total Products</th>
                    <th>Total Qty</th> -->
                  </tr>
                  </thead>
                </table>
              </div>
            </div> 
          </div>
        </div>
      </div>
    </main>
    <?php include "include/footerbar.php"; ?>
  </div>
</div>
<?php include "include/footerscripts.php"; ?>

<script>
$(document).ready(function() {
  const $ym = $('#monthend_ym');
  const $submitBtn = $('#submitBtn');
  const $inlineAlert = $('#inlineAlert');
  const $monthLabel = $('#monthLabel');

  const now = new Date();
  const ymDefault = now.getFullYear() + '-' + String(now.getMonth()+1).padStart(2,'0');
  $ym.val(ymDefault);
  updateMonthLabel();

  const dt = $('#dataTable').DataTable({
    destroy: true,
    processing: true,
    serverSide: true,
    ajax: { url: "scripts/monthendlist.php", type: "POST" },
    order: [[1, "desc"]],
    columns: [
      { data: "rownum", className: "text-right", width: "50px" },
      { data: "month_name" },
      { data: "status_badge", className: "text-center" },
    //   { data: "product_count", className: "text-right" },
    //   { data: "total_qty", className: "text-right",
    //     render: function(data){
    //       if(data===null) return '';
    //       const n = parseFloat(data).toFixed(2);
    //       return addCommas(n);
    //     }
    //   }
    ]
  });

  $ym.on('change', function(){
    updateMonthLabel();
    checkMonthStatus();
  });

  checkMonthStatus();

  $submitBtn.on('click', function(){
    if(!$ym.val()){
      showInline('Please select a month.', 'warning');
      return;
    }

    const pretty = monthPretty($ym.val());
    if(confirm("Submit Month End for " + pretty + " ?")){
      $("#hidebtnsubmit").click();
    }
  });

  function monthPretty(ym){
    const d = new Date(ym + '-01');
    const monthName = d.toLocaleString('default', { month: 'long' });
    return monthName + ' ' + d.getFullYear();
  }

  function updateMonthLabel(){
    const v = $ym.val();
    $monthLabel.text(v ? 'Selected: ' + monthPretty(v) : '');
  }

  function showInline(msg, type){
    $inlineAlert.removeClass('d-none alert-info alert-success alert-warning alert-danger')
      .addClass('alert-' + type).text(msg);
  }

  function hideInline(){
    $inlineAlert.addClass('d-none').text('');
  }

  function addCommas(nStr){
    nStr += '';
    let x = nStr.split('.');
    let x1 = x[0];
    let x2 = x.length > 1 ? '.' + x[1] : '';
    const rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) x1 = x1.replace(rgx, '$1' + ',' + '$2');
    return x1 + x2;
  }

  function checkMonthStatus(){
    hideInline();
    $submitBtn.prop('disabled', true); // default
    const ym = $ym.val(); 
    if(!ym) return;
    $.ajax({
      url: "scripts/check_month_status.php",
      method: "POST",
      dataType: "json",
      data: { ym: ym },
      success: function(resp){
        if(resp.submitted){
          $submitBtn.prop('disabled', true);
          showInline('Month End already submitted for ' + monthPretty(ym), 'info');
        }else{
          $submitBtn.prop('disabled', false);
        }
      },
      error: function(){
        $submitBtn.prop('disabled', false);
      }
    });
  }
});
</script>
<?php include "include/footer.php"; ?>
