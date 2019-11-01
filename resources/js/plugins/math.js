export default class
{
    static moneyFormat(number, locale = 'en-US') {
        return new Intl.NumberFormat(locale).format(number);
    }
}
