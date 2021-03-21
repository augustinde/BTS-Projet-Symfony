# Projet mangatheque


## Récupérer le projet

    git clone https://github.com/augustinde/mangathequeSymfony.git

## Créé la branche dev puis la faire pointer sur la branche distante

    git checkout -b dev origin/dev
    
   Puis créé sa propre branche dev
    
    git checkout -b devchloe origin/devchloe 
    git checkout -b devaug origin/devaug

## Installation des dépendances composer

    composer install 

## Créé un controller
    
    php bin/console make:controller

## Créé un formulaire

    php bin/console make:form

## Créé la base de donnée

    php bin/console doctrine:migrations:migrate
