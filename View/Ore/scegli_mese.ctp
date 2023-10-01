<div class="ore view">
    <h2>Persona: <?php echo $persona['Persona']['Cognome'] ?>. Ora scegli il mese</h2>
    <table class="table table-striped">
        <th>Mese</th>
        <?php for ($m = 1; $m <= 12; $m++) {
            if ($m == date('m')) {
                $evidenza = ' class="success" ';
            } else {
                $evidenza = '';
            }
            $link = $this->Html->link($m, ['action' => 'add', 
                            '?' => [
                                'persona' => $persona['Persona']['id'], 
                                'anno' => date('Y'), 
                                'mese' => $m
                            ]]);
            echo "<TR $evidenza><TD>$link</TD></TR>";
        }
        ?>
    </table>
</div>