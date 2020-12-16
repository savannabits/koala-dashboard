window._ = require('lodash');
window.$ = window.jQuery = require('jquery')
require('alpinejs');
import Pristine from "pristinejs/dist/pristine.min";
/*Micromodal.js*/
import MicroModal from "micromodal";
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseURL = '/api'
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': token.content}});
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Common api methods
 */
window.apiSend = async function(uri, data = {}, method='post',queryParams = {}) {
    return new Promise(((resolve, reject) => {
        axios.request({
            method: method,
            url: uri,
            data: data,
        }).then(res => {
            resolve(res.data);
        }).catch(err => {
            // vm.$setErrorsFromResponse(err.response?.data);
            reject(err);
        }).finally(res => {
            // vm.hideLoader();
        })
    }))
}
window.apiFetch = function(uri, queryParams = {}) {
    return new Promise((resolve, reject) => {
        axios.get(uri,{
            params: queryParams||{}
        }).then(res => {
            resolve(res.data);
        }).catch(err => {
            reject(err);
        }).finally(res => {
            //TODO implement loader
        })
    })
}
/*GLOBAL ALPINE EVENTS DISPATCH*/
window.dispatchAlpineEvent = function(name, data) {
    window.dispatchEvent(new CustomEvent(name,{bubbles: true,detail: data}));
}
window.dispatchModalEvent = function(modalId, payload = {}) {
    window.dispatchEvent(new CustomEvent('show-modal', {bubbles: true,detail: {payload: payload,modalId: modalId}}));
}
MicroModal.init({
    onShow: modal => console.info(`${modal.id} is shown`), // [1]
    onClose: modal => console.info(`${modal.id} is hidden`), // [2]
    openTrigger: 'data-kmodal-open', // [3]
    closeTrigger: 'data-kmodal-close', // [4]
    openClass: 'is-open', // [5]
    disableScroll: true, // [6]
    disableFocus: false, // [7]
    awaitOpenAnimation: false, // [8]
    awaitCloseAnimation: false, // [9]
    debugMode: true // [10]
});

/*Server Validation using Pristine js */
window.startValidation = function(formId) {
    let form = document.getElementById(formId);
    let defaultConfig = {
        // class of the parent element where the error/success class is added
        classTo: 'form-group',
        errorClass: 'has-error',
        successClass: 'has-success',
        // class of the parent element where error text element is appended
        errorTextParent: 'form-group',
        // type of element to create for the error text
        errorTextTag: 'div',
        // class of the error text element
        errorTextClass: 'text-sm font-semibold'
    };
    return new Pristine(form, defaultConfig);
}
window.setServerValidationErrors = function(validator,errorBag = {}) {
    for (let field in errorBag) {
        validator.addError(field,errorBag[0]) // set laravel error
    }
    return validator;
}
window.onload = function () {
    /*Datepickers*/
    let dp = flatpickr('.datepicker',{
        dateFormat: 'Y-m-d',
    })
    flatpickr('.datetimepicker', {
        enableTime: true,
        enableSeconds: false,
        dateFormat: 'Y-m-d H:i:00',
    })
}
