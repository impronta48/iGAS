<div class="ore view">
    <h2>Scegli un collaboratore frequente</h2>
    <table class="table table-striped">
        <th>Persone</th>

        <?php foreach ($persone as $p => $name) { ?>
            <tr>
                <td>
                    <?php echo $this->Html->link(
                        $name, ['action' => 'scegli_mese', $p]); ?>
                </td>
            </tr>
        <?php } ?>

    </table>