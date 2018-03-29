<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<span class="error-alert" onclick="this.classList.add('hide');"><?= $message ?></span>
