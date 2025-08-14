# Components Architecture

## Nieuwe Schaalbare Mappenstructuur

Deze mappenstructuur is ontworpen voor schaalbaarheid en voorkomt wildgroei van componenten.

### 📁 Structuur Overzicht

```
src/components/
├── features/          # Feature-gebaseerde componenten
│   ├── auth/         # Authenticatie gerelateerde componenten
│   ├── news/         # Nieuws gerelateerde componenten
│   └── dashboard/    # Dashboard gerelateerde componenten
├── forms/            # Herbruikbare formulieren
├── ui/               # Basis UI componenten (buttons, inputs, etc.)
└── index.ts          # Barrel exports voor gemakkelijke imports
```

### 🎯 Principes

#### 1. **Feature-based Organisatie**

- Componenten worden gegroepeerd per business functionaliteit
- Elke feature map heeft eigen index.ts voor exports
- Gemakkelijk te vinden en onderhouden

#### 2. **Component Type Organisatie**

- `ui/` - Basis UI componenten (Button, Input, Modal, etc.)
- `forms/` - Specifieke formulieren die herbruikbaar zijn
- `layouts/` - Layout componenten (blijft in eigen map)

#### 3. **Barrel Exports**

- Elke map heeft een index.ts bestand
- Vereenvoudigt imports: `import { LoginForm } from '@/components'`
- Centraal beheer van exports

### 📝 Naming Conventions

#### Feature Componenten

- **Naam**: Beschrijft functionaliteit
- **Locatie**: `features/{feature-name}/ComponentName.vue`
- **Voorbeeld**: `features/auth/LoginForm.vue`

#### UI Componenten

- **Naam**: Generieke beschrijving
- **Locatie**: `ui/ComponentName.vue`
- **Voorbeeld**: `ui/Button.vue`, `ui/InputField.vue`

#### Form Componenten

- **Naam**: Eindigt met 'Form'
- **Locatie**: `forms/EntityForm.vue`
- **Voorbeeld**: `forms/ProfileForm.vue`, `forms/ContactForm.vue`

### 🔄 Import Patterns

#### Oude manier (vermijden):

```typescript
import LoginForm from "../components/LoginForm.vue";
import ProfileForm from "../components/ProfileForm.vue";
import InputField from "../components/ui/InputField.vue";
```

#### Nieuwe manier (aanbevolen):

```typescript
import { LoginForm, ProfileForm, InputField } from "@/components";
```

Of specifiek per feature:

```typescript
import { LoginForm } from "@/components/features/auth";
import { ProfileForm } from "@/components/forms";
```

### 🚀 Schaalbaarheid Voordelen

1. **Duidelijke Scheiding**: Elke component heeft een logische plek
2. **Gemakkelijk Zoeken**: Feature-based organisatie
3. **Herbruikbaarheid**: UI componenten zijn duidelijk gescheiden
4. **Onderhoudbaarheid**: Gerelateerde componenten bij elkaar
5. **Team Samenwerking**: Duidelijke eigendom per feature

### 📋 Wanneer Gebruik Je Welke Map?

#### `features/{feature}/`

- Componenten specifiek voor één business functionaliteit
- Componenten die business logica bevatten
- Componenten die niet herbruikbaar zijn buiten de feature

#### `ui/`

- Basis UI building blocks
- Styling focused componenten
- Volledig herbruikbare componenten
- Geen business logica

#### `forms/`

- Complexe formulieren met validation
- Herbruikbare formulieren
- Formulieren met eigen state management

### 🔧 Toekomstige Uitbreidingen

Wanneer de applicatie groeit:

```
features/
├── auth/
├── news/
├── dashboard/
├── users/           # Nieuwe feature
├── analytics/       # Nieuwe feature
├── settings/        # Nieuwe feature
└── notifications/   # Nieuwe feature

ui/
├── buttons/
│   ├── Button.vue
│   ├── IconButton.vue
│   └── LoadingButton.vue
├── inputs/
├── modals/
└── navigation/

forms/
├── ProfileForm.vue
├── ContactForm.vue
├── NewsletterForm.vue
└── FeedbackForm.vue
```

### 💡 Best Practices

1. **Een component per feature**: Houdt componenten feature-specifiek
2. **Maximaal 10 componenten per map**: Split op bij groei
3. **Descriptieve namen**: Maak duidelijk wat het component doet
4. **Consistent gebruik van index.ts**: Voor alle mappen
5. **Documenteer nieuwe patterns**: Update deze README bij wijzigingen
