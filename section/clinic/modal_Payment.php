<?php
$aMethods = cPhsCode::getArray(cPhsCode::PAYMENT_TYPE)
?>
<div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentFormModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModalLabel"><?php echo getLabel('Payment'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i aria-hidden="true" class="ki ki-close"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="ph_AddPayment_form">
          <div class="tab-content">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Doctor'); ?></label>
                  <div class="col-sm-4">
                    <select id="payDcotor" class="form-control form-control-sm form-select" required="true" data-live-search="true">
                      <option value="" selected>Please Select</option>
                      <?php
                      foreach ($aDoctors as $element) {
                        ?>
                        <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <label class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Method'); ?></label>
                  <div class="col-sm-4">
                    <select id="payMethod" class="form-control form-control-sm form-select" required="true">
                      <?php
                      foreach ($aMethods as $element) {
                        ?>
                        <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Patient'); ?>*</label>
                  <input id="payId" type="hidden" value="0" />
                  <input id="payClinic" type="hidden" value="0" />
                  <div class="col-12 col-sm-10">
                    <input id="payPatient" type="hidden">
                    <input id="payPatientName" class="form-control form-control-sm  phAutocomplete" data-acrel="payPatient" data-acoperation="cpy-Clinic-Patient-ListAutocomplete" value="">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-form-label col-3 col-sm-1 text-lg-right text-left"><?php echo getLabel('Date'); ?></label>
                  <div class="col-12 col-sm-4">
                    <div class="input-group date">
                      <input id="payDate" class="form-control form-control-sm ph_datepicker" type="text" value="<?php echo date('Y-m-d'); ?>" required="true" />
                      <div class="input-group-append datepicker-btn">
                        <span class="input-group-text">
                          <i class="la la-calendar"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <label class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Amount'); ?></label>
                  <div class="col-sm-4">
                    <input id="payAmount" class="form-control form-control-sm" type="text" value="0" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-form-label col-3 col-sm-1 text-lg-right text-left"><?php echo getLabel('Description'); ?></label>
                  <div class="col-9 col-sm-10">
                    <input id="payDesc" class="form-control form-control-sm" type="text" value="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light-warning font-weight-bold text-center pl-4 pr-2" data-dismiss="modal"><i class="icon-2x flaticon2-cancel"></i></button>
        <button id="ph_payment_submit" type="button" class="btn btn-primary font-weight-bold text-center pl-4 pr-2"><i class="icon-2x flaticon2-check-mark"></i></button>
      </div>
    </div>
  </div>
</div>