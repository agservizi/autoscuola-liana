<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/db.php';

// requireAdmin(); // Commentato per esecuzione CLI

// Corso per Patente A1-A-B
$course_name = 'Patente A1-A-B';
$course_description = 'Corso di teoria per il conseguimento delle patenti A1, A e B';

// Inserisci corso
$stmt = $db->prepare("INSERT INTO courses (name, description, created_at) VALUES (?, ?, NOW())");
$stmt->execute([$course_name, $course_description]);
$course_id = $db->lastInsertId();

echo "Corso creato: $course_name (ID: $course_id)\n";

// Lezioni basate sul manuale
$lessons = [
    1 => ['title' => 'Definizioni Stradali e di Traffico', 'content' => 'Questa lezione introduce le definizioni fondamentali stradali e di traffico, inclusi termini come carreggiata, corsia, incrocio, ecc.'],
    2 => ['title' => 'Segnali di Pericolo', 'content' => 'I segnali di pericolo avvertono di situazioni rischiose sulla strada, come curve, incroci, animali, ecc.'],
    3 => ['title' => 'Segnali di Precedenza', 'content' => 'Questi segnali regolano la precedenza agli incroci, come dare precedenza, stop, ecc.'],
    4 => ['title' => 'Segnali di Divieto', 'content' => 'Segnali che vietano determinate azioni, come divieto di sosta, limite di velocità, ecc.'],
    5 => ['title' => 'Segnali di Obbligo', 'content' => 'Segnali che impongono comportamenti obbligatori, come direzione obbligatoria, obbligo di fermata, ecc.'],
    6 => ['title' => 'Segnali di Indicazione', 'content' => 'Segnali che forniscono informazioni utili, come indicazioni stradali, servizi, ecc.'],
    7 => ['title' => 'Segnali Temporanei e di Cantiere', 'content' => 'Segnali utilizzati in cantieri stradali o situazioni temporanee.'],
    8 => ['title' => 'Segnali Complementari', 'content' => 'Segnali che integrano altri segnali, come pannelli aggiuntivi.'],
    9 => ['title' => 'Pannelli Integrativi dei Segnali', 'content' => 'Pannelli che specificano o limitano l\'applicazione dei segnali principali.'],
    10 => ['title' => 'Semafori (lanterne semaforiche), segnali manuali degli Agenti', 'content' => 'Regole per rispettare i semafori e i segnali degli agenti di polizia.'],
    11 => ['title' => 'Segnaletica Orizzontale e Segni sugli Ostacoli', 'content' => 'Linee stradali, strisce pedonali, segnaletica orizzontale.'],
    12 => ['title' => 'Pericolo e intralcio alla circolazione, Velocità, Distanza di sicurezza, Limiti di velocità', 'content' => 'Norme sulla velocità, distanza di sicurezza, comportamenti in caso di pericolo.'],
    13 => ['title' => 'Posizione dei veicoli sulla carreggiata, Cambio di corsia e di direzione, Svolta, Comportamento agli incroci, Convogli militari e cortei', 'content' => 'Regole per la posizione sulla strada, cambi di direzione, incroci.'],
    14 => ['title' => 'Norme sulla precedenza (incroci)', 'content' => 'Regole dettagliate sulla precedenza agli incroci.'],
    15 => ['title' => 'Sorpasso', 'content' => 'Norme per effettuare il sorpasso in sicurezza.'],
    16 => ['title' => 'Fermata e Sosta, Arresto e Partenza', 'content' => 'Differenze tra fermata e sosta, regole per parcheggio.'],
    17 => ['title' => 'Ingombro della carreggiata, Segnalazione di veicolo fermo', 'content' => 'Come segnalare un veicolo fermo, evitare ingombri.'],
    18 => ['title' => 'Circolazione sulle Strade extraurbane Principali e sulle Autostrade', 'content' => 'Norme specifiche per autostrade e strade extraurbane.'],
    19 => ['title' => 'Dispositivi di equipaggiamento (luci, clacson), funzione ed uso', 'content' => 'Uso corretto di luci, clacson e altri dispositivi.'],
    20 => ['title' => 'Spie e Simboli sui comandi', 'content' => 'Significato delle spie sul cruscotto.'],
    21 => ['title' => 'Cinture di Sicurezza, Sistemi di Ritenuta, Airbag, Casco Protettivo', 'content' => 'Importanza e uso delle cinture, airbag, caschi.'],
    22 => ['title' => 'Trasporto di Persone, Carico dei Veicoli, Pannelli sui veicoli, Traino dei veicoli in avaria', 'content' => 'Regole per trasporto passeggeri, carico, traino.'],
    23 => ['title' => 'Patenti di Guida, Provvedimenti di revisione, revoca, ritiro e sospensione della patente, Carta di Circolazione', 'content' => 'Norme sulle patenti e documenti di circolazione.'],
    24 => ['title' => 'Obbligo verso funzionari ed agenti, Documenti di Guida, Uso di Occhiali', 'content' => 'Rispetto delle autorità, documenti richiesti.'],
    25 => ['title' => 'Cause più frequenti di incidenti stradali, Corretto uso della strada', 'content' => 'Analisi delle cause di incidenti e prevenzione.'],
    26 => ['title' => 'Comportamento in caso di incidente, Responsabilità Civile e Penale, Assicurazione R.C.A.', 'content' => 'Cosa fare in caso di incidente, responsabilità.'],
    27 => ['title' => 'Stato fisico del Conducente, Effetti dell\'Alcool e delle Sostanze Stupefacenti, Primo Soccorso', 'content' => 'Questa lezione riguarda argomenti sanitari sotto due aspetti: anzitutto si considera l\'influenza che possono avere sulla guida le condizioni fisiche del conducente in relazione alla stanchezza, all\'uso di farmaci, all\'assunzione di alcool e di droghe. Nella seconda parte vengono esaminate essenziali norme di primo soccorso da applicare in caso di infortunio o di incidente. CHI ACCUSA SEGNI DI STANCHEZZA DEVE: Ridurre la velocità (non tenerla sostenuta, cioè elevata) e spostarsi verso il margine destro per raggiungere la prima piazzola di sosta e riposare; ove necessario, fermarsi anche sulla corsia per la sosta di emergenza. I FARMACI PER IL MAL D\'AUTO Possono provocare al conducente sonnolenza e diminuzione dell\'attenzione, quindi riduzione dei riflessi e allungamento dei tempi di reazione (oltre alla scomparsa del senso di nausea si verificano effetti collaterali incompatibili con la guida). SE SI STANNO SEGUENDO TERAPIE (CURE) CON FARMACI AD AZIONE SEDATIVA Occorre accertarsi delle eventuali controindicazioni alla guida (leggendo il foglietto illustrativo annesso al farmaco). Se non esistono controindicazioni, si può guidare, pur continuando a prendere il farmaco, purché la malattia (stato patologico) che ha dato luogo alla cura (terapia) sia compatibile con la guida, non comprometta le capacità di guida e le condizioni fisiche siano adeguate. ASSUNZIONE DI ALCOOL E GUIDA IN STATO DI EBBREZZA (UBRIACHEZZA) L\'assunzione di alcool influenza la guida in quanto la rende meno sicura poiché può indurre eccitazione (euforia) ed imprudenza (mancato senso del pericolo); inoltre può indurre sonnolenza, altera la capacità di concentrazione e di attenzione; rende meno rapidi i riflessi; comporta pericolo grave per la circolazione e quindi costituisce un reato punito con l\'arresto di un mese, un\'ammenda e anche con la sospensione della patente; può essere accertata con alcooltest (etilometro) a cui è obbligatorio sottoporsi. GUIDA SOTTO L\'INFLUENZA DI SOSTANZE STUPEFACENTI È vietato guidare in condizioni di alterazione fisica e psichica in conseguenza dell\'uso di sostanze stupefacenti che alterano i riflessi, la coordinazione dei movimenti e le percezioni (vista, udito, ecc.). L\'uso di tali sostanze, inoltre, può causare sonnolenza od eccitazione (euforia). Chi ha fatto uso abituale di droghe (anche se leggere) può conseguire o conservare qualsiasi categoria di patente solo se dimostra di avere smesso stabilmente. A tal fine dovrà sottoporsi ad accertamenti presso la commissione medica locale (composta da più medici) che dovrà accertare che il soggetto non è più tossicodipendente. IL MANCATO SENSO DEL PERICOLO DURANTE LA GUIDA PUÒ ESSERE DATO DA: Abuso di alcool (e non di bevande analcoliche o di caffè); uso di stupefacenti; uso di farmaci sedativi (ad esempio: quelli per il mal d\'auto) o di sonniferi. PRIMO SOCCORSO Soccorrere un infortunato della strada è un dovere imposto dal codice penale che ne punisce l\'omissione, nonché un comportamento che dimostra senso civico (obbligo morale). Il fine del primo soccorso è quindi quello di attuare semplici ed immediate misure di sopravvivenza, assistendo la vittima in attesa di più adeguati soccorsi. È inoltre importante evitare che la vittima subisca ulteriori lesioni ed impedire che siano posti in atto interventi errati da parte di altre persone. A tal fine occorrerà segnalare l\'incidente, chiamare i soccorsi qualificati, assistendo e proteggendo la vittima come meglio si può, senza prendere iniziative di competenza medica (come ad esempio: somministrare farmaci, mettere la vittima in posizione comoda o spostarla se non proprio necessario).'],
    28 => ['title' => 'Limitazione dei consumi, Inquinamento (atmosferico e acustico) dell\'ambiente', 'content' => 'Una guida responsabile comporta anche un elementare rispetto dell\'ambiente che può ottenersi limitando l\'inquinamento atmosferico e acustico. Tale comportamento riveste anche un interesse economico perché va di pari passo con la riduzione dei consumi. PER LIMITARE I CONSUMI DI CARBURANTE OCCORRE: Ridurre la velocità di marcia e mantenerla il più possibile costante (riducendo il numero e l\'intensità delle accelerazioni). Conviene scegliere percorsi pianeggianti, ridurre i carichi inutili, eliminare i bagagli sul tetto ed è opportuno tenere i finestrini chiusi (per evitare che l\'aria, entrando dentro l\'abitacolo, riduca la velocità del veicolo). INQUINAMENTO ATMOSFERICO PRODOTTO DAI VEICOLI Per ridurre l\'inquinamento atmosferico occorre limitare i gas di scarico (limitando i consumi di carburante) e la presenza di sostanze nocive (ottimizzando la combustione del carburante e mantenendo il motore efficiente). Inoltre occorre: tenere un\'andatura il più possibile uniforme e ridurre il numero e l\'intensità delle accelerazioni; non sovraccaricare il veicolo; limitare ragionevolmente la velocità di marcia; spegnere il motore in caso di arresto prolungato, specie se in galleria.'],
    29 => ['title' => 'Elementi costitutivi del veicolo (pneumatici, ammortizzatori, sterzo, freni)', 'content' => 'Per conseguire le patenti A1, A e B non è necessario possedere approfondite conoscenze sul motore a scoppio e sulla struttura dei veicoli; gli argomenti "meccanici" su cui si soffermano i quiz ministeriali, infatti, riguardano soltanto: pneumatici, ammortizzatori, sterzo e freni. SUI PNEUMATICI OCCORRE SPESSO VERIFICARE: Il loro aspetto esterno (e non il loro peso o i risultati dell\'esame radiografico, cioè le lastre a raggi x); l\'eventuale presenza di lesioni che interessano la carcassa (tutta la struttura del pneumatico); il consumo del battistrada (parte del pneumatico che poggia sulla strada) e che sia uniforme (osservare se il pneumatico si consuma soprattutto ai bordi, perché la pressione è troppo bassa, o al centro, perché troppo alta); lo stato dei fianchi e dei talloni (parte terminale dei fianchi) per prevenire scoppi o cedimenti; la pressione di gonfiaggio (che deve essere uguale a quella consigliata dal costruttore) e l\'assenza di perdita d\'aria. I PNEUMATICI CON BATTISTRADA USURATO I pneumatici con battistrada (la parte che poggia sulla strada) eccessivamente usurato (consumato): aumentano la probabilità di incidenti stradali; sono più soggetti alla foratura e allo scoppio; aumentano la probabilità di perdita di aderenza in caso di pioggia (aquaplaning) e la possibilità di slittamento in curva; inoltre, influiscono negativamente sulla frenatura del veicolo (aumentando lo spazio di frenatura).'],
    30 => ['title' => 'Stabilità e tenuta di strada del veicolo', 'content' => 'Contribuiscono alla maggiore o minore stabilità e tenuta di strada di un veicolo fattori di natura tecnica (pressione e consumo dei pneumatici, convergenza ed equilibratura delle ruote, equilibratura del sistema frenante, giochi negli organi di sterzo, efficienza delle sospensioni, altezza del baricentro), ambientale (fondo stradale bagnato o ghiacciato, presenza di neve, fango, pietrisco, foglie o olio) e di comportamento del conducente (velocità, uso della frizione, del freno e dello sterzo). L\'ADERENZA (CONTATTO) DELLE RUOTE SUL MANTO STRADALE È RIDOTTA DA: Pneumatici consumati (con basso spessore del battistrada); strada bagnata; presenza di olio sulla carreggiata; presenza di melma (fango), di foglie o di ghiaia sul fondo stradale; presenza di neve o di ghiaccio. PER ASSICURARE STABILITÀ AL VEICOLO IN CURVA È OPPORTUNO: Ridurre o eliminare i bagagli sul tetto (per abbassare il baricentro del veicolo); ridurre la velocità prima della curva (nella parte iniziale) e percorrere la curva (se ad ampio raggio) con il motore leggermente in tiro (in accelerazione) per aumentare l\'aderenza, oppure procedere a velocità particolarmente moderata se la curva è stretta (a piccolo raggio); evitare di sterzare bruscamente e di procedere con il pedale della frizione abbassato (per evitare un aumento di velocità del veicolo, specie se in discesa); usare pneumatici in buono stato (con adeguato spessore di battistrada).'],
];

