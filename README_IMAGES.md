# Gestion des images

Ce projet utilise l'API loremflickr.com pour générer automatiquement des images de pièces automobiles.

## Avantages

- Pas besoin de télécharger/stocker des images
- Images réelles de pièces auto
- Gratuit et illimité
- Images différentes à chaque chargement

## Fonctionnement

L'API génère une image basée sur la catégorie du produit (Freinage, Éclairage, etc.) :

```
https://loremflickr.com/200/200/car,{categorie},parts
```

## Fallback

Si loremflickr ne répond pas, un placeholder violet s'affiche automatiquement via placehold.co.
