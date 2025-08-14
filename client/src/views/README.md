# Views Architecture

## Schaalbare Views Structuur

De views (pagina's) zijn georganiseerd per feature om schaalbaarheid en onderhoudbaarheid te verbeteren.

### 📁 Structuur Overzicht

```
src/views/
├── features/          # Feature-gebaseerde pagina's
│   ├── auth/         # Authenticatie pagina's
│   │   └── LoginPage.vue
│   ├── news/         # Nieuws pagina's
│   │   ├── NewsOverviewPage.vue
│   │   └── NewsDetailPage.vue
│   ├── dashboard/    # Dashboard pagina's
│   │   └── DashboardPage.vue
│   └── profile/      # Profiel pagina's
│       └── ProfilePage.vue
└── index.ts          # Barrel exports
```

### 🎯 Organisatie Principes

#### 1. **Feature-based Grouping**

- Pagina's worden gegroepeerd per business functionaliteit
- Overeenkomend met de component structuur
- Gemakkelijk te vinden en onderhouden

#### 2. **Consistent Naming**

- Pagina's eindigen altijd met 'Page'
- Duidelijke, beschrijvende namen
- CamelCase voor bestandsnamen

#### 3. **Barrel Exports**

- Elke feature heeft eigen index.ts
- Centralized imports via `/views`
- Vereenvoudigde router configuratie

### 🔄 Router Integration

#### Oude manier:

```typescript
import LoginPage from "@/views/LoginPage.vue";
import DashboardPage from "@/views/DashboardPage.vue";
// etc...
```

#### Nieuwe manier:

```typescript
import {
  LoginPage,
  DashboardPage,
  NewsOverviewPage,
  NewsDetailPage,
} from "@/views";
```

### 🚀 Schaalbaarheid Voordelen

1. **Duidelijke Feature Grenzen**: Elke feature heeft eigen views
2. **Gemakkelijke Navigatie**: Logische gruppering
3. **Team Vriendelijk**: Eigendom per feature duidelijk
4. **Consistent Pattern**: Zelfde structuur als components

### 📋 Guidelines

#### Nieuwe View Toevoegen:

1. Bepaal de juiste feature categorie
2. Plaats in `features/{feature}/NewPage.vue`
3. Update `features/{feature}/index.ts`
4. Naam eindigt altijd met 'Page'

#### Nieuwe Feature:

1. Maak `features/{new-feature}/` folder
2. Voeg pagina's toe aan de folder
3. Maak `index.ts` met exports
4. Update hoofdindex `/views/index.ts`

### 🔧 Toekomstige Uitbreidingen

```
features/
├── auth/
├── news/
├── dashboard/
├── profile/
├── users/           # Nieuwe feature
│   ├── UsersListPage.vue
│   ├── UserDetailPage.vue
│   └── index.ts
├── analytics/       # Nieuwe feature
│   ├── AnalyticsPage.vue
│   ├── ReportsPage.vue
│   └── index.ts
└── settings/        # Nieuwe feature
    ├── SettingsPage.vue
    ├── PreferencesPage.vue
    └── index.ts
```

### 💡 Best Practices

1. **Eén view per route**: Houdt routes simpel
2. **Feature cohesie**: Gerelateerde views bij elkaar
3. **Descriptieve namen**: Maak duidelijk wat de pagina doet
4. **Consistent gebruik van exports**: Voor alle features
