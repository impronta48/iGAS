<?php echo $this->Html->script('//maps.google.com/maps/api/js?key=' . Configure::read('google.key'), false); ?>
<?php echo $this->Html->script('googleMaps/jquery.ui.map', false); ?>
<?php echo $this->Html->script('googleMaps/jquery.ui.map.services', false); ?>
<?php echo $this->Html->script('trasferte.js', false); ?>
<?php echo $this->Html->script('jquery.pulsate.min.js', false); ?>
<?php echo $this->Html->script("notaspese", ['inline' => false]); ?>
<?php echo $this->Js->set('url', $this->request->base); //Mi porta il path dell'applicazione nella view'
?>
<?php echo $this->Html->script('faseattivita', ['inline' => false]); ?>
<?php $baseformclass = Configure::read('iGas.baseFormClass'); ?>


<?php
//Converto la query dei mezzi in un select box complesso con tutti gli attributi che mi servono in js
foreach ($legenda_mezzi as $c) {
    $legenda_mezzi_options[$c['LegendaMezzi']['id']] = [
        'name' => $c['LegendaMezzi']['name'],
        'value' => $c['LegendaMezzi']['id'],
        'costokm' => $c['LegendaMezzi']['costokm'],
        'co2' => $c['LegendaMezzi']['co2'],
        'biglietto' => $c['LegendaMezzi']['biglietto'],
    ];
}
?>
<h1>Modifica riga di nota spese</h1>
<div class="notaspese form">
    <?php echo $this->Form->create('Notaspesa', [
        'type' => 'file',
        'inputDefaults' => [
            'div' => 'form-group',
            'label' => [
                'class' => 'col col-md-2 control-label'
            ],
            'wrapInput' => 'col col-md-7',
            'class' => 'form-control'
        ],
        'class' => 'well form-horizontal',        
    ]); ?>

    <?php echo $this->Form->input('id'); ?>
    <?php
    if (($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2)) {
        echo $this->Form->input('eRisorsa', ['default' => $eRisorsa, 'options' => $eRisorse, 'label' => 'Persona', 'class' => 'chosen-select col col-md-8']);
    } else {
        echo $this->Form->input('eRisorsa', ['value' => $this->Session->read('Auth.User.persona_id'), 'type' => 'hidden']);
        echo $this->Form->input('eRisorsaDisplay', ['placeholder' => $this->Session->read('Auth.User.Persona.DisplayName'), 'value' => $this->Session->read('Auth.User.Persona.DisplayName'), 'disabled' => true, 'label' => 'Persona', 'class' => 'form-control col col-md-8']);
    }
    ?>
    <?php //echo $this->Form->input('eRisorsa', array('options' => $eRisorse, 'label' => 'Persona', 'class'=>'chosen-select col col-md-8')); 
    ?>

    <?php
    $def = ['type' => 'date', 'dateFormat' => 'DMY', 'class' => ''];
    echo $this->Form->input('data', $def);
    ?>
    <?php
    if (($this->Session->read('Auth.User.group_id') == 1) or ($this->Session->read('Auth.User.group_id') == 2)) {
        $aggiungiAttivita = $this->Html->link(
            '<i class="fa fa-plus-square"></i> Aggiungi Attività -se non c\'è nell\'elenco',
            ['controller' => 'attivita', 'action' => 'edit'],
            ['class' => 'btn btn-xs btn-primary', 'escape' => false, 'target' => 'blank', 'tabindex' => -1]
        );
    } else {
        $aggiungiAttivita = '';
    }
    ?>
    <?php
    echo $this->Form->input(
        'eAttivita',
        [
            'options' => $eAttivita,
            'label' => ['text' => 'Attività'],
            'class' => 'col col-md-8 attivita chosen-select ' . $baseformclass, //chosen-select
            'after' => $aggiungiAttivita,
        ]
    );
    ?>
    <?php echo $this->Form->input('faseattivita_id', ['label' => 'Fase Attività', 'class' => 'fase ' . $baseformclass]); ?>
    <?php echo $this->Form->input('eCatSpesa', ['options' => $eCatSpesa, 'label' => 'Tipo di Spesa']); ?>
    <?php echo $this->Form->input('descrizione'); ?>
    <?php
    foreach (Configure::read('iGas.commonFiles') as $ext => $mimes) {
        if (file_exists(WWW_ROOT . 'files' . DS . strtolower($this->request->controller) . DS . $id . '.' . $ext)) {
            echo 'E\' già stato caricato uno scontrino. ';
            echo $this->Html->link(__('Download this ' . strtoupper($ext)), HTTP_BASE . DS . APP_DIR . DS . 'files' . DS . $this->request->controller . DS . $id . '.' . $ext, ['class' => 'btn btn-xs btn-primary']);
            echo '&nbsp;'; // Uso questo anche se non è bello perchè vedo che ogni tanto è già usato.
            echo $this->Html->link(__('Delete this ' . strtoupper($ext)), ['action' => 'deleteDoc', $id], ['class' => 'btn btn-xs btn-primary'], __('Are you sure you want to delete %s.%s?', $id, $ext));
            echo '<br />Un nuovo upload sovrascriverà il vecchio scontrino.';
        }
    }
    echo $this->Form->input('uploadFile', ['label' => 'Upload scontrino', 'class' => false, 'type' => 'file']);
    ?>
    <?php echo $this->Form->input('destinazione', ['placeholder' => 'La Spezia, IT']); ?>

    <fieldset id="spostamento">
        <legend>Spostamento</legend>
        <!-- Inserire origine del dipendente dalla sua anagrafica -->
        <?php echo $this->Form->input('origine', ['placeholder' => 'Torino, IT']); ?>
        <!-- Inserire destinazione dall'attività dalla sua anagrafica -->



        <div class="row">
            <div class="alert alert-info col col-md-offset-2 col-md-5">
                <div class="btn btn-default col col-md-3" id="NotaspesaAggiorna">Aggiorna Mappa</div>
                <div id="warnings_panel" class="col col-md-7 col-md-offset-1">
                    <i class="fa-li fa fa-spinner fa-spin"></i>Sto calcolando il percorso
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-5 col-md-offset-2">
                <div id="map_canvas" class="map ">
                </div>
            </div>
        </div>
        <br />
        <?php echo $this->Form->input('km'); ?>
        <?php echo $this->Form->input('ritorno',  [
            'type' => 'checkbox',
            'default' => 1,
            'class' => false,
            'label' => ['class' => null, 'text' => 'Ritorno: <small>se selezionato moltiplica per 2 i km (A/R)</small>'],
            'wrapInput' => 'col col-md-9 col-md-offset-2',
        ]); ?>
        <?php echo $this->Form->input('legenda_mezzi_id', [
            'options' => $legenda_mezzi_options,
            'label' => 'Il tuo mezzo',
            'after' => $this->Html->link(
                '<i class="fa fa-plus-square"></i> Aggiungi il tuo mezzo',
                ['controller' => 'legendamezzi', 'action' => 'index'],
                ['class' => 'btn btn-xs btn-primary', 'escape' => false, 'target' => 'blank', 'tabindex' => -1]
            )
        ]); ?>
        <div id="co2-calc" class="row">
            <div class="col col-md-offset-2 col-md-6">
                <table class="table table-condensed table-bordered">
                    <tr>
                        <th colspan="3" class="bg-primary">Totale CO<sub>2</sub> emessa (Kg)</th>
                    </tr>
                    <tr>
                        <th>Treno</th>
                        <th>Auto</th>
                        <th>Aereo</th>
                    </tr>

                    <tr>
                        <td id="stimato-treno"></td>
                        <td id="stimato-auto"></td>
                        <td id="stimato-aereo"></td>
                    </tr>
                </table>
            </div>
        </div>
    </fieldset>

    <?php echo $this->Form->input('importo_val', [
        'label' => 'importo in VALUTA',
        'placeholder' => '10.4',
        'beforeInput' => '<div class="input-group">',
        'afterInput' => '<span id="euro-addon" class="input-group-addon">EUR</span></div>',
        'after' => '<span class="help-block">Questa spesa <a href="javascript:;" id="non-euro">non è in Euro?</a></span>'
    ]); ?>

    <div id="non-euro-zone" class="small">
        <?php echo $this->Form->input('valuta', ['default' => 'EUR', 'wrapInput' => 'col col-md-2', 'class' => 'form-control input-sm']); ?>

        <?php
        //TODO: Incorporare l'API di conversione valuta
        $url_convertitore = "https://www.google.com/finance/converter?a=1to=EUR";
        echo $this->Form->input('tasso', [
            'default' => 1, 'wrapInput' => 'col col-md-2',
            'class' => 'form-control input-sm',
            'after' => '<span class="help-block">Visualizza il <a href="' . $url_convertitore . '" target="valuta">tasso di conversione odierno?</a><span>'
        ]); ?>

        <?php echo $this->Form->input('importo', ['label' => 'importo in EUR', 'class' => 'form-control input-sm', 'id' => 'NotaspesaModalImporto']); ?>
    </div>

    <?php echo $this->Form->input('eProvSoldi', ['options' => $eProvSoldi, 'label' => 'Provenienza Soldi', 'empty' => '- Fondi Personali -']); ?>

    <?php echo $this->Form->input('fatturabile',  [
        'type' => 'checkbox',
        'default' => 1,
        'label' => 'Fatturabile al cliente finale',
        'class' => false,
        'label' => ['class' => null],
        'wrapInput' => 'col col-md-9 col-md-offset-2',
    ]); ?>
    <?php echo $this->Form->input('rimborsabile',  [
        'type' => 'checkbox',
        'default' => 1,
        'class' => false,
        'label' => ['class' => null],
        'wrapInput' => 'col col-md-9 col-md-offset-2',
    ]); ?>

    <?php echo $this->Form->submit(__('Save'), ['class' => 'btn btn-primary col-md-offset-2']); ?>
    <?php echo $this->Form->end(); ?>
</div>

<?php $this->Html->scriptStart(['inline' => false]); ?>
$("#non-euro-zone").hide();
$("#co2-calc").hide();
mostraViaggio();

$( "#NotaspesaECatSpesa").change(function(e) {mostraViaggio();});
$( "#NotaspesaRitorno").change(function(e) {mostraPercorso();});
$( "#NotaspesaImportoVal").change(function(e) {convertiValuta();});
$( "#NotaspesaTasso").change(function(e) {convertiValuta();});
$( "#NotaspesaLegendaMezziId").change(function(e) {stimaPrezzi();});
$("#non-euro").click(function (e) {
$("#non-euro-zone").toggle();
$("#euro-addon").toggle();
return false;
}
);
<?php $this->Html->scriptEnd();
