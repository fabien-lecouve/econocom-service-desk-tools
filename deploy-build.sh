#!/bin/bash

set -e

# Compiler les assets
npm run build

# Vérifier l'état du dépôt
git status

# Ajouter les fichiers modifiés
git add .

# Générer le message du commit avec la date du jour
message="Npm run build du $(date +%d-%m-%Y)"

# Créer le commit
git commit -m "$message"

# Envoyer les modifications
git push