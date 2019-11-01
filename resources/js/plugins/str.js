export default class
{
    static random(length = 16) {
        let possible = 'ABCEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        let text = '';

        for (let i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }

        return text;
    }
}
