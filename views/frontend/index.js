import './scss/main.scss';
import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import App from './src/App';

ReactDOM.render(
    <App
        voteUrl={window.voteByBoons}
        jQuery={window.jQuery}
        currentUser={window.voteByBoons.currentUser}
    />,
    document.querySelector(`#poll-${window.voteByBoons.pollId}`)
);