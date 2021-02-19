import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import Index from './Index';
import * as serviceWorker from "./serviceWorker";
serviceWorker.register();
ReactDOM.render(<Router><Index /></Router>, document.getElementById('root'));
