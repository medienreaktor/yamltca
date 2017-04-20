<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'YAML TCA',
    'description' => 'Use YAML files for TCA generation.',
    'category' => 'be',
    'state' => 'experimental',
    'version' => '0.1.0',
    'author' => 'Daniel Kestler',
    'author_email' => 'daniel.kestler@medienreaktor.de',
    'author_company' => 'medienreaktor GmbH',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.7.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
