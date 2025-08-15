# Router Architecture

## Schaalbare Router Structuur

Deze router architectuur is ontworpen voor schaalbaarheid en onderhoudbaarheid.

### 📁 Structuur Overzicht

```
src/router/
├── routes/           # Route module definities
│   ├── auth.ts       # Authenticatie routes (/login)
│   ├── news.ts       # Nieuws routes (/news, /news/:id)
│   ├── profile.ts    # Profiel routes (/profile)
│   ├── core.ts       # Core routes (/, 404)
│   └── index.ts      # Barrel exports
├── index.ts          # Hoofdrouter configuratie
└── README.md         # Deze documentatie
```

### 🎯 Voordelen

#### 1. **Feature Separatie**

- Elke feature heeft eigen route bestand
- Gemakkelijk te vinden en onderhouden
- Duidelijke eigendom per team/developer

#### 2. **Schaalbaarheid**

- Nieuwe features krijgen eigen route bestand
- Hoofdrouter blijft klein en overzichtelijk
- Geen merge conflicts bij parallelle ontwikkeling

#### 3. **Type Safety**

- Gebruik van `RouteRecordRaw` voor type checking
- Consistente route definitie structure
- IntelliSense ondersteuning

#### 4. **Lazy Loading Ready**

- Gemakkelijk om te switchen naar lazy loading
- Performance optimalisatie mogelijk per feature
- Code splitting per feature

### 📝 Route Conventie

#### Feature Route Bestand

```typescript
import type { RouteRecordRaw } from "vue-router";
import { FeaturePage } from "@/views";

export const featureRoutes: RouteRecordRaw[] = [
  {
    path: "/feature",
    name: "Feature",
    component: FeaturePage,
    meta: {
      layout: "DefaultLayout",
      requiresAuth: true,
    },
  },
];
```

#### Meta Fields

- `layout`: Layout component ('DefaultLayout', 'AuthLayout')
- `requiresAuth`: Route requires authentication
- `requiresGuest`: Route only for non-authenticated users
- `title`: Page title (optioneel)
- `breadcrumb`: Breadcrumb info (optioneel)

### 🔄 Huidige Routes

#### Auth Routes (`/router/routes/auth.ts`)

- `/login` - Login pagina (alleen voor gasten)

#### News Routes (`/router/routes/news.ts`)

- `/news` - Nieuws overzicht
- `/news/:id` - Nieuws detail pagina

#### Profile Routes (`/router/routes/profile.ts`)

- `/profile` - Profiel pagina

#### Core Routes (`/router/routes/core.ts`)

- `/` - Root redirect
- `/*` - 404 fallback

### 🚀 Toekomstige Uitbreidingen

Bij groei van de applicatie:

```
router/routes/
├── auth.ts           # Bestaand
├── news.ts           # Bestaand
├── profile.ts        # Bestaand
├── users.ts          # Nieuwe feature
├── analytics.ts      # Nieuwe feature
├── settings.ts       # Nieuwe feature
├── admin.ts          # Admin routes
└── api.ts            # API documentatie routes
```

### 💡 Best Practices

#### 1. **Route Naming**

```typescript
// Consistent naming pattern
{
  path: '/users',
  name: 'Users',           // PascalCase
  component: UsersPage,
}
{
  path: '/users/:id',
  name: 'UserDetail',      // Feature + Action
  component: UserDetailPage,
}
```

#### 2. **Meta Configuration**

```typescript
meta: {
  layout: 'DefaultLayout',     // Consistent layout usage
  requiresAuth: true,          // Clear auth requirements
  title: 'Page Title',         // SEO friendly
  breadcrumb: {                // Navigation aid
    label: 'Users',
    parent: 'Profile'
  }
}
```

#### 3. **Lazy Loading (toekomst)**

```typescript
// In feature route file
export const userRoutes: RouteRecordRaw[] = [
  {
    path: "/users",
    name: "Users",
    component: () => import("@/views/features/users/UsersPage.vue"),
    meta: {
      layout: "DefaultLayout",
      requiresAuth: true,
    },
  },
];
```

#### 4. **Route Guards per Feature**

```typescript
// In feature route file
import { requiresRole } from "../guards";

export const adminRoutes: RouteRecordRaw[] = [
  {
    path: "/admin",
    name: "Admin",
    component: AdminPage,
    beforeEnter: requiresRole("admin"),
    meta: {
      layout: "AdminLayout",
      requiresAuth: true,
    },
  },
];
```

### 🔧 Navigation Guards

De hoofdrouter bevat globale guards:

- **Authentication Check**: Controleert of gebruiker ingelogd is
- **Guest Routes**: Voorkomt toegang voor ingelogde gebruikers
- **Token Validation**: Verifieert token geldigheid

Feature-specifieke guards kunnen toegevoegd worden in de feature route bestanden.

### 📋 Checklist Nieuwe Feature

Bij het toevoegen van een nieuwe feature:

1. ✅ Maak nieuwe feature route bestand
2. ✅ Definieer routes met correcte meta data
3. ✅ Export routes in features/index.ts
4. ✅ Import en spread in hoofdrouter
5. ✅ Test routes in browser
6. ✅ Update deze documentatie indien nodig

### 🎭 Route Meta Examples

```typescript
// Public route
meta: {
  layout: 'PublicLayout',
  requiresGuest: true,
}

// Protected route
meta: {
  layout: 'DefaultLayout',
  requiresAuth: true,
}

// Admin route
meta: {
  layout: 'AdminLayout',
  requiresAuth: true,
  requiresRole: 'admin',
}

// Full meta example
meta: {
  layout: 'DefaultLayout',
  requiresAuth: true,
  title: 'User Management',
  breadcrumb: {
    label: 'Users',
    parent: 'Profile'
  },
  permissions: ['users.read'],
}
```
