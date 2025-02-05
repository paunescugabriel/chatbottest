<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userMessage = $_POST['message'];
     $apiKey = 'stripped';

    $companyInfo = "
    Compania Națională Poșta Română S.A.

    Sediu Central:
    Bulevardul Dacia nr. 140, Sector 2, București, Cod poștal 020065
    Telefon: 021/9393
    Email: suportclienti@posta-romana.ro

    Director General: Valentin Ștefan

    Servicii Oferite:
    - Corespondență internă și internațională
    - Servicii de curierat rapid (Prioripost, EMS)
    - Transfer de bani și servicii financiare
    - Distribuție publicații și abonamente
    - Servicii de coletărie națională și internațională

    Website oficial: www.posta-romana.ro
   Nume Companie: Compania Națională Poșta Română S.A.

Descriere: Poșta Română este operatorul național de servicii poștale și de curierat din România, furnizor unic de serviciu universal pe întreg teritoriul țării. Compania oferă o gamă largă de servicii, inclusiv corespondență, colete, curierat rapid, transfer de bani și servicii financiare.

Anul Înființării: 1862

Sediu Central:
  Adresă: Bulevardul Dacia nr. 140, Sector 2, București, Cod poștal 020065
  Telefon: 021/9393
  Fax: 021/2007470
  Email: suportclienti@posta-romana.ro

Acționariat:
  - Ministerul Cercetării, Inovării și Digitalizării: 93,52%
  - Fondul Proprietatea: 6,48%

Servicii Principale:
  - Corespondență internă și internațională
  - Colete interne și internaționale
  - Curierat rapid (Prioripost, EMS)
  - Transfer de bani (mandat poștal, E-mandat, Western Union, RIA Money Transfer)
  - Servicii financiare și de asigurări
  - Abonamente presă și distribuție publicații
  - Servicii de comisionariat vamal

Rețea Teritorială: Peste 5.500 de oficii poștale la nivel național

Număr Angajați: Aproximativ 21.224 (conform datelor din 2023)

Misiune: Furnizarea de servicii poștale și de curierat de înaltă calitate, accesibile tuturor cetățenilor, contribuind la dezvoltarea comunicațiilor și comerțului în România.

Website: [www.posta-romana.ro](https://www.posta-romana.ro/)

Sursa informațiilor: [Poșta Română - Wikipedia](https://ro.wikipedia.org/wiki/Po%C8%99ta_Rom%C3%A2n%C4%83), [Prezentare - Poșta Română](https://www.posta-romana.ro/a50/despre-noi/prezentare.html), [Contact Poșta Română](https://www.contact.info.ro/contact-posta-romana-program-si-reclamatii/)
 ";

    $postData = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'system', 'content' => "Ești un asistent pentru Poșta Română. Folosește aceste informații pentru a răspunde corect:\n" . $companyInfo],
            ['role' => 'user', 'content' => $userMessage]
        ]
    ];

    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        $errorResponse = json_decode($response, true);
        echo "Error: API request failed with status code $httpCode. Message: " . ($errorResponse['error']['message'] ?? 'Unknown error.');
        exit;
    }

    $responseData = json_decode($response, true);
    echo $responseData['choices'][0]['message']['content'];
}
?>
