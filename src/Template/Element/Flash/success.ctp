<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div id="notification" class="alert alert-success flash-msg"><?= $message ?><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
