# Recommandations Détaillées - Améliorations CSS & HTML

## 1. Améliorations de Contraste et Lisibilité

### Fichier: `public/css/accessibility.css` (À créer)

```css
/* Amélioration des contrastes */
:root {
  /* Couleurs sombres pour meilleur contraste */
  --text-dark: #1a1a1a;
  --text-medium: #333;
  --text-light: #555;
  --text-lighter: #777;
}

body {
  color: var(--text-medium);
  line-height: 1.6;
}

/* Tous les textes principaux */
p, li, span, label, a {
  color: var(--text-medium);
}

/* Améliorations spécifiques */
.spot-description {
  color: var(--text-medium) !important;
  line-height: 1.6;
}

.filter-group label {
  color: var(--text-dark) !important;
  font-weight: 600;
}

.spot-card-title {
  color: var(--text-dark) !important;
}

h1, h2, h3, h4, h5, h6 {
  color: var(--text-dark);
}

/* Input focus states - plus visible */
input:focus,
select:focus,
textarea:focus {
  outline: none;
  border-color: #0052a3 !important;
  box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.2) !important;
  background-color: #fafbfc;
}

/* Boutons - améliorer le contraste */
.btn-primary {
  background: #0052a3;
  color: white;
  font-weight: 600;
}

.btn-primary:hover {
  background: #003d7a;
}

/* Badges et tags */
.spot-card-region {
  background: #0052a3 !important;
  color: white;
  font-weight: 600;
}

/* Texte gris secondaire - plus lisible */
small, .text-muted {
  color: var(--text-light);
}
```

---

## 2. Amélioration de la Page de Formulaire d'Édition

### Fichier: `templates/spot/form.html.twig` (À remplacer)

