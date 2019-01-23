# iGAS - Come Creare Aree, Progetti, Attivit�, Fatture

## Attivita
L'elemento centrale di iGAS � l'[Attivita]. In alcune aziende l'attivit� viene chiamata **Commessa** in alcune associazioni viene chiamata **Progetto**, fondamentalmente si tratta di un qualcosa su cui si possono caricare fatture, spese, ore, trasferte.
Il vincolo pi� importante di un'attivit� �: **un'attivit� corrisponde ad un contratto con UN (solo) cliente**
Ad esempio: "Corso di Formazione CakePHP per il cliente IBM"

## Progetto
Il progetto � un contenitore di tante attivit�, che possono corrispondere allo stesso cliente o a pi� clienti
Ad esempio: se organizzo un corso di formazione, il progetto � "Corso di Formazione CakePHP". Il progetto conterr� tante attivit� che corrispondo ai vari clienti a cui devo fare fattura (IBM, Microsoft e Apple)
Il progetto mi permette di tenere traccia complessivamente dell'andamento di pi� attivit� che sono collegate logicamente

## Area
Corrisponde alle "Aree di Business" della nostra azienda o associazione.
Immaginiamo di gestire un **Bar**,  fare corsi di **Formazione** e offrire **Consulenza**
Le nostre aree saranno per l'appunto: Bar, Formazione, Consulenza
l'Area ha lo scopo di tenere sotto controllo l'avanzamento dell'azienda in caso di pi� aree di business

## Fase
Ogni attivit� pu� essere organizzata in fasi, in modo da gestire in maniera fine l'avanzamento delle singole attivit�.
Es: Corso di Formazione CakePHP per cliente IBM, pu� avere come fasi
- Docenza
- Redazione Manuale
- Affitto Sale
- Preparazione

Ogni fase ha un budget iniziale, un valore venduto e un avanzamento.
Organizzando l'attivit� in questo modo i miei colleghi posso caricare le ore e le spese sulle fasi giuste e il Project Manager pu� controllare l'avanzamento delle singole fasi dell'attivit�, oltre all'attivit� nel suo complesso.
