## Caricare scontrini su Google Drive
**iGAS** permette di caricare gli scontrini delle notespese su **Google Drive** alla pagina https://igas.impronta48.it/demo/Notaspese/add.
Al caricamento di una notaspese, se verrà Uploadato uno scontrino (in formato PNG, GIF, PNG, JPEG), oltre ad essere caricato su iGAS sarà caricato su **Google Drive**.

## Attivare le API di Google
Per utilizzare la funzionalità di Google Drive, bisogna ottentere le autorizzazioni del Service Account scaricandole da Google.
- Andare su https://console.developers.google.com mentre si è loggati con credenziali Google. 
- In questa pagina dovrebbe apparire la Dashboard delle Google API ma comunque la prima volta che si utilizza la console bisogna creare un nuovo progetto lato Google utilizzando il tasto apposito in alto nella pagina, il nome progetto può essere qualsiasi stringa.
- Una volta creato e selezionato un progetto cliccare sul pulsante `Abilita API e servizi` -> cercare `Google Drive API` ed abilitare quell'API. Alla fine di questo passaggio, nella **Dashboard**, dovresti vedere `Google Drive API` tra le API abilitate
- Andare nell'area delle **credenziali** utilizzando il link del menu di sinistra che comunque è raggiungibile tramite l'url https://console.developers.google.com/apis/credentials?project=myproject0000 ammesso che il progetto lato Google API sia stato chiamato myproject0000
- Nell'area credenziali cliccare su `Crea credenziali` e selezionare `Chiave account di servizio`, Seleziona o crea un nuovo account si servizio dando Proprietario come autorizzazioni. Infine seleziona `JSON` come tipo di chiave e Crea. Per gestire o creare account di servizio andare su https://console.developers.google.com/iam-admin/serviceaccounts?project=myproject0000 ammesso che il progetto lato Google API sia stato chiamato myproject0000
- Alla fine del passaggi precedente, se cliccato su Crea, verrà scaricato un file JSON, il json ottenuto, chiamarlo `client_secret.json` e metterlo nella cartella Config del progetto **iGAS**, se si volesse cambiare nome o path di quel file all'interno di iGAS, modificare la variabile `google.oauth` presente nel file `Config/igas.php`

## Creare la cartella padre su Google Drive dove verranno caricati gli scontrini
- Loggarsi su **Google Drive** usando user e password di Google usati per attivare le API di Google e generare il json con le credenziali
- Su https://drive.google.com/drive/my-drive creare la cartella che conterrà gli scontrini chiamandola ad esempio **Notaspese**
- Entrare in quella cartella su Drive, nella barra degli indirizzi alla fine dell'url ci sarà l'ID della cartella, prendere quell'ID e settare la variabile `google.drive.notaspese` presente nel file `Config/igas.php`.

## Workaround
- Per usufruire dell'upload su server iGAS e di conseguenza sui server di Google Drive, bisogna creare la directory `webroot/files/notaspese/` sul server di iGAS.
- Se avrai problemi a fare upload o delete su Google Drive tramite il Service Account usato, condividere la cartella creata su https://drive.google.com/drive/my-drive con l'indirizzo del Service Account come la condivideresti con un indirizzo mail di una persona reale.