<?php
use Cake\Routing\Router;

	$html ='';                    
	foreach ($total_spayc_admin as $key => $value) {
		$adminTitle=($value->is_admin == 1)?'Admin':'Super Admin';
		$usrImg = !empty($value->user->user_images)?$this->Html->image($value->user->user_images[0]->image_url, ['alt' => '']):$this->Html->image('user.jpg', ['alt' => 'img']);
		$html .="<div class='user-list'>";
		$html .="<div class='user-image'>";
		$html .="<span>".$usrImg."</span></div>";
		$html .="<div class='user-list-info'>";
		$html .="<span class='user-name ell'>".ucwords($value->user->display_name)."</span>";
		$html .="<span class='user-id ell'>".$value->user->email."</span>";
		$html .="<span>".$adminTitle."</span>";
		$html .="</div></div>";
	}
	echo $html;