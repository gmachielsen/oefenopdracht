import { createI18n } from "vue-i18n";
import nl from "./locales/nl.json";
import en from "./locales/en.json";

// Detecteer browser taal of gebruik Nederlands als fallback
const getBrowserLocale = (): string => {
  const browserLocale = navigator.language || navigator.languages[0];

  if (browserLocale.startsWith("en")) {
    return "en";
  }

  return "nl"; // Nederlands als fallback
};

// Haal opgeslagen taal op uit localStorage of gebruik browser detectie
const savedLocale = localStorage.getItem("locale");
const defaultLocale = savedLocale || getBrowserLocale();

const i18n = createI18n({
  legacy: false,
  locale: defaultLocale,
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
