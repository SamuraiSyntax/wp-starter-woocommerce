# WP Starter WooCommerce

Un thème WordPress de démarrage optimisé pour WooCommerce, conçu pour servir de base au développement de thèmes personnalisés.

## Description

WP Starter WooCommerce est un thème minimaliste qui intègre les meilleures pratiques de développement et une architecture modulaire, facilitant la personnalisation et l'extension.

## Caractéristiques

- Intégration complète avec WooCommerce
- Structure SASS moderne avec architecture modulaire
- Support complet de la personnalisation WordPress
- Menu de navigation responsive avec sous-menus
- Optimisé pour l'accessibilité
- Compatible Gutenberg
- Support des widgets
- Performance optimisée

## Prérequis

- WordPress 5.0 ou supérieur
- PHP 7.4 ou supérieur
- Node.js et npm pour le développement

## Installation

1. Dans votre administration WordPress, allez dans Apparence > Thèmes > Ajouter
2. Cliquez sur "Téléverser un thème"
3. Choisissez le fichier zip du thème
4. Cliquez sur "Installer maintenant"
5. Activez le thème

## Développement

### Installation des dépendances

1. Installez les dépendances du projet avec npm :

   ```bash
   npm install
   ```

2. Compilez les fichiers SCSS en CSS :

   - Compilation et watch

   ```bash
   npm run sass
   ```

   - Compilation unique

   ```bash
   npm run sass:build
   ```

3. Activez le thème dans l'administration WordPress (Apparence > Thèmes)

## Personnalisation

### Variables SASS

Les variables principales peuvent être modifiées dans les fichiers :

- `_variables.scss` : Configuration globale
- `variables/_colors.scss` : Couleurs
- `variables/_typography.scss` : Typographie
- `variables/_layout.scss` : Mise en page
- `variables/_spacing.scss` : Espacements

### Customizer

Le thème supporte la personnalisation via le Customizer WordPress :

- Logo personnalisé
- Couleurs du thème
- Options de mise en page
- Widgets

## Support Navigateurs

- Chrome (dernières versions)
- Firefox (dernières versions)
- Safari (dernières versions)
- Edge (dernières versions)
- IE11 (support basique)

## Changelog

### 1.0.0

- Version initiale
- Intégration WooCommerce
- Structure SASS moderne
- Support complet des fonctionnalités WordPress
- Menu responsive

## Licence

Ce thème est sous licence GPL v2 ou ultérieure - voir le fichier [LICENSE](LICENSE) pour plus de détails.

## Auteur

[Votre Nom](https://votre-site.com)

## Contributeurs

- [@VotreNom](https://github.com/VotreNom)
