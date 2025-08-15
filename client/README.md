# Components Architecture

## Moderne Co-locatie Architectuur

Deze architectuur implementeert **co-locatie** principes waar gerelateerde bestanden bij elkaar staan voor betere ontwikkelervaring.

### 📁 Huidige Structuur

```
src/
├── components/
│   └── ui/                      # Shared UI components
│       ├── InputField.vue       # Herbruikbare input component
│       └── index.ts             # UI exports
├── views/
│   ├── auth/
│   │   └── login/               # Login feature
│   │       ├── LoginPage.vue    # Login pagina
│   │       └── components/
│   │           └── LoginForm.vue # Login form component
│   ├── news/
│   │   ├── NewsOverviewPage.vue # News overzicht pagina
│   │   ├── NewsDetailPage.vue   # News detail pagina
│   │   └── components/          # News gerelateerde components
│   │       ├── NewsOverview.vue
│   │       └── NewsDetail.vue
│   ├── profile/
│   │   ├── ProfilePage.vue      # Profiel pagina
│   │   └── components/
│   │       └── ProfileForm.vue  # Profiel form component
└── services/                    # Shared services
    ├── authService.ts
    ├── newsService.ts
    └── api.ts
```

### 🎯 Architectuur Principes

#### 1. **Co-locatie van Gerelateerde Code**

- **Pages + Components**: Feature components staan bij hun pages
- **Korte Imports**: `./components/LoginForm.vue` in plaats van `../../../components/`
- **Mentale Cohesie**: Alles wat samen hoort staat bij elkaar

#### 2. **Duidelijke Scheiding**

- **`/components/ui/`**: Alleen herbruikbare UI building blocks
- **`/views/{feature}/components/`**: Feature-specifieke components
- **`/services/`**: Shared business logic en API calls

#### 3. **Feature-Based Organisatie**

- Elke feature (auth, news, profile) heeft eigen map
- Specifieke subfeatures krijgen eigen submappen (bijv. `auth/login/`)

### 📝 Naming Conventions

#### Views Structuur

- **Pagina's**: Eindigen met `Page.vue` (bijv. `LoginPage.vue`)
- **Components**: Beschrijvende namen (bijv. `LoginForm.vue`)
- **Submappen**: Feature-specifieke namen (bijv. `login/`, `register/`)

#### Component Types

- **UI Components**: Generieke naam (`InputField.vue`, `Button.vue`)
- **Feature Components**: Specifieke naam (`LoginForm.vue`, `NewsOverview.vue`)
- **Page Components**: Eindigt met `Page` (`ProfilePage.vue`)

### 🔄 Import Patterns

#### ✅ Huidige Manier (Co-locatie):

```typescript
// In LoginPage.vue
import LoginForm from "./components/LoginForm.vue";

// In ProfilePage.vue
import ProfileForm from "./components/ProfileForm.vue";

// Voor shared UI
import InputField from "../../components/ui/InputField.vue";
```

#### ✅ Voor Shared Components:

```typescript
import { InputField } from "@/components/ui";
```

### 🚀 Voordelen van Deze Architectuur

#### 1. **Developer Experience**

- **Minder Schakelen**: Gerelateerde bestanden bij elkaar
- **Sneller Navigeren**: Logische folder structuur
- **Duidelijke Context**: Zie meteen wat bij elkaar hoort

#### 2. **Onderhoudbaarheid**

- **Feature Ownership**: Teams kunnen features "ownen"
- **Gemakkelijke Refactoring**: Alles gerelateerd staat bij elkaar
- **Isolatie**: Changes in één feature beïnvloeden anderen niet

#### 3. **Schaalbaarheid**

- **Nieuwe Features**: Gemakkelijk toe te voegen
- **Sub-features**: Kunnen eigen submappen krijgen
- **Team Samenwerking**: Duidelijke grenzen per feature

### 📋 Wanneer Gebruik Je Welke Locatie?

#### `/views/{feature}/components/`

- ✅ Components specifiek voor die feature
- ✅ Forms die alleen door die feature gebruikt worden
- ✅ Business logica gerelateerd aan die feature
- ❌ Components die herbruikbaar zijn tussen features

#### `/components/ui/`

- ✅ Basis UI building blocks (buttons, inputs, modals)
- ✅ Styling-focused componenten zonder business logica
- ✅ Volledig herbruikbaar tussen alle features
- ❌ Feature-specifieke logica

### 🔧 Toekomstige Uitbreidingen

#### Nieuwe Feature Toevoegen:

```
views/
├── auth/
│   ├── login/               # Bestaand
│   ├── register/            # 👈 Nieuwe sub-feature
│   │   ├── RegisterPage.vue
│   │   └── components/
│   │       └── RegisterForm.vue
│   └── forgot-password/     # 👈 Nieuwe sub-feature
│       ├── ForgotPasswordPage.vue
│       └── components/
│           └── ForgotPasswordForm.vue
├── analytics/               # 👈 Volledig nieuwe feature
│   ├── AnalyticsPage.vue
│   └── components/
│       ├── Chart.vue
│       └── MetricCard.vue
```

#### UI Components Uitbreiding:

```
components/ui/
├── buttons/
│   ├── Button.vue
│   ├── IconButton.vue
│   └── LoadingButton.vue
├── forms/
│   ├── InputField.vue       # Bestaand
│   ├── TextArea.vue
│   └── Select.vue
└── feedback/
    ├── Toast.vue
    └── Modal.vue
```

### 💡 Best Practices

#### 1. **Feature Cohesie**

- Houdt gerelateerde code bij elkaar
- Gebruik submappen voor complexe features (bijv. `auth/login/`)

#### 2. **Shared vs Feature-Specific**

- Shared UI → `/components/ui/`
- Feature-specific → `/views/{feature}/components/`

#### 3. **Consistent Naming**

- Pages eindigen met `Page.vue`
- Components hebben beschrijvende namen
- Folders gebruiken kebab-case

#### 4. **Import Strategie**

- Gebruik relative imports binnen features (`./components/`)
- Gebruik absolute imports voor shared (`@/components/ui/`)

### 🎯 Migratie Guidelines

#### Van Oude naar Nieuwe Structuur:

1. **Identificeer Feature**: Bepaal tot welke feature component behoort
2. **Maak Feature Map**: `views/{feature}/components/`
3. **Verplaats Component**: Naar juiste feature locatie
4. **Update Imports**: Naar relatieve paths binnen feature
5. **Test**: Controleer of alles nog werkt

#### Shared Component Identificatie:

- **Vraag**: "Wordt dit gebruikt door meerdere features?"
- **Ja** → `/components/ui/`
- **Nee** → `/views/{feature}/components/`

Deze architectuur biedt het beste van beide werelden: **co-locatie voor ontwikkelgemak** en **duidelijke scheiding voor onderhoudbaarheid**.

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
