<?php
$aClinics = cClncClinic::getArray();
//$aProcCats = cProcedureCategory::getArray();
?>
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap mr-2">
      <h5 class="font-weight-bold mt-2 mb-2 mr-5"><?php echo getLabel($requestProg->Name); ?></h5>
    </div>
    <div class="d-flex align-items-center">
      <select id="lstClinic" class="form-control form-control-sm form-select mx-1" data-toggle="tooltip" title="" data-original-title="Speciality">
        <?php
        foreach ($aClinics as $element) {
          $selected = '';
          if ($element->Id == 1) {
            $selected = 'selected';
          }
          ?>
          <option value="<?php echo $element->Id; ?>" <?php echo $selected; ?>><?php echo $element->Name; ?></option>
          <?php
        }
        ?>
      </select>
      <div class="input-group date">
        <input id="dateDay" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo date('Y-m-d'); ?>" required="true" />
        <div class="input-group-append datepicker-btn">
          <span class="input-group-text">
            <i class="la la-calendar"></i>
          </span>
        </div>
      </div>
    </div>
    <div class="d-flex align-items-center">
    </div>
  </div>
</div>
<div class="d-flex flex-column-fluid">
  <div class="container-fluid" id="appContainer">

  </div>
</div>

<div class="modal fade" id="remsFormModal" tabindex="-1" role="dialog" aria-labelledby="remsFormModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="remsFormModalLabel"><?php echo getLabel('Add Remarks'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="ph_Rems_form">
          <div class="tab-content">
            <div class="form-group row">
              <label class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Remarks'); ?></label>
              <div class="col-sm-9">
                <input id="appIdx" type="hidden" value="0" />
                <input id="remId" type="hidden" value="0" />
                <textarea id="remNote" class="form-control form-control-lg form-control-solid"></textarea>
              </div>
              <div class="col-sm-1 text-center">
                <button id="ph_addRems" type="button" class="btn btn-primary font-weight-bold text-center pl-4 pr-2"><i class="icon flaticon2-arrow-down"></i> Add</button>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 mb-0 py-0" style="max-height: 25vh; overflow-y: scroll;">
                <table class="table table-striped table-bordered mb-0 w-100">
                  <thead>
                    <tr>
                      <th style="width: 5%;"></th>
                      <th style="width: 20%;"><?php echo getLabel('Datetime'); ?></th>
                      <th style="width: 25%;"><?php echo getLabel('Doctor'); ?></th>
                      <th style="width: 50%;"><?php echo getLabel('Remarks'); ?></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="remRems" class="col-sm-12 mt-0 py-0" style="max-height: 25vh; overflow-y: scroll;">

              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-warning font-weight-bold text-center pl-4 pr-2" data-dismiss="modal"><i class="icon-2x flaticon2-cancel"></i></button>
      </div>
    </div>
  </div>
</div>

<!--
<div class="modal fade" id="treatFormModal" tabindex="-1" role="dialog" aria-labelledby="treatFormModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="treatFormModalLabel">Treatment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="ph_Treat_form">
          <div class="tab-content">
            <div class="row">
              <div class="col-sm-1 text-center">
                <button id="ph_closeTreatment" type="button" class="btn btn-info font-weight-bold text-center px-2" data-toggle="tooltip" title="" data-original-title="Close Tratment, make ready for invoice"><i class="icon-2x la la-cash-register"></i><br/>Close Treatment</button>
              </div>
              <div class="col-sm-10 text-center">
                <table class="table table-striped table-bordered mb-0 w-100">
                  <thead>
                    <tr>
                      <th style="width: 25%;">Category</th>
                      <th style="width: 45%;">Procedure</th>
                      <th style="width: 10%;">QTY</th>
                      <th style="width: 10%;">Price</th>
                      <th style="width: 10%;">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <select id="treatCat" class="form-control selectpicker">
                          <option selected value="0">Please Select</option>
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
                        <select id="lstProcedure" class="form-control selectpicker">
                          <option selected value="-1">Please Select</option>
                        </select>
                      </td>
                      <td>
                        <input id="procQnt" class="form-control form-control-solid text-right" type="text" value="1" />
                      </td>
                      <td>
                        <input id="procPrice" class="form-control form-control-solid text-right" type="text" value="0" />
                      </td>
                      <td>
                        <input id="procAmt" class="form-control form-control-solid text-right" type="text" readonly="" value="0" />
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-sm-1 text-center">
                <button id="ph_addProc" type="button" class="btn btn-info font-weight-bold text-center px-4" data-toggle="tooltip" title="" data-original-title="Add Procedure"><i class="icon flaticon2-arrow-down"></i><br/>Add</button>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12 mb-0 py-0" style="max-height: 25vh; overflow-y: scroll;">
                <table class="table table-striped table-bordered mb-0 py-0 w-100">
                  <thead>
                    <tr>
                      <th style="width: 5%;"></th>
                      <th style="width: 10%;">Datetime</th>
                      <th style="width: 10%;">Doctor</th>
                      <th style="width: 50%;">Procedure</th>
                      <th style="width: 5%;">QTY</th>
                      <th style="width: 10%;">Price</th>
                      <th style="width: 10%;">Amount</th>
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
                      <th style="width: 50%;"></th>
                      <th style="width: 5%;"></th>
                      <th style="width: 10%;"></th>
                      <th style="width: 10%;" class="text-right" id="total">0</th>
                    </tr>
                  </thead>
                </table>
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
-->