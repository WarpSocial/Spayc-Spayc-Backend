<?php 
$ageArr = unserialize(USER_AGE);
$genderArr = unserialize(USER_GENDER);
?>
<div class="filters">
  <div class="container">    
    <?php echo $this->Form->create('',['id'=>'userFilterFrm','type'=>'get', 'autocomplete' => 'off','novalidate'=>'novalidate']); ?>
          <div class="filter-wrapper">
            <!--============search dropdown========-->
              <div class="search">
	              <div class="form-group">                
	                <?= $this->Form->input('keyword',['type'=>'text', 'class'=>'form-control','label'=>false, 'placeholder'=>'Search', 'value'=> $this->request->query('keyword')]); ?>
	                <span class="clear-search hide" id="clear-search"></span>
	              </div>
            	</div>            
           
              <div class="filter-by ml-auto">
              	<h4>Fillter by</h4>
             		<!--============filter dropdown========-->
              <div class="filter-box">
	                <div class="dropp-header js-dropp-action filter-sm">
	                  <span class="dropp-header__title js-value ell" id="user_type"> <?php echo ($this->request->query('gender'))?$this->request->query('gender'):'Gender';?></span>
	                  <i class="icon icon-down-filter"></i>
	                </div>
	                <div class="dropp-body">
	                  <div class="dropp-body-wrap">
                      <?php 
                    $html='';
                    foreach ($genderArr as $key => $value) {
                        $checked = '';
                        if ($this->request->query('gender')==$value) {
                          $checked = 'checked="checked"';
                        }
                        $html .= "<label for='gender_".$key."' class='custom-label'>";
                        $html .= "<input type='radio' ".$checked." id='gender_".$key."' name='gender' value='".$value."'/>";
                        $html .= "<span class='ell'>".$value."</span>";
                        $html .= "</label>";
                      }
                      echo $html;
                      ?>
	                  </div>
	                </div>
              </div>
              <div class="filter-box">
                  <div class="dropp-header js-dropp-action filter-sm">
                    <span class="dropp-header__title js-value ell "><?php echo ($this->request->query('age_filter'))?$ageArr[$this->request->query('age_filter')]:'Age';?></span>
                    <i class="icon icon-down-filter"></i>
                  </div>
                  <div class="dropp-body">
                    <div class="dropp-body-wrap">
                    <?php 
                    $html='';
                    foreach ($ageArr as $key => $value) {
                        $checked = '';
                        if ($this->request->query('age_filter')==$key) {
                          $checked = 'checked="checked"';
                        }
                        $html .= "<label for='age_".$key."' class='custom-label'>";
                        $html .= "<input type='radio' ".$checked." id='age_".$key."' name='age_filter' value='".$key."'/>";
                        $html .= "<span class='ell'>".$value."</span>";
                        $html .= "</label>";
                      }
                      echo $html;
                      ?>
                    </div>
                	</div>
              </div>
              <!--============filter dropdown========-->
              <div class="filter-box">
                  <div class="dropp-header filter-sm">
                    <div class="input-group date datepicker">
                      <?= $this->Form->input('from_date',['type'=>'text', 'placeholder'=> 'From Date', 'class'=>'from-date', 'value'=> $this->request->query('from_date'), 'readonly'=>true, 'label'=>false,'templates' => ['inputContainer' => '{{content}}']]); ?>
                      <span class="input-group-addon datepicker-icon"></span>
                  </div>
                  </div>
  
              </div>
                <!--============filter dropdown========-->
              <div class="filter-box">
                  <div class="dropp-header filter-sm">
                    <div 	class="input-group date datepicker">
                       <?= $this->Form->input('to_date',['type'=>'text', 'placeholder'=> 'To Date', 'class'=>'to-date', 'value'=> $this->request->query('to_date'), 'readonly'=>true, 'label'=>false,'templates' => ['inputContainer' => '{{content}}'] ]); ?>
                      <span class="input-group-addon datepicker-icon"></span>
                    </div>
                  </div>
               </div>
                <!--============filter dropdown========-->
                <!-- <div class="filter-box">
                  <button type="submit" class="button btn-xs filter-button-apply">Apply</button> 
                </div> -->
                <?= $this->Form->button('Apply', ['type' => 'submit','class'=>'reset-filter']); ?> 
                <?= $this->Form->button('Reset', ['type' => 'button', 'id'=>'filter-reset', 'class'=>'reset-filter']); ?>  
            </div>
          </div>
    <?php echo $this->Form->end();?>
  </div>
</div>