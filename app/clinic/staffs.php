<?php
$aGenders = cPhsCode::getArray(cPhsCode::GENDER);
$aSpecials = cClncSpecial::getArray();
$aStatuss = cPhsCode::getArray(cPhsCode::STATUS);
$aTypes = cCpyUserType::getArray('id>0');
?>
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
 <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
  <div class="d-flex align-items-center flex-wrap mr-2">
   <h5 class="font-weight-bold mt-2 mb-2 mr-5"><?php echo getLabel($requestProg->Name); ?></h5>
   <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
  </div>
  <div class="d-flex align-items-center">
   <?php
   if ($oUser->oGrp->getPermission($requestProg->Id)->Insert) {
    include "section/button_add.php";
   }
   ?>
  </div>
 </div>
</div>
<div class="d-flex flex-column-fluid">
 <div class="container-fluid">
  <div class="card card-custom">
   <div class="card-body">
    <div id="tabulatorTable"></div>
   </div>
  </div>
 </div>
</div>

<div class="modal fade" id="ph_Modal" tabindex="-1" role="dialog" aria-labelledby="ph_Modal" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="ph_ModalLabel"><?php echo getLabel($requestProg->Name); ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <i aria-hidden="true" class="ki ki-close"></i>
    </button>
   </div>
   <div class="modal-body">
    <form id="ph_Form">
     <div class="tab-content">
      <div class="row pt-1">
       <input id="fldId" type="hidden" value="" />
       <input id="fldGrpId" type="hidden" value="0" />
       <label for="fldName" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Name'); ?></label>
       <div class="col-12 col-sm-5">
        <input id="fldName" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
       </div>
       <label for="fldSpecialId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Special'); ?></label>
       <div class="col-12 col-sm-2">
        <select id="fldSpecialId" class="form-control form-control-sm form-select">
         <?php
         foreach ($aSpecials as $element) {
         ?>
          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
         <?php
         }
         ?>
        </select>
       </div>
       <label for="fldGenderId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Gender'); ?></label>
       <div class="col-12 col-sm-2">
        <select id="fldGenderId" class="form-control form-control-sm form-select">
         <?php
         foreach ($aGenders as $element) {
         ?>
          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
         <?php
         }
         ?>
        </select>
       </div>
      </div>
      <div class="row pt-1">
       <label for="fldTypeId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Type'); ?></label>
       <div class="col-12 col-sm-2">
        <select id="fldTypeId" class="form-control form-control-sm form-select">
         <?php
         foreach ($aTypes as $element) {
         ?>
          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
         <?php
         }
         ?>
        </select>
       </div>
       <label for="fldStatusId" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Status'); ?></label>
       <div class="col-12 col-sm-2">
        <select id="fldStatusId" class="form-control form-control-sm form-select">
         <?php
         foreach ($aStatuss as $element) {
         ?>
          <option value="<?php echo $element->Id; ?>"><?php echo $element->Name; ?></option>
         <?php
         }
         ?>
        </select>
       </div>
       <label for="fldUsername" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Username'); ?></label>
       <div class="col-12 col-sm-5">
        <input id="fldUsername" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
       </div>
      </div>
      <div id="pass" class="row pt-1">
       <label for="fldPassword" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Password'); ?></label>
       <div class="col-12 col-sm-5">
        <input id="fldPassword" class="form-control form-control-sm" type="password" value="" autocomplete="off" required="true" />
       </div>
       <label for="fldPassword" class="col-form-label col-sm-1 text-lg-right text-left px-0" ><?php echo getLabel('Verify Password'); ?></label>
       <div class="col-12 col-sm-5">
        <input id="fldVPassword" class="form-control form-control-sm" type="password" value="" autocomplete="off" required="true" />
       </div>
      </div>
      <div class="row pt-1">
       <label for="fldRem" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Rem'); ?></label>
       <div class="col-12 col-sm-11">
        <input id="fldRem" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
       </div>
      </div>
      <div class="row pt-1">
       <!-- <label for="fldImage" class="col-form-label col-sm-1 text-lg-right text-left"><?php echo getLabel('Image'); ?></label>
       <div class="col-12 col-sm-2">
        <input id="fldImage" class="form-control form-control-sm" type="text" value="" autocomplete="off" required="true" />
       </div> -->
      </div>
     </div>
    </form>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-light-warning font-weight-bold text-center pl-4 pr-2" data-dismiss="modal"><i class="icon-2x flaticon2-cancel"></i></button>
    <?php
    if ($oUser->oGrp->getPermission($requestProg->Id)->Insert) {
    ?>
     <button id="ph_submit" type="button" class="btn btn-light-primary font-weight-bold text-center pl-4 pr-2"><i class="icon-2x flaticon2-check-mark"></i></button>
    <?php
    }
    ?>
   </div>
  </div>
 </div>
</div>

<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModal" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="resetPasswordModalLabel"><?php echo getLabel('Reset Password'); ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <i aria-hidden="true" class="ki ki-close"></i>
    </button>
   </div>
   <div class="modal-body">
    <form id="ph_resetPassword_form">
     <div class="form-group row">
      <label class="col-form-label col-4 text-lg-right text-left"><?php echo getLabel('New Password'); ?></label>
      <div class="col-8">
       <input id="resetUserId" type="hidden" value="" />
       <input class="form-control form-control-sm" type="password" name="resetNPassword" id="resetNPassword" value="" required="true" />
      </div>
     </div>
     <div class="form-group row">
      <label class="col-form-label col-4 text-lg-right text-left"><?php echo getLabel('Verify Password'); ?></label>
      <div class="col-8">
       <input class="form-control form-control-sm" type="password" name="resetVPassword" id="resetVPassword" value="" required="true" />
      </div>
     </div>
    </form>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-light-warning font-weight-bold text-center pl-4 pr-2" data-dismiss="modal"><i class="icon-2x flaticon2-cancel"></i></button>
    <button id="ph_resetPassword_submit" type="button" class="btn btn-light-primary font-weight-bold btn-reset-password text-center pl-4 pr-2"><i class="icon-2x flaticon2-check-mark"></i></button>
   </div>
  </div>
 </div>
</div>