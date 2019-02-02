<li>
    <a class="dropdown" href="#" data-original-title="Attività">
        <i class='fa fa-bullseye'></i><span class="hidden-minibar">Attività</span>
    </a>    
    <ul>
        <li id="menu-attivita">
        <?php echo $this->Html->link("<i class='fa fa-book'></i><span class='hidden-minibar'>Lista Attività</span>", '/attivita',array('escape' => false, 'data-original-title'=>'Attività')) ?>
        </li>
        <li><?php echo $this->Html->link("<i class='fa fa-bolt'></i>". __('Nuova Attività'), '/attivita/edit', array('data-original-title'=>'Nuova Attività','escape' => false)); ?></li>    
        <li><?php echo $this->Html->link("<i class='fa fa-building'></i><span class='hidden-minibar'> Progetti</span>", '/progetti',array('escape' => false, 'data-original-title'=>'Progetti')) ?></li>
        <li><?php echo $this->Html->link('<i class="fa fa-arrow-circle-o-right"></i> Aree', '/aree', array('data-original-title'=>'Aree','escape' => false)) ?></li>
    </ul>
</li>

<li>
    <a class="dropdown" href="#" data-original-title="Contatti">
        <i class='fa fa-user'></i><span class="hidden-minibar">Contatti</span>
    </a>    
    <ul>
        <li><?php echo $this->Html->link("<i class='fa fa-user'></i><span class='hidden-minibar'> Contatti</span>", '/persone',array('escape' => false, 'data-original-title'=>'Contatti')) ?></li>
        <li><?php echo $this->Html->link("<i class='fa fa-user'></i><span class='hidden-minibar'> Impiegati</span>", '/impiegati',array('escape' => false, 'data-original-title'=>'Impiegati')) ?></li>        
    </ul>
</li>

<li>
    <a class="dropdown" href="#" data-original-title="Ore e Spese">
        <i class='fa fa-clock-o'></i><span class="hidden-minibar">Ore e Spese</span>
    </a>    
    <ul>
            <li><?php echo $this->Html->link("<i class='fa fa-bolt'></i><span class='hidden-minibar'> Inserisci Mie Ore</span>", '/ore/add/',array('escape' => false, 'data-original-title'=>'Inserici Ore')) ?></li>
            <li><?php echo $this->Html->link("<i class='fa fa-clock-o'></i><span class='hidden-minibar'> Inserisci Ore</span>", '/ore/scegli_persona',array('escape' => false, 'data-original-title'=>'Inserici Ore')) ?></li>
            <li><?php echo $this->Html->link("<i class='fa fa-table'></i><span class='hidden-minibar'> Gestione Foglio Ore</span>", '/ore/riassuntocaricamenti/'. date("Y"),array('escape' => false, 'data-original-title'=>'Gestione Foglio Ore')) ?></li>
            <li><?php echo $this->Html->link("<i class='fa fa-briefcase'></i><span class='hidden-minibar'> Nota Spese</span>", '/notaspese/scegli_persona',array('escape' => false, 'data-original-title'=>'Nota Spese')) ?></li>
    </ul>
</li>

<li>
    <a class="dropdown" href="#" data-original-title="Documenti">
        <i class='fa fa-file'></i><span class="hidden-minibar">Documenti</span>
    </a>    
    <ul>

    <li><?php echo $this->Html->link("<i class='fa fa-file-text'></i><span class='hidden-minibar'> Documenti Ricevuti</span>", '/fatturericevute/?anno=' . date('Y'),array('escape' => false, 'data-original-title'=>'Fatture Ricevute')) ?></li>
    <li><?php echo $this->Html->link("<i class='fa fa-euro'></i><span class='hidden-minibar'> Prima Nota</span>", '/primanota/?from='. date('Y-m-d', strtotime('first day of last month')),array('escape' => false, 'data-original-title'=>'Prima Nota')) ?></li>
</ul>

<li  >
    <a class="dropdown" href="#" data-original-title="Report">
        <i class='fa fa-bullseye'></i><span class="hidden-minibar">Report</span>
    </a>    
