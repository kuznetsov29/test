
import axios from 'axios';

export const HTTP = axios.create({
    baseURL: 'http://api.test.ru/',
    // headers: {
    //     Authorization: 'Bearer {}', //В этом тесте авторизация отсутствует
    // },
});