<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<span class="error-alert" ><?= $message ?></span>
