import './bootstrap';
import * as bootstrap from 'bootstrap';
import $ from "jquery";
import Inputmask from "inputmask";
import MaskData from "maskdata";
import {
    driver
} from "driver.js";
import "driver.js/dist/driver.css";
import DataTable from 'datatables.net-bs5';


window.bootstrap = bootstrap;
window.$ = $;
window.Inputmask = Inputmask;
window.MaskData = MaskData;
window.driver = driver;
window.DataTable = DataTable;
