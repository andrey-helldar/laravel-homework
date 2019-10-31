import Lang from 'lang.js';
import messages from './messages';

let _html = document.getElementsByTagName('html')[0];

let locale = _html.getAttribute('lang');
let fallback = 'en';

export default new Lang({messages, locale, fallback});
