import './bootstrap';
import * as bootstrap from 'bootstrap';
import Inputmask from "inputmask";
import MaskData from "maskdata";
import {
    driver
} from "driver.js";
import "driver.js/dist/driver.css";
import DataTable from 'datatables.net-bs5';

import $ from "jquery";
window.$ = $;
window.Inputmask = Inputmask;
window.MaskData = MaskData;
window.driver = driver;
window.bootstrap = bootstrap;
window.DataTable = DataTable;
