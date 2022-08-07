<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap mr-2">
      <h5 class="font-weight-bold mt-2 mb-2 mr-5"><?php echo getLabel($requestProg->Name); ?></h5>
    </div>
    <div class="d-flex align-items-center">

    </div>
  </div>
</div>
<div class="d-flex flex-column-fluid">
  <div class="container-fluid">
    <div class="row">
      <?php
      $nFlg = ph_GetDBValue('1', 'cpy_sys', 'sys_id=7700');
      if ($nFlg > 0) {
        $aColleges = cUnvCollege::getArray('status_id=1');
        ?>
        <div class="col-sm-6">
          <div class="card card-custom card-stretch gutter-b">
            <div class="card-header border-0 py-5">
              <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark"><?php echo getLabel('Registration'); ?></span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm"><?php echo getLabel('Differentiation'); ?></span>
              </h3>
              <div class="card-toolbar">
              </div>
            </div>
            <div class="card-body pt-0 pb-3">
              <div class="tab-content">
                <div class="table-responsive">
                  <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                    <thead>
                      <tr class="text-left text-uppercase">
                        <th style="width: 40%" class="pl-7"><span class="text-dark-75"><?php echo getLabel('Colleges'); ?></span></th>
                        <th style="width: 40%"><?php echo getLabel('Section'); ?></th>
                        <th style="width: 20%"><?php echo getLabel('Count'); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $nTot = 0;
                      foreach ($aColleges as $college) {
                        $aSections = cUnvSection::getArray('`colg_id`="' . $college->Id . '" AND status_id=1');
                        foreach ($aSections as $section) {
                          $nCount = substr(rand() . '', 0, 3);
                          $nTot += intval($nCount);
                          ?>
                          <tr>
                            <td class="pl-0 py-0">
                              <span class="text-dark-75 font-weight-bold d-block"><?php echo $college->Colname; ?></span>
                            </td>
                            <td class="text-left pr-0">
                              <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $section->Name; ?></span>
                            </td>
                            <td>
                              <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $nCount; ?></span>
                            </td>
                          </tr>
                          <?php
                        }
                      }
                      ?>
                    </tbody>
                    <thead>
                      <tr class="text-left text-uppercase">
                        <th style="width: 40%" class="pl-7"><span class="text-dark-75"><?php echo getLabel('Total'); ?></span></th>
                        <th style="width: 40%"></th>
                        <th style="width: 20%"><span class="text-dark"><?php echo $nTot; ?></span></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>

      <?php
      $nFlg = ph_GetDBValue('1', 'cpy_sys', 'sys_id=7002');
      if ($nFlg > 0) {
        $aTotals = cFundDiary::getSummary(date("Y-m-d"));
        ?>
        <div class="col-sm-6">
          <div class="card card-custom card-stretch gutter-b">
            <div class="card-header border-0 py-5">
              <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark"><?php echo getLabel('Funds'); ?></span>
              </h3>
              <div class="card-toolbar">
                <?php echo date("Y-m-d"); ?>
              </div>
            </div>
            <div class="card-body pt-0 pb-3">
              <div class="tab-content">
                <div class="table-responsive">
                  <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                    <thead>
                      <tr class="text-left text-uppercase">
                        <th><?php echo getLabel('Fund Box'); ?></th>
                        <th><?php echo getLabel('Box.Open'); ?></th>
                        <th><?php echo getLabel('Box.Credit'); ?></th>
                        <th><?php echo getLabel('Box.Debit'); ?></th>
                        <th><?php echo getLabel('Blnc.Balance'); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($aTotals as $tot) {
                        ?>
                        <tr>
                          <td class="pl-0 py-0">
                            <span class="text-dark-75 font-weight-bold d-block"><?php echo $tot['vBox']; ?></span>
                          </td>
                          <td class="text-left pr-0">
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $tot['nOpn']; ?></span>
                          </td>
                          <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $tot['nCrd']; ?></span>
                          </td>
                          <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $tot['nDeb']; ?></span>
                          </td>
                          <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $tot['nBln']; ?></span>
                          </td>
                        </tr>
                        <?php
                      }
                      ?>
                    </tbody>
                    <thead>
                      <tr class="text-left text-uppercase">
                        <th></th>
                        <th></th>
                        <th><span class="text-dark"><?php echo $nTot; ?></span></th>
                        <th><span class="text-dark"><?php echo $nTot; ?></span></th>
                        <th><span class="text-dark"><?php echo $nTot; ?></span></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>

      <?php
      $nFlg = ph_GetDBValue('1', 'cpy_sys', 'sys_id=1305');
      if ($nFlg > 0) {
        $aTots = [0, 0, 0, 0, 0];
        $aGrps = ['cat_name'];
        $aTotals = cPosVOrders::getSummary($aGrps, date("Y-m-d"));
        ?>
        <div class="col-sm-6">
          <div class="card card-custom card-stretch gutter-b">
            <div class="card-header border-0 py-5">
              <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark"><?php echo getLabel('POS'); ?></span>
              </h3>
              <div class="card-toolbar">
                <?php echo date("Y-m-d"); ?>
              </div>
            </div>
            <div class="card-body pt-0 pb-3">
              <div class="tab-content">
                <div class="table-responsive">
                  <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                    <thead>
                      <tr class="text-left text-uppercase">
                        <th><?php echo getLabel('Category'); ?></th>
                        <th><?php echo getLabel('Count'); ?></th>
                        <th><?php echo getLabel('Qnt'); ?></th>
                        <th><?php echo getLabel('Amount'); ?></th>
                        <th><?php echo getLabel('Discount'); ?></th>
                        <th><?php echo getLabel('Net Amount'); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      for ($index = 0; $index < count($aTotals); $index++) {
                        $tot = $aTotals[$index];
                        $aTots[0] += $tot['nCount'];
                        $aTots[1] += $tot['nQnt'];
                        $aTots[2] += $tot['nAmt'];
                        $aTots[3] += $tot['nTDisc'];
                        $aTots[4] += $tot['nTNet'];
                        ?>
                        <tr>
                          <td><span class="text-dark-75 font-weight-bold d-block"><?php echo $tot['Grp0']; ?></span></td>
                          <td><span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $tot['nCount']; ?></span></td>
                          <td><span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $tot['nQnt']; ?></span></td>
                          <td><span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $tot['nAmt']; ?></span></td>
                          <td><span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $tot['nTDisc']; ?></span></td>
                          <td><span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $tot['nTNet']; ?></span></td>
                        </tr>
                        <?php
                      }
                      ?>
                    </tbody>
                    <thead>
                      <tr class="text-left text-uppercase">
                        <th><span class="text-dark-75 font-weight-bold d-block"></span></th>
                        <th><span class="text-dark-75 font-weight-bold d-block"><?php echo $aTots[0]; ?></span></th>
                        <th><span class="text-dark-75 font-weight-bold d-block"><?php echo $aTots[1]; ?></span></th>
                        <th><span class="text-dark-75 font-weight-bold d-block"><?php echo $aTots[2]; ?></span></th>
                        <th><span class="text-dark-75 font-weight-bold d-block"><?php echo $aTots[3]; ?></span></th>
                        <th><span class="text-dark-75 font-weight-bold d-block"><?php echo $aTots[4]; ?></span></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
  </div>
</div>
