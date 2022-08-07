<?php
$nDefCurrency = intval(cCpyPref::getPref('Def_Currency'));
$aCurrencies = cMngCurrency::getArray('status_id=1 AND id!="' . $nDefCurrency . '"');
?>
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap mr-2">
      <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?php echo getLabel($requestProg->Name); ?></h5>
      <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
    </div>
    <div class="d-flex align-items-center">
    </div>
  </div>
</div>
<div class="d-flex flex-column-fluid">
  <div class="container-fluid">
    <div class="card card-custom">
      <div class="card-body text-center">
        <div class="row">
          <div class="col-sm-10 m-auto">
            <?php
            if ($oUser->oGrp->Id <= 0 || $oUser->oGrp->aPerms[$requestProg->Id]->Insert) {
              ?>
              <table class="table table-striped table-bordered mb-0 py-0 w-100">
                <thead>
                  <tr>
                    <th class="fw-bolder" style="width: 33%;"><?php echo getLabel('Currency'); ?></th>
                    <th style="width: 33%;"><?php echo getLabel('Rate'); ?></th>
                    <th style="width: 33%;"><?php echo getLabel('Date'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($aCurrencies as $element) {
                    ?>
                    <tr>
                      <td><?php echo $element->Name; ?></td>
                      <td>
                        <input class="form-control form-control-sm text-start curn-rate" type="text" required="" value="<?php echo $element->Rate; ?>" data-id="<?php echo $element->Id; ?>">
                      </td>
                      <td><?php echo $element->Date; ?></td>
                    </tr>
                    <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row py-3">
            <div class="col-sm-2 m-auto">
              <div class="input-group date">
                <input id="editDate" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo date('Y-m-d'); ?>" required="true" />
                <div class="input-group-append datepicker-btn">
                  <span class="input-group-text">
                    <i class="la la-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-10 m-auto">
              <button id="ph_save" type="button" class="btn btn-primary font-weight-bold text-center pl-4 pr-2"><i class="icon-2x flaticon2-check-mark"></i></button>
            </div>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>
