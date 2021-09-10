import $ from 'jquery';
import firebase from 'firebase/app';
import '@firebase/messaging';
import {Storage} from "../../common/common_import";
import firebaseConfig from "./_firebase_config";
import Http from "../../helpers/Http";

var FirebaseNotify = {
    timeOut : '',
    init() {
        this.runFireBaseNotify();
    },
    runFireBaseNotify() {
        let _this = this;
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        messaging.requestPermission()
            .then(function () {
                return messaging.getToken();
            })
            .then(function (token) {
                _this.saveStorageToken(token);
            })
            .catch(function (err) {
                console.log(err);
            });

        messaging.onMessage(function (payload) {
            _this.showNotify(payload);
        });
    },

    showNotify(payload)
    {
        let _this = this,
            data = payload.data,
            notify_type = data.notify_type,
            type = data.type;
    },

    saveStorageToken(token)
    {
        let _this = this;
        let storage_token = Storage.getStorage('firebase_token');
        if(storage_token.token !== undefined) {
            let oldToken = storage_token.token,
                user_id = storage_token.user_id;
            // Token cũ
            if(oldToken === token)
            {
                // Nếu user chưa đăng nhập thì không cập nhật thông tin token
                if(AUTH === '0') return true;
                // Nếu user đăng nhập vào thì cập nhật lại thông tin token
                if(user_id !== AUTH) _this.createOrUpdateToken(token);
            }
            else {
                _this.createOrUpdateToken(token, oldToken);
            }
        }
        else {
            _this.createOrUpdateToken(token);
        }
    },

    createOrUpdateToken(token, oldToken = '')
    {
        Storage.delStorage('firebase_token');
        let data = {
            token : token,
            user_id : AUTH
        };
        Storage.setStorage('firebase_token', data);
        console.log(data)
        Http.post({
            url : URL_UPDATE_FIREBASE_DEVICE,
            data : {
                _token: _TOKEN,
                token : token,
                old_token : oldToken
            }
        }).done(function (data) {
        }).fail(function (error) {
            console.log(error);
        });
    }
};
export default FirebaseNotify;