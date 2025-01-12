import './bootstrap';
import * as bootstrap from 'bootstrap';
import Inputmask from "inputmask";
import { driver } from "driver.js";
import "driver.js/dist/driver.css";
import DataTable from 'datatables.net';

import $ from "jquery";
window.$ = $;
window.Inputmask = Inputmask;
window.driver = driver;
window.bootstrap = bootstrap;
window.DataTable = DataTable;