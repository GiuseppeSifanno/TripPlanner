
# PROGETTO FINE ANNO

Progetto realizzato da due studenti della scuola [IISS VOLTA - DE GEMMIS](https://www.iissvoltadegemmis.edu.it/) indirizzo *INFORMATICA* della classe *5^a^ A. S. - 2023/2024*.

Gli studenti:
: Giuseppe Sifanno
: Cristian Lisi

## Scopo del progetto
Il progetto sviluppato è una piattaforma web che offre ai vari utenti, che vi accedono, la possibilità di poter creare un viaggio scegliendo le varie tappe da voler visitare.

## Tecnologie utilizzate nel progetto
Le tecnologie utilizzate sono parecchie, possiamo suddividerle per categoria:
- Front End
	- HTML + CSS & BOOTSTRAP + JAVASCRIPT
	- AJAX
	- PHP
- Back End
	- PHP
	- GOOGLE SUITE (APPS SCRIPT, DRIVE)
- Database
	- MySQL
	- GOOGLE FOGLI

Di seguito viene mostrata l'architettura logica del sistema composta da ben 4 livelli.
![Architettura](Architettura-Progetto.vpd.png)
> Lo schema è stato realizzato con [Visual Paradigm Online](https://online.visual-paradigm.com/)

*Nella figura qui sopra viene inoltre rappresentato anche il tipo di richieste e verso chi vengono fatte dai vari attori del sistema.*

## Funzionalità del client

Prendendo in considerazione il **client**, quest'ultimo può comunicare sia con il server di [Altervista](https://it.altervista.org/) che con il server [Apps Script](https://www.google.com/script/start/).
Le sue azioni sono limitate infatti non dispone di funzionalità che modificano i dati precedentemente salvati nel sistema, può solamente *creare* e *leggere*, di seguito vengono riportate in maniera più dettagliata tutte le funzionalità di cui dispone:

### [Registrarsi](#registrazione)
Un utente che non si è mai registrato può, dunque, registrarsi inserendo solamente un'email e una password. La comunicazione avviene tra il client e il server di Altervista tramite metodo POST. Una volta completata la registrazione verrà reindirizzato verso l'area privata. Una volta che l'utente compila il form, rispettando tutti i requisiti richiesti, viene contattato il server Altervista su cui gira un file PHP con uso esclusivo per l'operazione di registrazione, il comportamento del server viene spiegato <a href="#registrazioneServer">qui</a>.

### Accedere
Se un utente si è già registrato può accedere direttamente alla sua area privata inserendo email e password. La comunicazione avviene tra il client e il server di Altervista tramite metodo POST. Anche per quest'operazione viene richiamato un file con il solo scopo di gestire questa funzionalità, il suo comportamento viene presentato in maniera più dettagliata <a href="#accessoServer">qui</a>.

### Creare un viaggio
Se l'utente si è <a href="#registrazione">registrato</a> può creare un suo viaggio personale ricercando le tappe attraverso l'uso di un API e inserendo anche il nome che si vuole dare al viaggio. La ricerca dei luoghi attraverso l'API viene effettuata direttamente contattando il server Apps Script il quale si occuperà di recuperare le informazioni necessarie e di restituirle al client che le processerà e le visualizzerà creando un'apposita *card* mostrando il nome della località e nascondendo all'utente le informazioni sulla *longitudine* e *latitudine*. Una volta ricercate tutte le tappe e inserito obbligatoriamente il nome del viaggio si può inviare il form con tutte le informazioni al file PHP specifico. Per saperne di più sul procedimento lato server, clicca <a href="#creaViaggio">qui</a>.

### Visualizzare i viaggi
Visualizzare i viaggi creati è molto importante per un utente, dunque questa funzionalità si occupa proprio di questo. Il client contatterà il backend che si occuperà di restituire tutte le informazioni di un viaggio. Oltre a rappresentare le informazioni restituite del server, il client mostrerà anche una mappa, in particolare un ```<iframe>``` generato dalla piattaforma <a href="https://umap.openstreetmap.fr/it/">umap</a> che conterrà tutti i luoghi di quel preciso viaggio che si sta visualizzando.

## **Funzionalità lato server**
Le funzionalità lato server sono rese possibili attraverso l'uso di Apps Script, una piattaforma cloud di programmazione basata su JavaScript che permette di integrare le funzionalità di Google.

### Registrazione

La registrazione dei nuovi utenti è stata gestita creando per ogni nuovo utente un file Google Sheets chiamato con l'hash della sua mail concatenata alla password, rendendolo così univoco. L'hash viene passato al server tramite POST, in seguito viene controllato il folder contenente tutti i file per accertarsi che il file in questione non sia già stato creato in precedenza. Successivamente alla creazione del nuovo file, il controllo viene rieffettuato in modo che venga restituito un codice di stato che ne dimostri la riuscita.

### Creazione viaggi

La creazione dei viaggi è resa possibile attraverso due funzioni, una per la definizione del viaggio e l'altra per l'effettivo salvataggio di questo.

#### Chiamata API

Nel momento in cui l'utente inserisce la tappa desiderata, questa stringa viene passata tramite metodo GET al server. Qui viene utilizzato il servizio API offerto da <a href="https://geocode.maps.co/"> GeoCode</a> attraverso una richiesta HTTP al link del servizio con l'aggiunta della tappa da ricercare e la chiave privata che ci è stata fornita al momento della registrazione al servizio. La richiesta restituisce i dati di tutte le tappe trovate in formato JSON, da cui vengono estratte le coordinate, oltre al nome da mostrare. Questi valori vengono impostati in un oggetto JSON prima di essere restituiti al client.

### Definizione viaggio

Una volta soddisfatto delle tappe, l'utente può dare un nome al suo viaggio e confermare le sue scelte. Una volta fatto verranno passati al server i valori (o eventualmente fossero più di uno array di valori) delle coordinate e il nome dato alle mete, un nome per il viaggio e quello del file come oggetto JSON in POST. Una volta controllata l'esistenza del file, viene fatto lo stesso per il foglio, ossia il viaggio da creare. Una volta fatto viene aggiunto un header al foglio, in modo da identificare i dati inseriti nelle colonne con *Meta*, *lon*, *lat*, e successivamente con un ciclo vengono aggiunti rispettivamente i dati, estratti e parserizzati in precedenza dall'oggetto JSON.

## Visualizzazione viaggi

Ogni utente ha la possibilità di visualizzare nella rispettiva sezione i propri viaggi. Una volta che viene richiamata questa funzione, il server riceve in POST l'hash dell'utente che lo richiede e provvede a cercare e identificare il file in questione. Nel caso in cui un foglio non contenga alcun viaggio l'oggetto finale da restituire conterrà solo la stringa *empty*, altrimenti verranno estratti tutti i dati e posti in un oggetto JSON che conterrà un array di oggetti rappresentanti le mete e il nome del viaggio.
<!--stackedit_data:
eyJoaXN0b3J5IjpbLTU2MzUyNzc1MSwtMTQ1MzU0Njk3NywtMT
M1MTE5NzIxMSwtMTE4Mzg0MDgzLC0xMTM3MTk4OTY4LDE4NjI0
MDU4NzYsMTg0ODUyODIyNCwxNTQ1NTAxOTc0LC0xNzc0NTkwNj
UyLC0xNDU0NDA5MzY2LC0xOTQ5MzgwNDU3LDYzNDAxMzU3Nywx
MjU4NTY1MDYsMzI2NzkwMzg2LDE5NDUzNDU0OTIsLTEwMDY0Nz
k0OCwyMDU0NTAzNjE4LDE4MjU4MDE4MCwxNDUxNjQ4MjksLTE2
MDY2OTc5MjhdfQ==
-->
