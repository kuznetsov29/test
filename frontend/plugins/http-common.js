import axios from 'axios';

export const HTTP = axios.create({
    baseURL: process.env.BASE_URL || 'http://api.test.ru/',
    // headers: {
    //     Authorization: 'Bearer {}', //В этом тесте авторизация отсутствует
    // },
});