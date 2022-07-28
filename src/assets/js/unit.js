import md5 from 'js-md5';
function toMd5 (str) {
    if (str) {
        return md5(str);
    }
}
export default {
    toMd5
};