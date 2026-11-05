<?php
declare(strict_types=1);

$studentName = 'Jeremy Geovanny Panchana Cirino';

?>
<footer>
    <p>
        <?= date('Y') ?> AthleLog -
        <?=  htmlspecialchars($studentName, ENT_QUOTES, 'UTF-8') ?>
    </p>
</footer>


</body>
</html>