<ul>
    <li><?php echo $this->Html->link('<i class="fa fa-arrow-circle-o-right"></i> Statistiche Ore', '/ore/stats?from='. date('Y-m-d', strtotime('first day of last month')), array('data-original-title'=>'Statistiche Ore','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-arrow-circle-o-right"></i> Statistiche Note Spese', '/notaspese/stats?from='. date('Y-m-d', strtotime('first day of last month')), array('data-original-title'=>'Statistiche Note Spese','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-arrow-circle-o-right"></i> Fatture Emesse (Elenco)', '/fattureemesse/index/anno:' . date('Y'), array('data-original-title'=>'Fatture Emesse Elenco','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-calendar"></i> Fatture Emesse (Scad.)', '/fattureemesse/scadenziario/' . date('Y'), array('data-original-title'=>'Fatture Emesse Scadenziario','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-book"></i> Prima Nota (Per mese)', '/primanota/totalimese/' . date('Y'), array('data-original-title'=>'Totali per Mese Prima Nota','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-eur"></i> Ore per Attivita', '/ore/attivita/', array('data-original-title'=>'Ore per Attivita','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-eur"></i> Avanzamento Generale', '/attivita/avanzamento_gen', array('data-original-title'=>'Avanzamento Generale','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-eur"></i> Offerto Acquistio', '/attivita/offerto_acquisito?anno='. date('Y'), array('data-original-title'=>'Avanzamento Generale','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-eur"></i> Bilancio', '/primanota/bilancio/anno:' . date('Y') , array('data-original-title'=>'Bilancio','escape' => false)) ?></li> 
    <li><?php echo $this->Html->link('<i class="fa fa-eur"></i> Prima Nota Per Anno', '/primanota/per_anno', array('data-original-title'=>'Prima Nota Per Anno','escape' => false)) ?></li> 
    <li><?php echo $this->Html->link('<i class="fa fa-eur"></i> Pivot Bilancio', '/primanota/pivot/' . date('Y'), array('data-original-title'=>'Pivot Bilancio','escape' => false)) ?></li>
</ul>
</li>    
<li >
    <a class='dropdown' href='#' data-original-title='Utilità'>
  		<i class='fa fa-gears'></i><span class='hidden-minibar'> Tabelle di Servizio </span>
    </a>
<ul>    
    
    <li><?php echo $this->Html->link('<i class="fa fa-arrow-circle-o-right"></i> Alias', '/aliases', array('data-original-title'=>'Alias','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-arrow-circle-o-right"></i> Banche', '/provenienzesoldi', array('data-original-title'=>'Banche','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-arrow-circle-o-right"></i> Codici Iva', '/legendaCodiciIva', array('data-original-title'=>'Codici Iva','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-arrow-circle-o-right"></i> Categorie Spesa', '/LegendaCatSpesa', array('data-original-title'=>'Categorie Spesa','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-truck"></i> Mezzi', '/legenda_mezzi', array('data-original-title'=>'Legenda Mezzi','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-truck"></i> Vettori', '/vettori', array('data-original-title'=>'Vettori','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-truck"></i> Porto', '/legenda_porto', array('data-original-title'=>'Porto','escape' => false)) ?></li>
    <li><?php echo $this->Html->link('<i class="fa fa-truck"></i> Causali Trasporto', '/legenda_causale_trasporto', array('data-original-title'=>'Causali Trasporto','escape' => false)) ?></li>    
    <li><?php echo $this->Html->link('<i class="fa fa-file-text"></i> Tipi Documento', '/legenda_tipo_documento', array('data-original-title'=>'Legenda Tipo Documento','escape' => false)) ?></li>    
    <li><?php echo $this->Html->link('<i class="fa fa-file-text"></i> Unita di Misura', '/legendaUnitaMisura', array('data-original-title'=>'Legenda Unità di Misura','escape' => false)) ?></li>    
    <li><?php echo $this->Html->link('<i class="fa fa-file-text"></i> Chiudi Attività Aperte', '/attivita/chiudi_aperte', array('data-original-title'=>'Chiudi attività aperte','escape' => false)) ?></li>    
</ul>
</li>

<!-- <li><?php echo $this->Html->link("<i class='fa fa-gift'></i><span class='hidden-minibar'> Ordini</span>", '/ordini',array('escape' => false, 'data-original-title'=>'Ordini')) ?></li>
 <li><?php echo $this->Html->link("<i class='fa fa-truck'></i><span class='hidden-minibar'> DdT</span>", '/ddt',array('escape' => false, 'data-original-title'=>'DdT')) ?></li>
 -->
