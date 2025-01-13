import './bootstrap';
import * as bootstrap from 'bootstrap';
import Inputmask from "inputmask";
import {
    driver
} from "driver.js";
import "driver.js/dist/driver.css";
import DataTable from 'datatables.net-bs5';
import '../../node_modules/notiflix/src/notiflix.css';
import '../../node_modules/notiflix/src/notiflix.js';

import $ from "jquery";
window.$ = $;
window.Inputmask = Inputmask;
window.driver = driver;
window.bootstrap = bootstrap;
window.DataTable = DataTable;
