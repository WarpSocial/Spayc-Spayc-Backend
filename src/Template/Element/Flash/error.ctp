<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message error error-alert" onclick="this.classList.add('hide');"><?= $message ?></div>
