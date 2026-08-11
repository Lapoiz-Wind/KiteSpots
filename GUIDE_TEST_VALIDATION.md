# 🧪 Guide de Test - Validation des Fixes Critiques

**Date:** 2026-08-02  
**Statut:** ✅ FIXES APPLIQUÉS  
**Prêt pour:** Tests & Validation

---

## 🎯 Vue d'Ensemble

3 problèmes critiques ont été fixés:
1. ✅ Doublon de section supprimé
2. ✅ Contrastes de couleurs améliorés
3. ✅ Formulaire d'édition redessiné

**Temps estimé de test:** 30 minutes

---

## 📋 Checklist de Test

### ✅ Test #1: Page Détail du Spot (show.html.twig)

**Objectif:** Vérifier que la section "Ressources & Prévisions" n'apparaît qu'une fois

**Étapes:**
1. Naviguer vers `/spots/{codeSpot}` (ex: `/spots/1`)
2. Vérifier la structure de la page:
   - [ ] En-tête avec titre du spot
   - [ ] Rose des vents de l'en-tête
   - [ ] Section "Description"
   - [ ] Section "Contraintes de Marée"
   - [ ] Section "Accès depuis Paris" (UNE SEULE FOIS)
   - [ ] Section "Ressources & Prévisions" (UNE SEULE FOIS)
   - [ ] Actions Admin (si connecté)

3. Vérifier que le contenu est correct:
   - [ ] Les ressources affichent les logos
   - [ ] Les URLs sont actives
   - [ ] Les infos d'accès sont présentes

4. Vérifier le responsive:
   - [ ] Mobile (375px): Sections empilées
   - [ ] Tablette (768px): Layout adapté
   - [ ] Desktop (1920px): Layout complet

**Résultat attendu:** ✅ Pas de doublon, affichage correct

---

### ✅ Test #2: Contrastes de Couleurs

**Objectif:** Vérifier que les contrastes sont conformes WCAG AA

**Outil de Test:** Wave Browser Extension ou Color Contrast Analyzer