```twig
{% extends "base.html.twig" %}

{% block content %}
<div class="form-page">
    <!-- En-tête -->
    <div class="form-header">
        <div class="container">
            <h1>{% if spot.id %}✏️ Éditer le spot{% else %}➕ Créer un nouveau spot{% endif %}</h1>
            <p class="form-subtitle">Remplissez les informations ci-dessous</p>
        </div>
    </div>

    <div class="container form-container">
        <div class="form-wrapper">
            {{ form_start(form, {'attr': {'class': 'spot-form', 'novalidate': true}}) }}
            
            <!-- Section 1: Informations Générales -->
            <div class="form-section">
                <h2 class="form-section-title">📍 Informations Générales</h2>
                <div class="form-section-grid">
                    <div class="form-group">
                        {{ form_label(form.nom) }}
                        {{ form_widget(form.nom, {'attr': {'class': 'form-control', 'placeholder': 'Ex: Île de Ré'}}) }}
                        {{ form_errors(form.nom) }}
                    </div>

                    <div class="form-group">
                        {{ form_label(form.region) }}
                        {{ form_widget(form.region, {'attr': {'class': 'form-control'}}) }}
                        {{ form_errors(form.region) }}
                    </div>

                    <div class="form-group">
                        {{ form_label(form.codeSpot) }}
                        {{ form_widget(form.codeSpot, {'attr': {'class': 'form-control', 'placeholder': 'Code unique'}}) }}
                        {{ form_errors(form.codeSpot) }}
                    </div>

                    <div class="form-group">
                        {{ form_label(form.note) }}
                        {{ form_widget(form.note, {'attr': {'class': 'form-control', 'type': 'number', 'min': 0, 'max': 5, 'step': 0.1}}) }}
                        {{ form_errors(form.note) }}
                    </div>
                </div>

                <!-- Localisation en deux colonnes -->
                <div class="form-subsection">
                    <h3>Localisation GPS</h3>
                    <div class="form-row">
                        <div class="form-group">
                            {{ form_label(form.lat) }}
                            {{ form_widget(form.lat, {'attr': {'class': 'form-control'}}) }}
                            {{ form_errors(form.lat) }}
                        </div>
                        <div class="form-group">
                            {{ form_label(form.long) }}
                            {{ form_widget(form.long, {'attr': {'class': 'form-control'}}) }}
                            {{ form_errors(form.long) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Description -->
            <div class="form-section">
                <h2 class="form-section-title">📝 Description</h2>
                
                <div class="form-group">
                    {{ form_label(form.shortDescription) }}
                    {{ form_widget(form.shortDescription, {'attr': {'class': 'form-control', 'rows': 3, 'placeholder': 'Description courte du spot'}}) }}
                    <small class="form-text">Max 200 caractères</small>
                    {{ form_errors(form.shortDescription) }}
                </div>

                <div class="form-group">
                    {{ form_label(form.description) }}
                    {{ form_widget(form.description, {'attr': {'class': 'form-control', 'rows': 6, 'placeholder': 'Description détaillée'}}) }}
                    <small class="form-text">Vous pouvez utiliser du HTML</small>
                    {{ form_errors(form.description) }}
                </div>
            </div>

            <!-- Section 3: Conditions -->
            <div class="form-section">
                <h2 class="form-section-title">🌊 Conditions</h2>
                
                <div class="form-subsection">
                    <h3>Vent & Marée</h3>
                    <div class="form-row">
                        <div class="form-group">
                            {{ form_label(form.mareeDesc) }}
                            {{ form_widget(form.mareeDesc, {'attr': {'class': 'form-control'}}) }}
                        </div>
                        <div class="form-group">
                            {{ form_label(form.waveDesc) }}
                            {{ form_widget(form.waveDesc, {'attr': {'class': 'form-control'}}) }}
                        </div>
                    </div>
                </div>

                <div class="form-subsection">
                    <h3>Caractéristiques</h3>
                    <div class="form-checkbox-group">
                        <label class="checkbox-label">
                            {{ form_widget(form.isFoil) }}
                            <span>Compatible Foil</span>
                        </label>
                        <label class="checkbox-label">
                            {{ form_widget(form.isContraintEte) }}
                            <span>Contrainte en été</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Section 4: Ressources -->
            <div class="form-section">
                <h2 class="form-section-title">🔗 Ressources & Prévisions</h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        {{ form_label(form.windfinder) }}
                        {{ form_widget(form.windfinder, {'attr': {'class': 'form-control', 'placeholder': 'URL Windfinder'}}) }}
                    </div>
                    <div class="form-group">
                        {{ form_label(form.windguru) }}
                        {{ form_widget(form.windguru, {'attr': {'class': 'form-control', 'placeholder': 'URL Windguru'}}) }}
                    </div>
                    <div class="form-group">
                        {{ form_label(form.meteoFrance) }}
                        {{ form_widget(form.meteoFrance, {'attr': {'class': 'form-control'}}) }}
                    </div>
                    <div class="form-group">
                        {{ form_label(form.maree) }}
                        {{ form_widget(form.maree, {'attr': {'class': 'form-control'}}) }}
                    </div>
                </div>
            </div>

            <!-- Section 5: Accès depuis Paris -->
            <div class="form-section">
                <h2 class="form-section-title">🚗 Accès depuis Paris</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        {{ form_label(form.distFromParis) }}
                        {{ form_widget(form.distFromParis, {'attr': {'class': 'form-control', 'type': 'number'}}) }}
                        <small>en km</small>
                    </div>
                    <div class="form-group">
                        {{ form_label(form.timeFromParis) }}
                        {{ form_widget(form.timeFromParis, {'attr': {'class': 'form-control', 'placeholder': 'Ex: 4h30'}}) }}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        {{ form_label(form.distFromParisAutoroute) }}
                        {{ form_widget(form.distFromParisAutoroute, {'attr': {'class': 'form-control', 'type': 'number'}}) }}
                    </div>
                    <div class="form-group">
                        {{ form_label(form.peageFromParis) }}
                        {{ form_widget(form.peageFromParis, {'attr': {'class': 'form-control', 'placeholder': 'Ex: 45€'}}) }}
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">
                    {% if spot.id %}✅ Mettre à jour{% else %}✅ Créer le spot{% endif %}
                </button>
                <a href="{{ path('spot_index') }}" class="btn btn-secondary btn-lg">
                    ✕ Annuler
                </a>
            </div>

            {{ form_end(form) }}
        </div>
    </div>
</div>

<style>
/* Form styling inline - à déplacer dans app.css */
.form-page {
    background: #f8f9fa;
    padding-bottom: 2rem;
}

.form-header {
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
}

.form-header h1 {
    margin-bottom: 0.5rem;
    color: white;
}

.form-subtitle {
    opacity: 0.9;
    font-size: 1.1rem;
}

.form-container {
    max-width: 900px;
}

.form-wrapper {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.form-section {
    margin-bottom: 2.5rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #dee2e6;
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 2rem;
    padding-bottom: 0;
}

.form-section-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #222;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #0066cc;
}

.form-subsection {
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.form-subsection h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 1rem;
}

.form-section-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.form-control {
    padding: 0.75rem;
    border: 2px solid #dee2e6;
    border-radius: 6px;
    font-size: 1rem;
    font-family: inherit;
    transition: all 0.2s;
}

.form-control:hover {
    border-color: #b8bcc4;
}

.form-control:focus {
    outline: none;
    border-color: #0066cc;
    box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
    background-color: #fafbfc;
}

.form-text {
    font-size: 0.85rem;
    color: #666;
    margin-top: 0.25rem;
}

.form-checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 6px;
    transition: all 0.2s;
}

.checkbox-label:hover {
    background: #e8f0ff;
}

.checkbox-label input[type="checkbox"] {
    cursor: pointer;
    width: 18px;
    height: 18px;
    accent-color: #0066cc;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn-lg {
    padding: 0.875rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background: #0066cc;
    color: white;
}

.btn-primary:hover {
    background: #0052a3;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
}

.btn-secondary {
    background: #f8f9fa;
    color: #333;
    border: 2px solid #dee2e6;
}

.btn-secondary:hover {
    background: white;
    border-color: #0066cc;
    color: #0066cc;
}

/* Responsive */
@media (max-width: 768px) {
    .form-wrapper {
        padding: 1.5rem;
    }

    .form-section-grid {
        grid-template-columns: 1fr;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn-lg {
        width: 100%;
    }
}
</style>
{% endblock %}
```

