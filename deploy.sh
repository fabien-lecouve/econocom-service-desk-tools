#!/bin/bash

# Vérifier l'état du dépôt
git status

# Ajouter les fichiers modifiés
git add .

# Demander le message du commit
read -p "Message du commit : " message

# Créer le commit
git commit -m "$message"

# Envoyer les modifications sur le dépôt distant
git push