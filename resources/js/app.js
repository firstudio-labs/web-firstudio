import './bootstrap';
import { initI18n, translations } from './i18n';

function syncFlipWordsGlobal() {
  const idWords = (translations.id['contact.hero.flipWords'] || '').split('|').filter(Boolean);
  const enWords = (translations.en['contact.hero.flipWords'] || '').split('|').filter(Boolean);
  window.firstudioFlipWords = { id: idWords, en: enWords };
}

document.addEventListener('DOMContentLoaded', () => {
  syncFlipWordsGlobal();
  initI18n();
});