---

## 3. Amélioration des Cartes de Spots

### Modifications pour `templates/spot/index.html.twig`

```html
<!-- Remplacer la section spot-card (lignes 87-149) par: -->

<div class="spot-card">
    <!-- Bande colorée par région -->
    <div class="spot-card-region-band" style="background-color: {{ getRegionColor(spot.region) }}"></div>
    
    <div class="spot-card-header">
        <a href="{{ path('spot_show', {codeSpot: spot.codeSpot}) }}" class="spot-card-title">
            {{ spot.nom }}
        </a>
        <span class="spot-card-region">📍 {{ spot.region }}</span>
    </div>

    <div class="spot-card-body">
        <!-- État général du spot -->
        {% set windQuality = getWindQuality(spot) %}
        {% set qualityColor = {'-1': '#dc3545', '0': '#fd7e14', '1': '#0d6efd', '2': '#198754'} %}
        <div class="spot-quick-status">
            <span class="status-badge" style="background-color: {{ qualityColor[windQuality] }}">
                {% if windQuality == 2 %}🟢 EXCELLENT
                {% elseif windQuality == 1 %}🔵 BON
                {% elseif windQuality == 0 %}🟠 MOYEN
                {% else %}🔴 FAIBLE{% endif %}
            </span>
        </div>

        <!-- Description -->
        {% if spot.shortDescription %}
            <p class="spot-description">{{ spot.shortDescription }}</p>
        {% endif %}

        <!-- Badges de caractéristiques -->
        <div class="spot-features">
            {% if spot.isFoil %}
                <span class="feature-badge foil">🎯 Foil</span>
            {% endif %}
            {% if spot.isContraintEte %}
                <span class="feature-badge constraint">☀️ Été</span>
            {% endif %}
            {% if spot.note %}
                <span class="feature-badge rating">⭐ {{ spot.note }}/5</span>
            {% endif %}
        </div>

        <!-- Mini Rose des Vents -->
        <div class="spot-windrose-container">
            <svg class="spot-windrose" width="140" height="140" viewBox="0 0 140 140" data-spot-code="{{ spot.codeSpot }}">
                <circle cx="70" cy="70" r="65" fill="none" stroke="#e0e0e0" stroke-width="0.5"/>
                <circle cx="70" cy="70" r="50" fill="none" stroke="#f0f0f0" stroke-width="0.5" stroke-dasharray="2,2"/>
                <line x1="70" y1="5" x2="70" y2="135" stroke="#999" stroke-width="0.5" opacity="0.15"/>
                <line x1="5" y1="70" x2="135" y2="70" stroke="#999" stroke-width="0.5" opacity="0.15"/>
                <g class="spot-windrose-bars"></g>
                <polygon points="70,40 68,48 72,48" fill="#d32f2f" opacity="0.7"/>
            </svg>
        </div>

        <!-- Légende compacte -->
        <div class="spot-windrose-legend">
            <span class="legend-item">🟢 TOP/OK</span>
            <span class="legend-item">🟡 MOYEN</span>
            <span class="legend-item">🔴 FAIBLE</span>
        </div>
    </div>

    <div class="spot-card-actions">
        <a href="{{ path('spot_show', {codeSpot: spot.codeSpot}) }}" class="btn-primary">
            📖 Détails
        </a>
        {% if is_granted('ROLE_ADMIN') %}
            <a href="{{ path('spot_edit', {codeSpot: spot.codeSpot}) }}" class="btn-secondary">
                ✏️ Éditer
            </a>
        {% endif %}
    </div>
</div>
```

