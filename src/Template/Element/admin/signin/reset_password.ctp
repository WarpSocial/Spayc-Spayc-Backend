<div class="modal" id="resetPasswordModal">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
				<div class ="loader">
					<div class="loader-icon"></div>
				</div>
			<span class="icon-close modal-close"></span>
			<div class="signup-header">
				<p>RESET PASSWORD</p>
			</div>
			<div class="modal-body  reset-password">
				<p>Set your new password.</p>
				<div id="forgotErrDIv" class="login-error"></div>
				<?php echo $this->Form->create('', ['id' =>'resetPasswordFrm','name' =>'resetPasswordFrm', 'novalidate' => true, 'autocomplete' => 'off']);?>
				<div class="input-field">
					<input class="required" name="password" type="password" maxlength="50" placeholder="Enter New Password">
					<?php echo PASSWORD_TOOLTIP;?>
				</div>
				<div class="input-field">
					<input class="required" name="confirm_password" type="password" maxlength="50" placeholder="Confirm New Password">
				</div>
				<button class="btn waves-effect waves-light z-depth-0" type="submit" id="resetPwdBtn">
					Save Password
				</button>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>