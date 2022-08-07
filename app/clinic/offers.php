<?php
$aClinics = cClncClinic::getArray('`status_id`=1');
$aStatus = cPhsCode::getArray(cPhsCode::STATUS);
?>
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap mr-2">
      <h5 class="font-weight-bold mt-2 mb-2 mr-5"><?php echo getLabel($requestProg->Name); ?></h5>
    </div>
    <div class="d-flex align-items-center">
      <a href="javascript:;" id="ph_add" class="btn btn-light-primary font-weight-bold btn-md py-2 pl-3 pr-2 font-size-base text-center">
        <i class="icon-2x flaticon2-plus"></i>
      </a>
    </div>
  </div>
</div>
<div class="d-flex flex-column-fluid">
  <div class="container-fluid">
    <div id="tabulatorTable"></div>
  </div>
</div>

<div class="modal fade" id="offerFormModal" tabindex="-1" role="dialog" aria-labelledby="offerFormModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="offerFormModalLabel">Offer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="ph_Offer_form">
          <div class="row">
            <div class="col-sm-6 text-center pb-3">
              <input id="offerId" type="hidden" value="0">
              <div class="form-group row">
                <label class="col-form-label col-sm-2 text-lg-right text-left">Name *</label>
                <div class="col-sm-10">
                  <input id="offerName" name="editName" class="form-control" type="text" value="" required="">
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group row">
                <label class="col-form-label col-sm-2 text-lg-right text-left">Status *</label>
                <div class="col-sm-10">
                  <select id="offerStatus" class="form-control selectpicker">
                    <?php
                    foreach ($aStatus as $status) {
                      ?>
                      <option value="<?php echo $status->Id; ?>"><?php echo $status->Name; ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6 text-center pb-3">
              <input id="offerId" type="hidden" value="0">
              <div class="form-group row">
                <label class="col-form-label col-sm-2 text-lg-right text-left">Start *</label>
                <div class="col-sm-10">
                  <div class="input-group mx-1 date">
                    <input id="offerSDate" type="text" class="form-control form-control-md form-control-solid ph_datepicker" required="" value="<?php echo date('d-m-Y'); ?>">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="la la-calendar"></i>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group row">
                <label class="col-form-label col-sm-2 text-lg-right text-left">End *</label>
                <div class="col-sm-10">
                  <div class="input-group mx-1 date">
                    <input id="offerEDate" type="text" class="form-control form-control-md form-control-solid ph_datepicker" required="" value="<?php echo date('d-m-Y'); ?>">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="la la-calendar"></i>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="form-group row">
                <label class="col-form-label col-sm-1 text-lg-right text-left">Clinics</label>
                <div class="col-sm-11">
                  <select id="offerClinics" class="form-control selectpicker" multiple="multiple" data-actions-box="true">
                    <?php
                    foreach ($aClinics as $clinic) {
                      ?>
                      <option value="<?php echo $clinic->Id; ?>"><?php echo $clinic->Name; ?></option >
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 text-center pb-3">
              <div class="form-group row">
                <label class="col-form-label col-sm-1 text-lg-right text-left">Description</label>
                <div class="col-sm-11">
                  <input id="offerDesc" name="editName" class="form-control" type="text" value="">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-warning font-weight-bold text-center pl-4 pr-2" data-dismiss="modal" data-toggle="tooltip" title="" data-original-title="Close"><i class="icon-2x flaticon2-cancel"></i></button>
        <button id="ph_Offer_submit" type="button" class="btn btn-primary font-weight-bold" data-toggle="tooltip" title="" data-original-title="Save Changes"><i class="icon-2x flaticon2-check-mark"></i></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="offerProcsFormModal" tabindex="-1" role="dialog" aria-labelledby="offerProcsFormModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="offerProcsFormModalLabel">Offer Procedures</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="ph_OfferProcs_form">

          <div class="row">
            <div class="col-sm-11 text-center">
              <table class="table table-striped mb-0 w-100">
                <thead>
                  <tr>
                    <th style="width: 35%;">Category</th>
                    <th style="width: 55%;">Procedure</th>
                    <th style="width: 10%;">Price</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <select id="offerCat" class="form-control selectpicker">
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
                      <select id="offerProcedure" class="form-control selectpicker">
                        <option selected value="-1">Please Select</option>
                      </select>
                    </td>
                    <td>
                      <input id="offerProcPrice" class="form-control form-control-solid text-right" type="text" value="0"/>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-sm-1 text-center">
              <?php
              if ($permCurrent->Update) {
                ?>
                <button id="ph_offferAddProc" type="button" class="btn btn-info font-weight-bold text-center px-4" data-toggle="tooltip" title="" data-original-title="Add Procedure">
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
                    <th style="width: 15%;">Datetime</th>
                    <th style="width: 70%;">Procedure</th>
                    <th style="width: 10%;">Price</th>
                  </tr>
                </thead>
              </table>
            </div>
            <div id="offerProcs" class="col-sm-12 my-0 py-0" style="max-height: 25vh; overflow-y: scroll;">

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
