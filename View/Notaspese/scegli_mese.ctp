<div class="notaspese view">
    <h2>Persona: <?php echo $persona['Persona']['DisplayName'] ?>. Ora scegli il mese</h2>
    <table class="table table-striped">
        <th>Mese</th>
<?php for ($m = 1; $m <=12 ; $m++)
{

    if ($m == date('m')) {

        $evidenza= ' class="success" ';
    }

    else {

        $evidenza= '';
    }

    echo "<TR $evidenza><TD>" . $this->Html->link($m, array('action' => 'add', 'persona'=>$this->request->pass[0], 'anno'=>date('Y'), 'mese'=>$m)) . "</TD></TR>";
}
?>
        </table>
</div>
