# iGAS - Come Creare Aree, Progetti, Attività, Fatture

## Attivita
L'elemento centrale di iGAS è l'[Attivita]. In alcune aziende l'attività viene chiamata **Commessa** in alcune associazioni viene chiamata **Progetto**, fondamentalmente si tratta di un qualcosa su cui si possono caricare fatture, spese, ore, trasferte.
Il vincolo più importante di un'attività è: **un'attività corrisponde ad un contratto con UN (solo) cliente**
Ad esempio: "Corso di Formazione CakePHP per il cliente IBM"

## Progetto
Il progetto è un contenitore di tante attività, che possono corrispondere allo stesso cliente o a più clienti
Ad esempio: se organizzo un corso di formazione, il progetto è "Corso di Formazione CakePHP". Il progetto conterrà tante attività che corrispondo ai vari clienti a cui devo fare fattura (IBM, Microsoft e Apple)
Il progetto mi permette di tenere traccia complessivamente dell'andamento di più attività che sono collegate logicamente

## Area
Corrisponde alle "Aree di Business" della nostra azienda o associazione.
Immaginiamo di gestire un **Bar**,  fare corsi di **Formazione** e offrire **Consulenza**
Le nostre aree saranno per l'appunto: Bar, Formazione, Consulenza
l'Area ha lo scopo di tenere sotto controllo l'avanzamento dell'azienda in caso di più aree di business

## Fase
Ogni attività può essere organizzata in fasi, in modo da gestire in maniera fine l'avanzamento delle singole attività.
Es: Corso di Formazione CakePHP per cliente IBM, può avere come fasi
- Docenza
- Redazione Manuale
- Affitto Sale
- Preparazione

Ogni fase ha un budget iniziale, un valore venduto e un avanzamento.
Organizzando l'attività in questo modo i miei colleghi posso caricare le ore e le spese sulle fasi giuste e il Project Manager può controllare l'avanzamento delle singole fasi dell'attività, oltre all'attività nel suo complesso.
