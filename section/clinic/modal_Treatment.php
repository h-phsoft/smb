<?php
$modalProgram = cPhsProgram::getInstanceByFile('clinic/treatments');
if ($modalProgram->Id != -999) {
  if (($oUser->oGrp->Id <= 0) ||
    (is_array($oUser->oGrp->aPerms) &&
      isset($oUser->oGrp->aPerms[$modalProgram->Id]) &&
      $oUser->oGrp->aPerms[$modalProgram->Id]->isOK)
  ) {
?>
    <div class="modal fade" id="addTreatmentModal" tabindex="-1" role="dialog" aria-labelledby="addTreatmentModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="treatFormModalLabel"><?php echo getLabel('Treatment'); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i aria-hidden="true" class="ki ki-close"></i>
            </button>
          </div>
          <div class="modal-body">
            <form id="ph_Treat_form">
              <div class="tab-content">
                <div class="row">
                  <label class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Patient'); ?>*</label>
                  <div class="col-5 text-center pb-3">
                    <input id="treatPatient" type="hidden" value="">
                    <input id="payPatientName" class="form-control form-control-sm  phAutocomplete" data-acrel="treatPatient" data-acoperation="cpy-Clinic-Patient-ListAutocomplete" value="">
                  </div>
                  <label class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Specialtie'); ?>*</label>
                  <div class="col-5 text-center pb-3">
                    <select id="fdSpecId" class="form-control  form-control-sm form-select">
                      <option selected value="0"><?php echo getLabel('Please Select'); ?></option>
                      <?php
                      foreach ($aSpec as $element) {
                      ?>
                        <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="pb-0 nav-tabs-line-3x">
                      <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                          <li class="nav-item mr-3">
                            <a id="ph_tab_1_link" class="nav-link tab-link active" data-toggle="tab" href="#ph_tab_1">
                              <span class="nav-text font-size-lg"><?php echo getLabel('Treatment'); ?></span>
                            </a>
                          </li>
                          <li class="nav-item mr-3">
                            <a id="ph_tab_2_link" class="nav-link tab-link" data-toggle="tab" href="#ph_tab_2">
                              <span class="nav-text font-size-lg"><?php echo getLabel('Items'); ?></span>
                            </a>
                          </li>
                          <li class="nav-item mr-3">
                            <a id="ph_tab_3_link" class="nav-link tab-link" data-toggle="tab" href="#ph_tab_3">
                              <span class="nav-text font-size-lg"><?php echo getLabel('Details'); ?></span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="tab-content">
                      <div class="tab-pane active" id="ph_tab_1">
                        <div class="row">
                          <div class="col-sm-10 text-center">
                            <table class="table table-striped table-bordered mb-0 w-100">
                              <thead>
                                <tr>
                                  <th style="width: 25%;"><?php echo getLabel('Category'); ?></th>
                                  <th style="width: 45%;"><?php echo getLabel('Procedure'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('QTY'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('Price'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('Amount'); ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <select id="treatCat" class="form-control  form-control-sm form-select">
                                      <option selected value="0"><?php echo getLabel('Please Select'); ?></option>
                                      <?php
                                      foreach ($aProcCats as $element) {
                                      ?>
                                        <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                                      <?php
                                      }
                                      ?>
                                    </select>
                                  </td>
                                  <td>
                                    <select id="lstProcedure" class="form-control  form-control-sm form-select">
                                      <option selected value="-1"><?php echo getLabel('Please Select'); ?></option>
                                    </select>
                                  </td>
                                  <td>
                                    <input id="procQnt" class="form-control form-control-sm" type="text" value="1" />
                                  </td>
                                  <td>
                                    <input id="procPrice" class="form-control form-control-sm" type="text" value="0" <?php echo (!$permTreats->Special ? 'readonly="true"' : ''); ?> />
                                  </td>
                                  <td>
                                    <input id="procAmt" class="form-control form-control-sm" type="text" readonly="" value="0" />
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <div class="col-sm-2 pt-15 px-15">
                            <?php
                            if ($permTreats->Insert) {
                            ?>
                              <button id="ph_addProc" type="button" class="btn btn-info font-weight-bold text-center px-4" data-toggle="tooltip" title="" data-original-title="Add Procedure">
                                <i class="icon flaticon2-arrow-down"></i>
                                Add
                              </button>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-12 mb-0 py-0" style="max-height: 25vh; overflow-y: scroll;">
                            <table id="dataTable" class="table table-striped table-bordered mb-0 py-0 w-100">
                              <thead>
                                <tr>
                                  <th style="width: 10%;"><?php echo getLabel('Doctor'); ?></th>
                                  <th style="width: 30%;"><?php echo getLabel('Procedure'); ?></th>
                                  <th style="width: 5%;"><?php echo getLabel('QTY'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('Price'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('Amount'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('VAT'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('Total'); ?></th>
                                  <th style="width: 5%;"></th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                          <div id="treatProcs" class="col-sm-12 my-0 py-0" style="max-height: 25vh; overflow-y: scroll;">
                          </div>
                          <div class="col-sm-12 mt-0 py-0" style="max-height: 25vh; overflow-y: scroll;">
                            <table class="table table-striped table-bordered mt-0 py-0 w-100">
                              <thead>
                                <tr>
                                  <th style="width: 10%;"></th>
                                  <th style="width: 30%;"></th>
                                  <th style="width: 5%;"></th>
                                  <th style="width: 10%;"></th>
                                  <th style="width: 10%;" class="text-right" id="totalAmt">0</th>
                                  <th style="width: 10%;" class="text-right" id="totalVat">0</th>
                                  <th style="width: 10%;" class="text-right" id="totalTotal">0</th>
                                  <th style="width: 5%;"></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="ph_tab_2">
                        <div class="row">
                          <div class="col-sm-10 text-center">
                            <table class="table table-striped table-bordered mb-0 w-100">
                              <thead>
                                <tr>
                                  <th style="width: 25%;"><?php echo getLabel('Store'); ?></th>
                                  <th style="width: 45%;"><?php echo getLabel('Item'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('QTY'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('Price'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('Amount'); ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <select id="treatCat" class="form-control  form-control-sm form-select">
                                      <option selected value="0"><?php echo getLabel('Please Select'); ?></option>
                                      <?php
                                      foreach ($aProcCats as $element) {
                                      ?>
                                        <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                                      <?php
                                      }
                                      ?>
                                    </select>
                                  </td>
                                  <td>
                                    <select id="lstProcedure" class="form-control  form-control-sm form-select">
                                      <option selected value="-1"><?php echo getLabel('Please Select'); ?></option>
                                    </select>
                                  </td>
                                  <td>
                                    <input id="procQnt" class="form-control form-control-sm" type="text" value="1" />
                                  </td>
                                  <td>
                                    <input id="procPrice" class="form-control form-control-sm" type="text" value="0" <?php echo (!$permTreats->Special ? 'readonly="true"' : ''); ?> />
                                  </td>
                                  <td>
                                    <input id="procAmt" class="form-control form-control-sm" type="text" readonly="" value="0" />
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <div class="col-sm-2 pt-15 px-15">
                            <?php
                            if ($permTreats->Insert) {
                            ?>
                              <button id="ph_addProc" type="button" class="btn btn-info font-weight-bold text-center px-4" data-toggle="tooltip" title="" data-original-title="Add Procedure">
                                <i class="icon flaticon2-arrow-down"></i>
                                Add
                              </button>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-12 mb-0 py-0" style="max-height: 25vh; overflow-y: scroll;">
                            <table class="table table-striped table-bordered mb-0 py-0 w-100">
                              <thead>
                                <tr>
                                  <th style="width: 5%;"></th>
                                  <th style="width: 10%;"><?php echo getLabel('Datetime'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('Doctor'); ?></th>
                                  <th style="width: 30%;"><?php echo getLabel('Procedure'); ?></th>
                                  <th style="width: 5%;"><?php echo getLabel('QTY'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('Price'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('Amount'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('VAT'); ?></th>
                                  <th style="width: 10%;"><?php echo getLabel('Total'); ?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                          <div id="treatProcs" class="col-sm-12 my-0 py-0" style="max-height: 25vh; overflow-y: scroll;">
                          </div>
                          <div class="col-sm-12 mt-0 py-0" style="max-height: 25vh; overflow-y: scroll;">
                            <table class="table table-striped table-bordered mt-0 py-0 w-100">
                              <thead>
                                <tr>
                                  <th style="width: 5%;"></th>
                                  <th style="width: 10%;"></th>
                                  <th style="width: 10%;"></th>
                                  <th style="width: 30%;"></th>
                                  <th style="width: 5%;"></th>
                                  <th style="width: 10%;"></th>
                                  <th style="width: 10%;" class="text-right" id="totalAmt">0</th>
                                  <th style="width: 10%;" class="text-right" id="totalVat">0</th>
                                  <th style="width: 10%;" class="text-right" id="totalTotal">0</th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="ph_tab_3">
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light-warning font-weight-bold text-center pl-4 pr-2" data-dismiss="modal" data-toggle="tooltip" title="" data-original-title="Close"><i class="icon-2x flaticon2-cancel"></i></button>
          </div>
        </div>
      </div>
    </div>
<?php
  }
}
?>