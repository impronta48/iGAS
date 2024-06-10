<h2>Scontrini caricati</h2>
        
<?php foreach ($attachments as $a) : ?>
    <h5><?= basename($a) ?></h5>
    <?php //if file extension is pdf
    if (pathinfo($a, PATHINFO_EXTENSION) == 'pdf') {
        $a = $this->PdfToImage->pdfToImageImagick(WWW_ROOT . $a);
        //Remove WWW_ROOT from $a
        $a = str_replace(WWW_ROOT, '', $a);
    }
    ?>    
    <?php $s = FULL_BASE_URL; ?>
    <img src="<?= "$s/$a"?>" style="height:440px">            
<?php endforeach; ?>