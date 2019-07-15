<h1 id="DisplayName"><?php echo $persona['DisplayName'] ?> <?php echo $this->Html->image($profilePath, array('class'=>'', 'style' => 'border-radius: 50%; border: 3px solid #ffffff; width:50px', 'alt'=>'')); ?></h1>
<hr>
<?php //debug($persona); ?>
<div class="row">
<div class="col-md-12"><div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                Informazioni di Base
                <span class="pull-right">
                <a href="#" class="panel-minimize"><i class="fa fa-chevron-down"></i></a>
                </span>
            </h3>
        </div>

        <div class="panel-body collapse">
        <table class="table table-sm">
        <tr><th scope="row">Nome</th><td><?php echo $persona['Nome']; ?></td></tr>
        <tr><th scope="row">Cognome</th><td><?php echo $persona['Cognome']; ?></td></tr>
        <tr><th scope="row">Sesso</th><td><?php echo $persona['Sex']; ?></td></tr>
        <tr><th scope="row">Società</th><td><?php echo $persona['Societa']; ?></td></tr>
        <tr><th scope="row">Titolo</th><td><?php echo $persona['Titolo']; ?></td></tr>
        <tr><th scope="row">Carica</th><td><?php echo $persona['Carica']; ?></td></tr>
        <tr><th scope="row">Data di nascita</th><td><?php echo $persona['DataDiNascita']; ?></td></tr>
        <tr><th scope="row">Tags</th><td><?php echo $persona['tags']; ?></td></tr>
        <tr><th scope="row">Nota</th><td><?php echo $persona['Nota']; ?></td></tr>
        </table>
        </div>
        </div>
</div>
</div>

<div class="row">
<div class="col-md-12"><div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                Indirizzo Principale
                <span class="pull-right">
                <a href="#" class="panel-minimize"><i class="fa fa-chevron-down"></i></a>
                </span>
            </h3>
        </div>

        <div class="panel-body collapse">
        <table class="table table-sm">
        <tr><th scope="row">Indirizzo</th><td><?php echo $persona['Indirizzo']; ?></td></tr>
        <tr><th scope="row">CAP</th><td><?php echo $persona['CAP']; ?></td></tr>
        <tr><th scope="row">Città</th><td><?php echo $persona['Citta']; ?></td></tr>
        <tr><th scope="row">Provincia</th><td><?php echo $persona['Provincia']; ?></td></tr>
        <tr><th scope="row">Nazione</th><td><?php echo $persona['Nazione']; ?></td></tr>
        </table>
        </div>
        </div>
</div>
</div>

<div class="row">
<div class="col-md-12"><div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                Altro Indirizzo
                <span class="pull-right">
                <a href="#" class="panel-minimize"><i class="fa fa-chevron-down"></i></a>
                </span>
            </h3>
        </div>

        <div class="panel-body collapse">
        <table class="table table-sm">
        <tr><th scope="row">Indirizzo</th><td><?php echo $persona['altroIndirizzo']; ?></td></tr>
        <tr><th scope="row">CAP</th><td><?php echo $persona['altroCap']; ?></td></tr>
        <tr><th scope="row">Città</th><td><?php echo $persona['altraCitta']; ?></td></tr>
        <tr><th scope="row">Provincia</th><td><?php echo $persona['altraProv']; ?></td></tr>
        <tr><th scope="row">Nazione</th><td><?php echo $persona['altraNazione']; ?></td></tr>
        </table>
        </div>
        </div>
</div>
</div>

<div class="row">
<div class="col-md-12"><div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">
                Contatti Telefonici
                <span class="pull-right">
                <a href="#" class="panel-minimize"><i class="fa fa-chevron-down"></i></a>
                </span>
            </h3>
        </div>

        <div class="panel-body collapse">
        <table class="table table-sm">
        <tr><th scope="row">Cellulare</th><td><?php echo $persona['Cellulare']; ?></td></tr>
        <tr><th scope="row">Telefono Ufficio</th><td><?php echo $persona['TelefonoUfficio']; ?></td></tr>
        <tr><th scope="row">Telefono Domicilio</th><td><?php echo $persona['TelefonoDomicilio']; ?></td></tr>
        <tr><th scope="row">Fax</th><td><?php echo $persona['Fax']; ?></td></tr>
        </table>
        </div>
        </div>
</div>
</div>

<div class="row">
<div class="col-md-12"><div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                Contatti Internet
                <span class="pull-right">
                <a href="#" class="panel-minimize"><i class="fa fa-chevron-down"></i></a>
                </span>
            </h3>
        </div>

        <div class="panel-body collapse">
        <table class="table table-sm">
        <tr><th scope="row">Sito Internet</th><td><?php echo $persona['SitoWeb']; ?></td></tr>
        <tr><th scope="row">Email</th><td><?php echo $persona['EMail']; ?></td></tr>
        <tr><th scope="row">I M</th><td><?php echo $persona['IM']; ?></td></tr>
        </table>
        </div>
        </div>
</div>
</div>

<div class="row">
<div class="col-md-12"><div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                Cliente
                <span class="pull-right">
                <a href="#" class="panel-minimize"><i class="fa fa-chevron-down"></i></a>
                </span>
            </h3>
        </div>

        <div class="panel-body collapse">
        <table class="table table-sm">
        <tr><th scope="row">Partita IVA</th><td><?php echo $persona['piva']; ?></td></tr>
        <tr><th scope="row">Codice Fiscale</th><td><?php echo $persona['cf']; ?></td></tr>
        <tr><th scope="row">Indirizzo Posta PEC</th><td><?php echo $persona['indirizzoPEC']; ?></td></tr>
        <tr><th scope="row">Ente Pubblico</th><td><?php echo ($persona['EntePubblico']) ? 'SI' : 'NO'; ?></td></tr>
        <tr><th scope="row">Codice Destinatario SDI / Codice IPA</th><td><?php echo $persona['codiceIPA']; ?></td></tr>
        </table>
        </div>
        </div>
</div>
</div>

<div class="row">
<div class="col-md-12"><div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                Dati bancari
                <span class="pull-right">
                <a href="#" class="panel-minimize"><i class="fa fa-chevron-down"></i></a>
                </span>
            </h3>
        </div>

        <div class="panel-body collapse">
        <table class="table table-sm">
        <tr><th scope="row">IBAN</th><td><?php echo $persona['iban']; ?></td></tr>
        <tr><th scope="row">Nome Banca</th><td><?php echo $persona['NomeBanca']; ?></td></tr>
        </table>
        </div>
        </div>
</div>
</div>

<div class="row">
<div class="col-md-12"><div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                Storia
                <span class="pull-right">
                <a href="#" class="panel-minimize"><i class="fa fa-chevron-down"></i></a>
                </span>
            </h3>
        </div>

        <div class="panel-body collapse">
        <table class="table table-sm">
        <tr><th scope="row">Ultimo Contatto</th><td><?php echo $persona['UltimoContatto']; ?></td></tr>
        <tr><th scope="row">Ultima Modifica</th><td><?php echo $persona['modified']; ?></td></tr>
        <tr><th scope="row">Data di creazione</th><td><?php echo $persona['created']; ?></td></tr>
        </table>
        </div>
        </div>
</div>
</div>