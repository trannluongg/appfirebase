import $ from 'jquery';
import FirebaseNotify from "../../components/firebase_notify/_firebase_notify";

var Dashboard = {
    init() {

    }
}

$(function () {
    FirebaseNotify.init();
    Dashboard.init();
})