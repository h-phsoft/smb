<?php$aTree = cPhsCode::getArray(cPhsCode::TREE_TYPE);$aDbCr = cPhsCode::getArray(cPhsCode::DBCR);$aStatus = cPhsCode::getArray(cPhsCode::STATUS);$aClose = cAccClose::getArray();?><div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">    <div class="d-flex align-items-center flex-wrap mr-2">      <h5 class="font-weight-bold mt-2 mb-2 mr-5"><?php echo getLabel($requestProg->Name); ?></h5>      <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>    </div>    <div class="d-flex align-items-center">      <?php include "section/button_add.php"; ?>    </div>  </div></div><div class="d-flex flex-column-fluid">  <div class="container-fluid">    <div class="card card-custom">      <div class="card-body">        <div id="tabulatorTable"></div>      </div>    </div>  </div></div><div class="modal fade" id="pageModal" tabindex="-1" role="dialog" aria-labelledby="pageModal" aria-hidden="true">  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">    <div class="modal-content">      <div class="modal-header">        <h5 class="modal-title" id="pageModalLabel"><?php echo getLabel($requestProg->Name); ?></h5>        <button type="button" class="close" data-dismiss="modal" aria-label="Close">          <i aria-hidden="true" class="ki ki-close"></i>        </button>      </div>      <div class="modal-body">        <form id="ph_form">          <div class="tab-content">            <div class="row">              <div class="col-sm-6">                <div class="form-group row">                  <label class="col-form-label col-sm-4 text-lg-right text-left"><?php echo getLabel('Number'); ?></label>                  <div class="col-sm-8">                    <input id="fldId" type="hidden" value="" />                    <input id="fldNum" class="form-control form-control-sm" type="text" value="" required="true" />                  </div>                </div>              </div>              <div class="col-sm-6">                <div class="form-group row">                  <label class="col-form-label col-sm-4 text-lg-right text-left"><?php echo getLabel('Type'); ?></label>                  <div class="col-sm-8">                    <select id="fldType" class="form-control form-control-sm form-select">                      <?php                      foreach ($aTree as $element) {                        ?>                        <option value="<?php echo $element->Id; ?>"><?php echo getLabel($element->Name); ?></option>                        <?php                      }                      ?>                    </select>                  </div>                </div>              </div>            </div>            <div class="row">              <div class="col-12">                <div class="form-group row">                  <label class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>                  <div class="col-sm-10">                    <input id="fldName" class="form-control form-control-sm" type="text" value="" required="true"/>                  </div>                </div>              </div>            </div>            <div class="row">              <div class="col-sm-6">                <div class="form-group row">                  <label class="col-form-label col-sm-4 text-lg-right text-left"><?php echo getLabel('DbCr'); ?></label>                  <div class="col-sm-8">                    <select id="fldDbCr" class="form-control form-control-sm form-select">                      <?php                      foreach ($aDbCr as $element) {                        ?>                        <option value="<?php echo $element->Id; ?>"><?php echo getLabel($element->Name); ?></option>                        <?php                      }                      ?>                    </select>                  </div>                </div>              </div>              <div class="col-sm-6">                <div class="form-group row">                  <label class="col-form-label col-sm-4 text-lg-right text-left"><?php echo getLabel('Close'); ?></label>                  <div class="col-sm-8">                    <select id="fldClose" class="form-control form-control-sm form-select">                      <?php                      foreach ($aClose as $element) {                        ?>                        <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>                        <?php                      }                      ?>                    </select>                  </div>                </div>              </div>            </div>            <div class="row">              <div class="col-sm-6">                <div class="form-group row">                  <label class="col-form-label col-sm-4 text-lg-right text-left"><?php echo getLabel('Status'); ?></label>                  <div class="col-sm-8">                    <select id="fldStatus" class="form-control form-control-sm form-select">                      <?php                      foreach ($aStatus as $element) {                        ?>                        <option value="<?php echo $element->Id; ?>"><?php echo getLabel($element->Name); ?></option>                        <?php                      }                      ?>                    </select>                  </div>                </div>              </div>            </div>            <div class="row">              <div class="col-12">                <div class="form-group row">                  <label class="col-form-label col-sm-2 text-lg-right text-left"><?php echo getLabel('Remarks'); ?></label>                  <div class="col-sm-10">                    <input id="fldRem" class="form-control form-control-sm" type="text" value=""/>                  </div>                </div>              </div>            </div>          </div>        </form>      </div>      <div class="modal-footer">        <button type="button" class="btn btn-light-warning font-weight-bold text-center pl-4 pr-2" data-dismiss="modal"><i class="icon-2x flaticon2-cancel"></i></button>        <button id="ph_submit" type="button" class="btn btn-light-primary font-weight-bold text-center pl-4 pr-2"><i class="icon-2x flaticon2-check-mark"></i></button>      </div>    </div>  </div></div>