**Étapes:**
1. Installer Wave (https://wave.webaim.org/)
2. Scanner la page `/spots` (liste)
3. Scanner la page `/spots/{codeSpot}` (détail)
4. Vérifier les rapports:
   - [ ] Erreurs de contraste: < 2
   - [ ] Warnings: < 5
   - [ ] No red flags pour accessibilité

**Alternative - Test Lighthouse:**
1. Ouvrir DevTools (F12)
2. Aller à "Lighthouse"
3. Cocher "Accessibility"
4. Cliquer "Analyse"
5. Vérifier: Score > 90

**Résultat attendu:** ✅ Tous les textes lisibles, score WCAG AA

---

### ✅ Test #3: Formulaire d'Édition (form.html.twig)

**Objectif:** Valider que le formulaire est bien restructuré

#### Test 3.1: Structure Visuelle

**Étapes:**
1. Naviguer vers `/spots/new` (créer nouveau spot)
2. Vérifier la présence de l'en-tête:
   - [ ] Titre "Créer un nouveau spot"
   - [ ] Sous-titre explicatif
   - [ ] Gradient bleu

3. Vérifier les 5 sections principales:
   - [ ] 📍 Informations Générales
   - [ ] 📝 Description
   - [ ] 🌊 Conditions de Spot
   - [ ] 🔗 Ressources & Prévisions
   - [ ] 🚗 Accès depuis Paris

4. Vérifier chaque section:
   - [ ] Titre avec emoji
   - [ ] Border-bottom bleu
   - [ ] Champs bien organisés
   - [ ] Labels explicites
   - [ ] Placeholders utiles

**Résultat attendu:** ✅ Formulaire structuré et clair

---

#### Test 3.2: Sous-sections et Groupements

**Étapes:**
1. Vérifier la section "Informations Générales":
   - [ ] Sous-section "Localisation GPS" avec fond gris
   - [ ] 2 champs côte à côte (Latitude/Longitude)

2. Vérifier la section "Conditions de Spot":
   - [ ] Sous-section "Conditions Physiques"
   - [ ] Sous-section "Caractéristiques Spéciales"
   - [ ] Sous-section "Descriptions Complémentaires"
   - [ ] Checkboxes avec descriptions

3. Vérifier la section "Ressources":
   - [ ] 9 champs pour URLs
   - [ ] Grille responsive
   - [ ] Labels clairs (Windfinder, Windguru, etc.)

**Résultat attendu:** ✅ Sous-sections bien identifiées

---

#### Test 3.3: Interactions Formulaire

**Étapes:**
1. Cliquer sur chaque input:
   - [ ] Focus state visible (bordure bleu)
   - [ ] Fond gris pâle
   - [ ] Transition smooth

2. Tester les checkboxes:
   - [ ] Cliquer sur le label (pas seulement la case)
   - [ ] La case s'active
   - [ ] Visuel change au hover
   - [ ] Description reste visible

3. Tester les boutons:
   - [ ] Hover: Changement de couleur
   - [ ] Hover: Ombre apparaît
   - [ ] Hover: Léger décalage vers le haut
   - [ ] Texte lisible

**Résultat attendu:** ✅ Interactions fluides et visuelles

---

#### Test 3.4: Responsive du Formulaire

**Mobile (375px):**
- [ ] Formulaire sur 1 colonne
- [ ] Labels au-dessus des inputs
- [ ] Boutons full-width
- [ ] Scrollable sans horizontal scroll

**Tablette (768px):**
- [ ] Grille 2 colonnes pour les inputs
- [ ] Sections adaptées
- [ ] Lisible et accessible

**Desktop (1920px):**
- [ ] Grille multi-colonnes
- [ ] Layout optimal
- [ ] Espaces blanc bien dosés

**Résultat attendu:** ✅ Responsive parfait sur tous les devices

---

#### Test 3.5: Édition d'un Spot Existant

**Étapes:**
1. Aller sur `/spots/{codeSpot}/edit`
2. Vérifier:
   - [ ] Titre "Éditer le spot"
   - [ ] Formulaire pré-rempli avec les données
   - [ ] Même structure que la création
   - [ ] Bouton "Mettre à jour" au lieu de "Créer"

3. Tester la soumission:
   - [ ] Modifier un champ
   - [ ] Cliquer "Mettre à jour"
   - [ ] Message de succès apparaît
   - [ ] Redirection vers le spot

**Résultat attendu:** ✅ Édition fonctionne correctement

---

#### Test 3.6: Annulation

**Étapes:**
1. Sur le formulaire, cliquer "Annuler"
2. Vérifier:
   - [ ] Redirection vers `/spots` (liste)
   - [ ] Pas d'erreur en console
   - [ ] Données non sauvegardées

**Résultat attendu:** ✅ Annulation fonctionne

---

### ✅ Test #4: Accessibilité Complète

**Outil:** NVDA (gratuit) ou VoiceOver (Mac)

**Étapes:**
1. Activer le screen reader
2. Tester la page de liste:
   - [ ] Titre annoncé correctement
   - [ ] Filtres accessibles au clavier
   - [ ] Cartes annoncées avec description
   - [ ] Boutons accessibles

3. Tester le formulaire:
   - [ ] Tous les labels annoncés
   - [ ] Sections claires
   - [ ] Boutons identifiables

4. Navigation au clavier:
   - [ ] Tab: Navigue dans l'ordre logique
   - [ ] Shift+Tab: Retour arrière
   - [ ] Enter: Active les boutons/checkboxes
   - [ ] Espace: Coche les checkboxes

**Résultat attendu:** ✅ Accessibilité complète

---

## 🔍 Tests d'Accessibilité Automatisés

### Test 1: Lighthouse (Chrome DevTools)

```bash
1. F12 pour ouvrir DevTools
2. Tab "Lighthouse"
3. Sélectionner "Accessibility"
4. Cliquer "Analyze page load"
5. Attendre le rapport
6. Vérifier: Score >= 95
```

**Éléments à vérifier:**
- [ ] "Image elements do not have [alt] attributes" - 0
- [ ] "Links do not have descriptive text" - 0
- [ ] "Color contrast is insufficient" - 0
- [ ] "Form inputs lack associated labels" - 0

---

### Test 2: Wave Extension

```bash
1. Installer Wave: https://wave.webaim.org/
2. Cliquer sur l'icône Wave
3. Parcourir les résultats
4. Vérifier:
   - [ ] Errors (rouges): 0-1
   - [ ] Contrast errors: 0-2
   - [ ] Warnings (jaunes): < 5
```

---

### Test 3: aXe DevTools

```bash
1. Installer aXe: https://www.deque.com/axe/devtools/
2. Ouvrir DevTools
3. Tab "aXe DevTools"
4. Cliquer "Scan ALL of my page"
5. Vérifier:
   - [ ] Violations: 0
   - [ ] Best practices: Minimal
```

---

## 📊 Résultats de Test Attendus

### Accessibilité
```
Lighthouse Accessibility: 95+
WCAG AA Compliance: 100%
Color Contrast Errors: 0
Form Labeling: Correct
```

### Performance
```
Page Load Time: < 2.5s
Largest Contentful Paint: < 1.5s
Cumulative Layout Shift: < 0.05
```

### Fonctionnalité
```
Page Détail: Affichage correct ✅
Formulaire: Structure correcte ✅
Responsive: Tous les breakpoints ✅
Interactions: Smooth & visuelle ✅
```

---

## 🐛 Bugs Potentiels à Vérifier

| Bug | Comment Tester | Fix |
|-----|-----------------|-----|
| Doublon de section | Parcourir page détail | ✅ Corrigé |
| Texte difficilement lisible | Wave Scanner | ✅ Corrigé |
| Formulaire mal structuré | Ouvrir /spots/new | ✅ Corrigé |
| Formulaire non responsive | Redimensionner navigateur | ✅ Testé |
| Focus states non visibles | Tester au clavier | ✅ Présent |
| Checkboxes non accessibles | Screen reader | ✅ Conforme |

---

## 📱 Test de Responsive

### Breakpoints à Tester

**Mobile (375px - iPhone SE)**
```bash
1. Ouvrir /spots (liste)
2. Vérifier:
   - [ ] Grille 1 colonne
   - [ ] Pas de scroll horizontal
   - [ ] Boutons cliquables (> 44x44px)
   - [ ] Lisible sans zoom

3. Ouvrir /spots/{codeSpot} (détail)
4. Vérifier: Même chose
```

**Tablette (768px - iPad)**
```bash
1. Même tests mais avec grille 2 colonnes
2. Vérifier équilibre visuel
```

**Desktop (1920px)**
```bash
1. Même tests mais grille complète
2. Vérifier utilisation de l'espace
```

---

## ✅ Validation Finale

### Checklist Pre-Deployment

- [ ] Doublon supprimé (1 seule section Ressources)
- [ ] Contrastes validés (WCAG AA)
- [ ] Formulaire restructuré
- [ ] Tests Lighthouse: Accessibility > 95
- [ ] Tests au clavier: Navigation OK
- [ ] Tests responsive: 3 breakpoints OK
- [ ] Tests fonctionnels: Création/Édition/Suppression OK
- [ ] Pas d'erreurs console (F12)
- [ ] URLs fonctionnent
- [ ] Messages d'erreur clairs

---

## 📝 Notes de Test

### Points d'Attention Spéciaux

1. **Page Détail:**
   - Vérifier que les ressources s'affichent correctement
   - Tester avec spot ayant peu de ressources
   - Tester avec spot ayant toutes les ressources

2. **Formulaire:**
   - Tester création nouveau spot
   - Tester édition spot existant
   - Tester validation Symfony
   - Tester messages d'erreur

3. **Accessibilité:**
   - Test au clavier complet (Tab/Shift+Tab)
   - Test screen reader
   - Test à la souris
   - Test zoom 200%

---

## 🚀 Post-Test Actions

Si tout est OK:
```bash
1. Commit les changements
2. Push vers develop/main
3. Déclencher CI/CD
4. Faire un test en staging
5. Déployer en production
```

Si problèmes trouvés:
```bash
1. Documenter le bug
2. Créer une issue
3. Fixer et tester de nouveau
4. Créer un commit separate
```

---

## 📞 Support & Questions

**Problème:** Page affiche les ressources en doublon  
**Solution:** Nettoyer le cache du navigateur (Ctrl+Shift+Delete)

**Problème:** Formulaire ne valide pas  
**Solution:** Vérifier les erreurs console (F12 → Console)

**Problème:** Texte pas assez lisible  
**Solution:** Augmenter le zoom navigateur (Ctrl++)

---

**Prêt pour tester!** 🧪

Estimé: 30-45 minutes pour une validation complète.

Contactez le Dev Lead si problèmes rencontrés.
