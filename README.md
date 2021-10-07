# iGAS
iGAS - Gestione Azienda/Associazione Semplice

<p align="center">
<img width="500" alt="iGAS, cakephp2 , fatturazione" src="https://owncloud.impronta48.it/index.php/s/4XnJ6GtHQykKcrn/preview">
</p>

## Che cos'è
iGAS è un Gestionale Basato su CakePHP, pensato per il mercato italiano, con le leggi e le prassi italiane.
Permette di gestire contatti, attività, fatture, **ore**, **trasferte**, prima nota, fatture ricevute, bilancio per cassa.

## E' adatto a me?
 iGAS è adatto alle piccole **società di consulenza**, **cooperative** e **associazioni** che offrono servizi immateriali, ossia che hanno bisogno di gestire ore/spese dei collaboratori e progetti (e qualche spesa viva), ma non magazzino, beni fisici, spedizioni, etc.

### Demo
Puoi provare una demo su: http://igas.impronta48.it/demo
Richiedi un accesso a info@impronta48.it

## Licenza
iGAS è rilasciato con licenza GNU Affero General Public License v3.0
- https://choosealicense.com/licenses/agpl-3.0/
In sintesi:
	Potete usarlo liberamente, anche per scopi commerciali, modificarlo e migliorarlo.
	Tutte le modifiche che fate devono essere "restituite alla comunità" (contribuite su questo repository)
	Nessuna responsabilità può essere imputata ai programmatori o a [iMpronta](http://impronta48.it) per eventuali malfunzionamenti del software
Approfondisci in Italiano: https://it.wikipedia.org/wiki/GNU_Affero_General_Public_License

## Requisiti di installazione

- PHP: ^7.x
- php-imagick
- CakePHP: ^2.10
- https://github.com/impronta48/iGAS/: ^3.x

## Installazione
- Per installare iGAS devi avere una macchina con lo stack LAMP/WAMP/MAMP (Apache-MySQL-PHP). Ti consiglio di installare [https://www.drupalvm.com/](drupal-vm) se vuoi creare rapidamente un ambiente già configurato sulla tua macchina.
- Nella cartella del web server clona il repository GIT

```php
git clone git@github.com:impronta48/iGAS.git
```
- Crea un database vuoto e chiamalo igas_nomeazienda
- Importa nel db vuoto il db di partenza che trovi in /igas_demo.sql
- Crea il file di configurazione per il tuo db 
	- copia Config/database.php.default in Config/database.php
	- modifica il $default inserendo i tuoi parametri, come nell'esempio che segue

```php
	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'tuo_user_db',
		'password' => 'tua_password_db',		
		'database' => 'igas_nomeazienda',
		'prefix' => '',
		//'encoding' => 'utf8',
	);
```
- Configura i parametri di base per la tua azienda copiando il file Config/igas.php.default in Config/igas.php 
- Apri un terminale nella cartella principale del progetto ed aggiorna **composer**
```php
composer update
```
- rendi scrivibili le cartelle tmp e webroot
```php
# chmod -R 777 webroot
# chmod -R 777 tmp
```

## Cancellare le cache
Apri un terminale nella cartella principale del progetto ed esegui
```php
 ./Console/cake clear_cache
```

## Utilizzo di base
Per cominciare ad usare iGAS devi collegarti a http://drupalvm.test/iGAS, ti verrà richiesto uno username e una password.

L'utente base è admin la password è massimo,1

## Come modificare il codice
- Le modifiche al codice devono seguire strettamente lo standard CakePHP
- Per eseguire migrazioni sul database è necessario creare delle migrazioni phinx [https://book.cakephp.org/3.0/en/phinx.html]
```php
$ php vendor/bin/phinx create MyNewMigration
```
- Puoi segure la guida di phinx qui: https://book.cakephp.org/3.0/en/phinx/migrations.html#creating-a-new-migration

## Guida all'Uso
- Per prima cosa inserisci i dati di base nelle tabelle di servizio (che si trovano nel menu a sinistra __Tabelle di Servizio__ )
- Carica il logo dell'azienda nella cartella webroot e correggere il file igas.php
- A questo punto puoi iniziare a creare [Aree, Progetti, Attività, Fatture](docs/dati.md) (segui le istruzioni)
- Carica Ore e Trasferte sulle Attivita
- Visualizza i Report 
- Gestisci Documenti Contabili e Prima Nota
- Gestisci i Contatti

## Software Interessanti e/o Integrabili sviluppati in cakephp
- http://webzash.org/demo/webzash/entries/add/receipt (gestione partita doppia, sviluppato in cakephp), opensource
- http://adamogestionale.it/ cakephp, sviluppato da un ragazzo dell'incubatore I3P (proprietario)
- https://gestionale.gemsoft.cloud/ - Sviluppato in cakephp3 da http://www.gemsoft.cloud/ (proprietario)

## TODO
[Mappa con le funzionalità di iGAS (realizzate e da realizzare)](https://owncloud.impronta48.it/index.php/s/rKk7jTKzmQQWNkj#pdfviewer)
