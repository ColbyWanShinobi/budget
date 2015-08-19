<?php

/**
 * French account language lines
 */
return [

    'fields' => [
        'name' => "Nom",
    ],

    'index' => [
        'title' => "Vue d'ensemble",
        'notfoundMessage' => "Le compte recherché n'a pas été trouvé.",
        'noEnvelopeMessage' => "<b>Prochaine étape ?</b> :link.",
    ],

    'add' => [
        'title' => 'Créer un nouveau compte',
        'redirectMessage' => '<b>Par où commencer ?</b> Créez un nouveau compte.',
        'successMessage' => 'Le compte :account a bien été créé.',
    ],

    'update' => [
        'title' => 'Modifier le compte',
        'successMessage' => 'Le compte :account a bien été modifié.',
    ],

    'delete' => [
        'title' => 'Comptes archivés',
        'successMessage' => "Le compte :account a bien été archivé.<br>"
            ."Il reste accessible dans le menu <i class='fa fa-fw fa-archive'></i> à droite de la liste des comptes dans le menu en haut.",
    ],

    'restore' => [
        'successMessage' => 'Le compte :account a bien été restauré.',
    ],

    'summary' => [
        'title' => 'Résumé',
        'balance' => [
            'title' => 'Solde du compte : <b>:balance</b>',
            'emptyMessage' => ':link pour consulter le graphique',
        ],
        'envelopes' => [
            'title' => 'Solde des enveloppes',
            'emptyMessage' => ':link pour consulter le graphique',
        ],
        'users' => [
            'title' => "Participants",
            'owner' => "Créateur",
            'attachUserMessage' => ":user a été rattaché à ce compte.",
            'detachUserMessage' => ":user a été détaché de ce compte.",
        ],
    ],

    'allocation' => [
        'title' => 'Répartition des revenus',
        'sliders' => [
            'title' => 'Configuration',
            'revenueInMonth' => 'Revenu ce mois',
            'allocatedInMonth' => 'Alloué ce mois',
            'unallocatedRevenueAt' => 'Épargné au :date :',
            'unallocatedRevenueMonth' => 'Épargné ce mois :',
            'chartTitle' => 'Solde des enveloppes au :date :',
            'emptyMessage' => ':link pour répartir les revenus',
        ],
    ],

    'development' => [
        'title' => 'Évolution',
        'envelopes' => [
            'emptyMessage' => ':link pour consulter le graphique',
        ],
    ],

];