foreach ($lessons as $lesson_number => $lesson_data) {
    $stmt = $db->prepare("INSERT INTO lessons (course_id, title, content, lesson_order, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$course_id, $lesson_data['title'], $lesson_data['content'], $lesson_number]);
    $lesson_id = $db->lastInsertId();

    echo "Lezione $lesson_number creata: {$lesson_data['title']} (ID: $lesson_id)\n";

    // Crea quiz per la lezione
    $quiz_title = "Quiz Lezione $lesson_number";
    $stmt = $db->prepare("INSERT INTO quizzes (course_id, title, time_limit, created_at) VALUES (?, ?, 30, NOW())");
    $stmt->execute([$course_id, $quiz_title]);
    $quiz_id = $db->lastInsertId();

    echo "Quiz creato: $quiz_title (ID: $quiz_id)\n";

    // Domande basate sul contenuto della lezione
    $questions = [];
    switch ($lesson_number) {
        case 1:
            $questions = [
                ['question' => 'Cosa comprende la strada secondo la definizione?', 'options' => ['Solo carreggiate', 'Carreggiate, banchine, marciapiedi e piste ciclabili', 'Solo marciapiedi', 'Solo piste ciclabili'], 'correct' => 1],
                ['question' => 'Qual è la larghezza minima di una corsia?', 'options' => ['2 metri', '2.80 metri', '3 metri', '4 metri'], 'correct' => 1],
                ['question' => 'Nella corsia di accelerazione sono vietati:', 'options' => ['La marcia', 'La sosta e il sorpasso', 'L\'ingresso', 'Il rallentamento'], 'correct' => 1],
                ['question' => 'Che cos\'è un attraversamento pedonale?', 'options' => ['Una pista ciclabile', 'Una serie di strisce bianche parallele', 'Un marciapiede', 'Una banchina'], 'correct' => 1],
                ['question' => 'Che cos\'è un passaggio a livello?', 'options' => ['Incrocio con autostrada', 'Incrocio con linea ferroviaria', 'Incrocio con pista ciclabile', 'Incrocio con marciapiede'], 'correct' => 1],
            ];
            break;
        case 2:
            $questions = [
                ['question' => 'I segnali di pericolo hanno forma:', 'options' => ['Triangolare con vertice in alto', 'Circolare', 'Quadrata', 'Rettangolare'], 'correct' => 0],
                ['question' => 'Dove sono posti i segnali di pericolo?', 'options' => ['50m prima', '100m prima', '150m prima', 'Sul pericolo'], 'correct' => 2],
                ['question' => 'Il segnale di dosso indica:', 'options' => ['Strada deformata', 'Salita seguita da discesa', 'Discesa seguita da salita', 'Curva'], 'correct' => 1],
                ['question' => 'Nel passaggio a livello senza barriere, cosa fare se luci rosse lampeggianti?', 'options' => ['Accelerare', 'Fermarsi', 'Sorpassare', 'Continuare'], 'correct' => 1],
                ['question' => 'Il segnale di attenzione ai bambini indica:', 'options' => ['Vicinanza a scuola', 'Animali', 'Vento', 'Incendio'], 'correct' => 0],
            ];
            break;
        case 3:
            $questions = [
                ['question' => 'Il segnale "Dare Precedenza" significa:', 'options' => ['Dare precedenza ai veicoli incrocianti', 'Avere precedenza', 'Fermarsi sempre', 'Accelerare'], 'correct' => 0],
                ['question' => 'Il segnale Stop richiede di:', 'options' => ['Fermarsi obbligatoriamente', 'Rallentare', 'Continuare', 'Suonare'], 'correct' => 0],
                ['question' => 'Il segnale "Intersezione con precedenza a destra" indica:', 'options' => ['Dare precedenza solo a destra', 'Avere precedenza', 'Fermarsi', 'Svoltare'], 'correct' => 0],
                ['question' => 'Il segnale "Diritto di precedenza" significa:', 'options' => ['La strada ha precedenza', 'Dare precedenza', 'Stop', 'Divieto'], 'correct' => 0],
                ['question' => 'Nei sensi unici alternati, il segnale "Dare precedenza" significa:', 'options' => ['Dare precedenza ai veicoli di fronte', 'A destra', 'A sinistra', 'Nessuno'], 'correct' => 0],
            ];
            break;
        case 4:
            $questions = [
                ['question' => 'I segnali di divieto hanno forma:', 'options' => ['Circolare con bordo rosso', 'Triangolare', 'Quadrata', 'Rettangolare'], 'correct' => 0],
                ['question' => 'Il divieto di transito vieta il transito a:', 'options' => ['Tutti i veicoli', 'Solo auto', 'Solo moto', 'Solo bici'], 'correct' => 0],
                ['question' => 'Il senso vietato indica:', 'options' => ['Divieto di entrata da quel lato', 'Divieto di uscita', 'Senso unico', 'Doppio senso'], 'correct' => 0],
                ['question' => 'Il divieto di sorpasso permette di sorpassare:', 'options' => ['Biciclette e motocicli', 'Autovetture', 'Autocarri', 'Nessuno'], 'correct' => 0],
                ['question' => 'Il segnale di fine divieto di sorpasso indica:', 'options' => ['Fine del divieto', 'Inizio divieto', 'Limite velocità', 'Sosta vietata'], 'correct' => 0],
            ];
            break;
        case 5:
            $questions = [
                ['question' => 'I segnali di obbligo hanno forma:', 'options' => ['Circolare', 'Triangolare', 'Quadrata', 'Rettangolare'], 'correct' => 0],
                ['question' => 'Il segnale di direzione obbligatoria a destra è:', 'options' => ['Una freccia curva', 'Un rettangolo', 'Un triangolo', 'Un cerchio'], 'correct' => 0],
                ['question' => 'L\'obbligo di fermata è indicato da:', 'options' => ['Un segnale ottagonale', 'Circolare', 'Triangolare', 'Quadrato'], 'correct' => 0],
                ['question' => 'Il segnale di obbligo di catene da neve è:', 'options' => ['Circolare con catene', 'Triangolare', 'Quadrato', 'Rettangolare'], 'correct' => 0],
                ['question' => 'I segnali di obbligo impongono:', 'options' => ['Comportamenti obbligatori', 'Divieti', 'Indicazioni', 'Pericoli'], 'correct' => 0],
            ];
            break;
        case 6:
            $questions = [
                ['question' => 'I segnali di indicazione hanno forma:', 'options' => ['Rettangolare o quadrata', 'Triangolare', 'Circolare', 'Ottagonale'], 'correct' => 0],
                ['question' => 'Un segnale di indicazione fornisce:', 'options' => ['Informazioni utili', 'Divieti', 'Obblighi', 'Pericoli'], 'correct' => 0],
                ['question' => 'Il segnale di ospedale è:', 'options' => ['Rettangolare con croce verde', 'Circolare', 'Triangolare', 'Quadrato'], 'correct' => 0],
                ['question' => 'I segnali di indicazione sono:', 'options' => ['Blu con simboli bianchi', 'Rossi', 'Gialli', 'Verdi'], 'correct' => 0],
                ['question' => 'Un segnale di preavviso urbano indica:', 'options' => ['Ingresso in centro abitato', 'Uscita', 'Autostrada', 'Zona industriale'], 'correct' => 0],
            ];
            break;
        case 7:
            $questions = [
                ['question' => 'I segnali temporanei sono utilizzati in:', 'options' => ['Cantieri stradali', 'Strade normali', 'Autostrade sempre', 'Zone residenziali'], 'correct' => 0],
                ['question' => 'I segnali di cantiere hanno sfondo:', 'options' => ['Giallo', 'Bianco', 'Rosso', 'Blu'], 'correct' => 0],
                ['question' => 'I segnali temporanei hanno priorità su:', 'options' => ['Segnali permanenti', 'Semafori', 'Agenti', 'Nessuno'], 'correct' => 0],
                ['question' => 'Un segnale temporaneo può essere:', 'options' => ['Mobile', 'Fisso', 'Solo notturno', 'Solo diurno'], 'correct' => 0],
                ['question' => 'In cantiere, la velocità è limitata per:', 'options' => ['Sicurezza', 'Traffico', 'Economia', 'Divertimento'], 'correct' => 0],
            ];
            break;
        case 8:
            $questions = [
                ['question' => 'I segnali complementari:', 'options' => ['Integrano altri segnali', 'Sostituiscono i segnali principali', 'Sono indipendenti', 'Indicano divieti'], 'correct' => 0],
                ['question' => 'Un pannello integrativo specifica:', 'options' => ['L\'applicazione del segnale', 'Un nuovo divieto', 'Una direzione', 'Un pericolo'], 'correct' => 0],
                ['question' => 'I pannelli integrativi sono:', 'options' => ['Rettangolari', 'Triangolari', 'Circolari', 'Ottagonali'], 'correct' => 0],
                ['question' => 'Servono a:', 'options' => ['Limitare o specificare l\'azione del segnale', 'Sostituire il segnale', 'Indicare direzioni', 'Segnalare pericoli'], 'correct' => 0],
                ['question' => 'Un pannello di distanza indica:', 'options' => ['Quanti metri', 'Ore', 'Velocità', 'Tipo veicolo'], 'correct' => 0],
            ];
            break;
        case 9:
            $questions = [
                ['question' => 'I pannelli integrativi sono:', 'options' => ['Rettangolari', 'Triangolari', 'Circolari', 'Ottagonali'], 'correct' => 0],
                ['question' => 'Servono a:', 'options' => ['Limitare o specificare l\'azione del segnale', 'Sostituire il segnale', 'Indicare direzioni', 'Segnalare pericoli'], 'correct' => 0],
                ['question' => 'Un pannello di validità indica:', 'options' => ['Quando il segnale vale', 'Tipo veicolo', 'Distanza', 'Velocità'], 'correct' => 0],
                ['question' => 'I pannelli integrativi possono essere:', 'options' => ['Sotto o accanto al segnale', 'Solo sopra', 'Solo a lato', 'Solo sotto'], 'correct' => 0],
                ['question' => 'Specificano l\'applicazione del segnale per:', 'options' => ['Categorie di veicoli o condizioni', 'Tutti', 'Nessuno', 'Pedoni'], 'correct' => 0],
            ];
            break;
        case 10:
            $questions = [
                ['question' => 'Il semaforo rosso significa:', 'options' => ['Fermarsi', 'Rallentare', 'Procedere', 'Attenzione'], 'correct' => 0],
                ['question' => 'I segnali manuali degli agenti hanno priorità su:', 'options' => ['I semafori', 'I segnali stradali', 'Le regole di precedenza', 'Tutti i segnali'], 'correct' => 3],
                ['question' => 'Il semaforo giallo lampeggiante significa:', 'options' => ['Precedenza a destra', 'Fermarsi', 'Procedere con cautela', 'Divieto'], 'correct' => 0],
                ['question' => 'Gli agenti possono regolare il traffico con:', 'options' => ['Segni manuali', 'Fischio', 'Bandiere', 'Tutti'], 'correct' => 3],
                ['question' => 'In presenza di agente, la precedenza è data da:', 'options' => ['L\'agente', 'I semafori', 'I segnali', 'Nessuno'], 'correct' => 0],
            ];
            break;
        case 11:
            $questions = [
                ['question' => 'La segnaletica orizzontale include:', 'options' => ['Linee e strisce sulla strada', 'Segnali verticali', 'Semafori', 'Pannelli'], 'correct' => 0],
                ['question' => 'Le strisce pedonali sono:', 'options' => ['Zebrate bianche', 'Gialle', 'Rosse', 'Blu'], 'correct' => 0],
            ];
            break;
        case 12:
            $questions = [
                ['question' => 'La distanza di sicurezza deve essere:', 'options' => ['Almeno 2 secondi dal veicolo davanti', '1 secondo', '3 secondi', 'Variabile'], 'correct' => 0],
                ['question' => 'I limiti di velocità sono stabiliti per:', 'options' => ['Garantire la sicurezza', 'Aumentare i consumi', 'Rallentare il traffico', 'Decorare la strada'], 'correct' => 0],
            ];
            break;
        case 13:
            $questions = [
                ['question' => 'In caso di cambio di corsia, si deve:', 'options' => ['Segnalare con le frecce', 'Accelerare', 'Fermarsi', 'Sterzare bruscamente'], 'correct' => 0],
                ['question' => 'La svolta a destra si effettua:', 'options' => ['Tenendosi a destra', 'Attraversando la corsia opposta', 'Da qualsiasi posizione', 'Solo di notte'], 'correct' => 0],
            ];
            break;
        case 14:
            $questions = [
                ['question' => 'Agli incroci, la precedenza spetta a:', 'options' => ['Chi arriva da destra', 'Chi è più veloce', 'Chi suona il clacson', 'Chi ha la macchina più grande'], 'correct' => 0],
                ['question' => 'Il segnale di dare precedenza significa:', 'options' => ['Fermarsi e dare la precedenza', 'Procedere con cautela', 'Accelerare', 'Ignorare gli altri'], 'correct' => 0],
            ];
            break;
        case 15:
            $questions = [
                ['question' => 'Il sorpasso si effettua:', 'options' => ['A sinistra', 'A destra', 'Da entrambe le parti', 'Solo di notte'], 'correct' => 0],
                ['question' => 'Prima di sorpassare, si deve:', 'options' => ['Verificare che sia sicuro', 'Accelerare', 'Suonare il clacson', 'Chiudere gli occhi'], 'correct' => 0],
            ];
            break;
        case 16:
            $questions = [
                ['question' => 'La differenza tra fermata e sosta è:', 'options' => ['La fermata è temporanea, la sosta prolungata', 'La sosta è temporanea', 'Nessuna differenza', 'La fermata è vietata'], 'correct' => 0],
                ['question' => 'La sosta è consentita:', 'options' => ['Dove non è vietata', 'Ovunque', 'Solo in parcheggio', 'Solo di giorno'], 'correct' => 0],
            ];
            break;
        case 17:
            $questions = [
                ['question' => 'Un veicolo fermo deve essere segnalato con:', 'options' => ['Triangolo di segnalazione', 'Luci accese', 'Bandiera', 'Niente'], 'correct' => 0],
                ['question' => 'L\'ingombro della carreggiata è vietato perché:', 'options' => ['Ostacola la circolazione', 'È divertente', 'Aiuta gli altri', 'È legale'], 'correct' => 0],
            ];
            break;
        case 18:
            $questions = [
                ['question' => 'Sulle autostrade è vietato:', 'options' => ['Fermarsi', 'Sorpassare', 'Guidare piano', 'Usare le corsie'], 'correct' => 0],
                ['question' => 'Le strade extraurbane principali hanno:', 'options' => ['Due corsie per senso di marcia', 'Una corsia', 'Tre corsie', 'Nessuna corsia'], 'correct' => 0],
            ];
            break;
        case 19:
            $questions = [
                ['question' => 'Il clacson si usa per:', 'options' => ['Segnalare pericolo', 'Salutare amici', 'Ascoltare musica', 'Guidare al buio'], 'correct' => 0],
                ['question' => 'Le luci di posizione si accendono:', 'options' => ['Al tramonto', 'Solo di giorno', 'Solo di notte', 'Mai'], 'correct' => 0],
            ];
            break;
        case 20:
            $questions = [
                ['question' => 'La spia del carburante indica:', 'options' => ['Livello basso di carburante', 'Velocità', 'Temperatura', 'Pressione pneumatici'], 'correct' => 0],
                ['question' => 'La spia dell\'olio motore accesa significa:', 'options' => ['Controllare il livello olio', 'Il motore è spento', 'Il carburante è finito', 'Le luci sono accese'], 'correct' => 0],
            ];
            break;
        case 21:
            $questions = [
                ['question' => 'Le cinture di sicurezza devono essere indossate:', 'options' => ['Sempre', 'Solo in città', 'Solo di notte', 'Mai'], 'correct' => 0],
                ['question' => 'Gli airbag si attivano in caso di:', 'options' => ['Urto frontale', 'Curva', 'Sosta', 'Sorpasso'], 'correct' => 0],
            ];
            break;
        case 22:
            $questions = [
                ['question' => 'Il trasporto di bambini deve avvenire con:', 'options' => ['Sistemi di ritenuta adeguati', 'Senza cinture', 'In braccio', 'Libertà'], 'correct' => 0],
                ['question' => 'Il carico sul tetto deve essere:', 'options' => ['Fissato saldamente', 'Libero', 'Pesante', 'Colorato'], 'correct' => 0],
            ];
            break;
        case 23:
            $questions = [
                ['question' => 'La patente può essere revocata per:', 'options' => ['Gravi infrazioni', 'Buona guida', 'Pagamento multe', 'Età avanzata'], 'correct' => 0],
                ['question' => 'La carta di circolazione contiene:', 'options' => ['Dati del veicolo', 'Dati del conducente', 'Multe pagate', 'Percorsi guidati'], 'correct' => 0],
            ];
            break;
        case 24:
            $questions = [
                ['question' => 'Gli agenti della polizia stradale vanno:', 'options' => ['Rispettati', 'Ignorati', 'Criticati', 'Evitati'], 'correct' => 0],
                ['question' => 'Gli occhiali da vista sono obbligatori se:', 'options' => ['Prescritti dal medico', 'Per moda', 'Sempre', 'Mai'], 'correct' => 0],
            ];
            break;
        case 25:
            $questions = [
                ['question' => 'Le cause più frequenti di incidenti sono:', 'options' => ['Velocità eccessiva e distrazione', 'Buona guida', 'Rispetto regole', 'Uso cinture'], 'correct' => 0],
                ['question' => 'Il corretto uso della strada previene:', 'options' => ['Incidenti', 'Traffico', 'Multa', 'Stanchezza'], 'correct' => 0],
            ];
            break;
        case 26:
            $questions = [
                ['question' => 'In caso di incidente, si deve:', 'options' => ['Segnalare e soccorrere', 'Fuggire', 'Ignorare', 'Ridire'], 'correct' => 0],
                ['question' => 'L\'assicurazione RCA copre:', 'options' => ['Danni a terzi', 'Danni propri', 'Furto veicolo', 'Incendio'], 'correct' => 0],
            ];
            break;
        case 27:
            $questions = [
                ['question' => 'Cosa deve fare un conducente che accusa segni di stanchezza?', 'options' => ['Ridurre la velocità e riposare', 'Accelerare per arrivare prima', 'Bere bevande analcoliche', 'Continuare a guidare con attenzione'], 'correct' => 0],
                ['question' => 'L\'assunzione di alcool può indurre:', 'options' => ['Sonnolenza e alterazione dei riflessi', 'Maggiore attenzione', 'Riduzione della velocità', 'Migliore coordinazione'], 'correct' => 0],
                ['question' => 'È vietato guidare sotto l\'influenza di sostanze stupefacenti perché:', 'options' => ['Alterano riflessi e percezioni', 'Migliorano la guida', 'Riducano il consumo di carburante', 'Aumentano la sicurezza'], 'correct' => 0],
                ['question' => 'In caso di corpo estraneo in un occhio, cosa NON si deve fare?', 'options' => ['Massaggiare la palpebra', 'Impedire di toccare l\'occhio', 'Bendare l\'occhio', 'Chiamare uno specialista'], 'correct' => 0],
            ];
            break;
        case 28:
            $questions = [
                ['question' => 'Per limitare i consumi di carburante, conviene:', 'options' => ['Ridurre velocità e mantenerla costante', 'Accelerare frequentemente', 'Tenere finestrini aperti', 'Caricare il tetto con bagagli'], 'correct' => 0],
                ['question' => 'Per ridurre l\'inquinamento atmosferico, si deve:', 'options' => ['Spegnere il motore in arresto prolungato', 'Accelerare bruscamente', 'Sovraccaricare il veicolo', 'Guidare a velocità elevata'], 'correct' => 0],
            ];
            break;
        case 29:
            $questions = [
                ['question' => 'I pneumatici con battistrada usurato aumentano:', 'options' => ['La probabilità di incidenti', 'La sicurezza', 'L\'aderenza', 'La velocità'], 'correct' => 0],
                ['question' => 'L\'aquaplaning si verifica più facilmente con:', 'options' => ['Pneumatici consumati e alta velocità', 'Pneumatici nuovi e bassa velocità', 'Strada asciutta', 'Veicoli leggeri a bassa velocità'], 'correct' => 0],
            ];
            break;
        case 30:
            $questions = [
                ['question' => 'L\'aderenza delle ruote è ridotta da:', 'options' => ['Pneumatici consumati e strada bagnata', 'Pneumatici nuovi e strada asciutta', 'Bassa velocità', 'Corretta convergenza'], 'correct' => 0],
                ['question' => 'Per assicurare stabilità in curva, è opportuno:', 'options' => ['Ridurre velocità e usare pneumatici buoni', 'Accelerare in curva', 'Sterzare bruscamente', 'Abbassare la frizione'], 'correct' => 0],
            ];
            break;
        default:
            $questions = [
                ['question' => 'Domanda di esempio per lezione ' . $lesson_number, 'options' => ['Opzione A', 'Opzione B', 'Opzione C', 'Opzione D'], 'correct' => 0],
            ];
    }

    foreach ($questions as $q) {
        $correct_letter = chr(97 + $q['correct']); // 0 -> 'a', 1 -> 'b', etc.
        $stmt = $db->prepare("INSERT INTO questions (quiz_id, question, option_a, option_b, option_c, option_d, correct_answer, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$quiz_id, $q['question'], $q['options'][0], $q['options'][1], $q['options'][2], $q['options'][3], $correct_letter]);
        $question_id = $db->lastInsertId();

        echo "Domanda creata: {$q['question']} (ID: $question_id)\n";
    }
}

echo "Contenuto creato con successo!\n";
?>