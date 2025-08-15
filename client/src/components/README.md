# Shared UI Components

Deze folder bevat **herbruikbare UI building blocks** die door meerdere features gebruikt kunnen worden.

## 📁 Structuur

```
components/
└── ui/                      # Shared UI components
    ├── InputField.vue       # Herbruikbare input component
    └── index.ts             # UI exports
```

## 🎯 Doel

De `/components/ui/` folder bevat **alleen** componenten die:

- ✅ Volledig herbruikbaar zijn tussen alle features
- ✅ Geen feature-specifieke business logica bevatten
- ✅ Puur UI/styling gericht zijn
- ✅ Als building blocks dienen voor complexere componenten

## 📋 Wanneer Gebruik Je Deze Folder?

### ✅ Wel hier plaatsen:

- Basis UI elementen (buttons, inputs, modals)
- Styling-focused componenten
- Generic building blocks
- Componenten zonder business context

### ❌ Niet hier plaatsen:

- Feature-specifieke componenten
- Components met business logica
- Forms die aan specifieke features gekoppeld zijn
- Components die maar door één feature gebruikt worden

## 🔄 Import Patronen

```typescript
// Voor shared UI components
import InputField from "@/components/ui/InputField.vue";

// Of via barrel export
import { InputField } from "@/components/ui";
```

## 💡 Architectuur Context

Deze folder is onderdeel van een **co-locatie architectuur**. Voor feature-specifieke componenten, zie:

- `/views/{feature}/components/` - Feature-specifieke componenten
- `/client/README.md` - Volledige architectuur documentatie

## 🚀 Toekomstige Uitbreidingen

Wanneer deze folder groeit, organiseer in submappen:

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

## 📝 Guidelines

1. **Herbruikbaarheid**: Component moet door minimaal 2+ features gebruikt worden
2. **Geen Business Logic**: Puur presentationeel
3. **Props Interface**: Duidelijke, generieke props
4. **Consistent Naming**: Beschrijvende, generieke namen
5. **TypeScript**: Alle componenten hebben TypeScript interfaces

Voor meer details over de volledige frontend architectuur, zie `/client/README.md`.
