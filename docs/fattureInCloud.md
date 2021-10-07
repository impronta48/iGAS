# FattureInCloud README

**iGAS** può inviare fatture a **fattureincloud.it** e cancellarle.

## Come fare
Ci sono 2 modi per caricare fatture su **fattureincloud.it**:
1. Carica la fattura su **iGAS** usando il tasto `Nuova Fattura` presente alla pagina https://igas.impronta48.it/demo/fattureemesse/.
Dopo aver caricato la fattura su **iGAS**, sarà possibile inviare la fattura a **fattureincloud.it** usando il tasto `Invia a Cloud`
1. Dalla pagina delle attività http://127.0.0.1/iGAS/attivita, clicca sull'attività che vuoi modificare e poi dal menù in alto clicca su `Fatture Emesse`, dopo aver caricato la fattura su **iGAS**, sarà possibile inviare la fattura a **fattureincloud.it** usando il tasto `Invia a Cloud`

## Url di tutta la documentazione ufficiale di Fatture In CLoud utile per lo sviluppo
https://api.fattureincloud.it/v1/documentation/dist/

## Ottenere API Key e UID
Per inviare fatture a **fattureincloud.it** devi usare le API messe a disposizione e per essere utlizzate serve un'`API Key` ed un `API UID`.
Con un account di **fattureincloud.it** andare su https://secure.fattureincloud.it/api e cliccare sul tasto `MOSTRA API UID E API KEY`
Una volta ottenuta la key e l'uid modificare il file di configurazione **Config/igas.php** settando la variabile `fattureInCloud.uid` impostando il corretto UID e la variabile `fattureInCloud.key` impostando la corretta key

## API per invio fatture
L'attuale indirizzo fornito da **fattureincloud.it** per inviare fatture è https://api.fattureincloud.it/v1/fatture/nuovo.
Per agganciare **iGAS** a **fattureincloud.it**, quindi, modificare il file di configurazione **Config/igas.php** settando la variabile `fattureInCloud.fatture.nuovo` a https://api.fattureincloud.it/v1/fatture/nuovo

## API per eliminare fatture
Lattuale indirizzo fornito da **fattureincloud.it** per inviare fatture è https://api.fattureincloud.it/v1/fatture/elimina.
Per poter cancellare le fatture caricate su **fattureincloud.it** tramite **iGAS**, modificare il file **Config/igas.php** settando la variabile `fattureInCloud.fatture.elimina` a https://api.fattureincloud.it/v1/fatture/elimina