### CSS correspondant à ajouter dans `public/css/app.css`:

```css
/* Amélioration des cartes de spots */
.spot-card-region-band {
    height: 4px;
    width: 100%;
    position: relative;
}

.spot-quick-status {
    margin-bottom: 1rem;
}

.status-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    color: white;
    font-weight: 600;
    font-size: 0.85rem;
}

.spot-windrose-legend {
    display: flex;
    gap: 1rem;
    justify-content: center;
    font-size: 0.8rem;
    margin-top: 0.75rem;
    padding-top: 0.75rem;
    border-top: 1px solid #e0e0e0;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.3rem;
}
```

---

## 4. Système de Coloration par Région

### Fichier: `public/css/regions.css` (À créer)

```css
:root {
    --region-brittany: #e74c3c;      /* Rouge-orange *)
    --region-normandy: #3498db;      /* Bleu *)
    --region-aquitaine: #f39c12;     /* Orange *)
    --region-occitanie: #9b59b6;     /* Violet *)
    --region-paca: #1abc9c;          /* Turquoise *)
    --region-corsica: #e67e22;       /* Orange foncé *)
}

.region-brittany { --region-color: var(--region-brittany); }
.region-normandy { --region-color: var(--region-normandy); }
.region-aquitaine { --region-color: var(--region-aquitaine); }
.region-occitanie { --region-color: var(--region-occitanie); }
.region-paca { --region-color: var(--region-paca); }
.region-corsica { --region-color: var(--region-corsica); }
```

---

## 5. Ajout de Breadcrumbs

### Pour `templates/spot/show.html.twig` (À ajouter au début):

```twig
<!-- Breadcrumb -->
<nav class="breadcrumb-container">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ path('spot_index') }}">🏠 Spots</a></li>
            <li><a href="{{ path('spot_index', {region: spot.region}) }}">{{ spot.region }}</a></li>
            <li class="active">{{ spot.nom }}</li>
        </ul>
    </div>
</nav>
```

### CSS:

```css
.breadcrumb-container {
    background: #f8f9fa;
    padding: 0.75rem 0;
    border-bottom: 1px solid #dee2e6;
}

.breadcrumb {
    list-style: none;
    display: flex;
    gap: 0.5rem;
    align-items: center;
    padding: 0;
    margin: 0;
}

.breadcrumb li {
    display: flex;
    align-items: center;
}

.breadcrumb li:not(:last-child)::after {
    content: '/';
    margin-left: 0.5rem;
    color: #999;
}

.breadcrumb a {
    color: #0066cc;
    text-decoration: none;
    font-size: 0.9rem;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.breadcrumb li.active {
    color: #555;
    font-weight: 600;
}
```

---

**À continuer dans le prochain fichier...**
