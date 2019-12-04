import React, {Component} from 'react';

const Modalwrapper = (props) => {

    return (
        <div className="modal">

            <div className="modal__wrapper">
                <div className="modal__header">
                    <p className="modal__title">{props.title}</p>
                    <span onClick={props.closeModal} className="modal__close"><img src="/wp-content/plugins/vote-by-boons/views/frontend/img/close.png" alt="close" /></span>
                </div>
                <div className="modal__line">
                    <span className="modal__sub-line"></span>
                </div>
                <div className="modal__body">
                    {props.children}
                    <p className="modal__unregister">{props.unregister}</p>
                </div>
            </div>
        </div>
     )
}


export default Modalwrapper;