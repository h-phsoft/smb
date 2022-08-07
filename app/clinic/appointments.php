<?php
$aClinics = cClncClinic::getArray();
$aSpecials = cClncSpecial::getArray();
?>
<style>
  .navi-item {
    cursor: pointer;
  }
  .navi-item:hover {
    background-color: #f0f0f0;
  }
</style>
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
      <select id="lstSpecial" class="form-control form-control-sm form-select mx-1" data-toggle="tooltip" title="" data-original-title="Speciality">
        <?php
        foreach ($aSpecials as $element) {
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
      <span class="switch switch-outline switch-icon switch-success mt-3 ml-5" title="<?php echo getLabel('Toggle Empty Rows'); ?>">
        <label>
          <input id="toggleEmptyRows" type="checkbox" checked="checked" name="select">
          <span></span>
        </label>
      </span>
    </div>
  </div>
</div>
<div class="d-flex flex-column-fluid">
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div id="phTableHeader" class="table-responsive bg-white" style="overflow-x: auto; overflow-y: scroll; margin-bottom: 0px;"></div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div id="phTable" class="table-responsive bg-white" style="overflow-x: auto; overflow-y: scroll; max-height: 62vh"></div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div id="tabulatorTable1"></div>
      </div>
    </div>
  </div>
</div>
