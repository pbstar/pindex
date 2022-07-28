import axios from 'axios';

function get (url, data) {
    return new Promise((resolve, reject) => {
        axios.get(url, {
            params: data
        }).then(response => {
            resolve(response.data)
        }).catch(err => {
            reject(err)
        })
    })
}
function post (url, data) {
    return new Promise((resolve, reject) => {
        axios.post(url,
            data
        ).then(response => {
            resolve(response.data);
        }).catch(err => {
            reject(err);
        })
    })
}
export default {
    get,
    post
};