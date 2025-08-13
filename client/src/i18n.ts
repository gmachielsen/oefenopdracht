import { createI18n } from "vue-i18n";
import nl from "./locales/nl.json";
import en from "./locales/en.json";

const i18n = createI18n({
  legacy: false,
  locale: "nl", // Standaard Nederlands
  fallbackLocale: "nl",
  messages: {
    nl,
    en,
  },
});

export default i18n;

// Helper functie om taal te wijzigen
export const changeLocale = (locale: string) => {
  i18n.global.locale.value = locale as "nl" | "en";
  localStorage.setItem("locale", locale);

  // Update document taal attribuut
  document.documentElement.lang = locale;
};

// Beschikbare talen met tekstuele representatie van vlaggen
export const availableLocales = [
  { code: "nl", name: "Nederlands", flag: "NL" },
  { code: "en", name: "English", flag: "GB" },
];
