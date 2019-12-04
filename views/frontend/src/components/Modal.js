import React, {Component} from 'react';
import Modalwrapper from "./Modalwrapper";


const Modal = (props) => {

    if (props.success) {
        return <Modalwrapper
            title="Thanks for voting!"
            closeModal={props.closeModal}
        >
            <p className="modal__notice">Thank you for your vote. You used {props.used} Boons. Your current balance is {props.usersBoon }  Boons.</p>
            <p className="modal__follow">Please follow the link to
                <a className="modal__link" href="/shop/">get more Boons</a>
            </p>
        </Modalwrapper>

    } else {
        return <Modalwrapper
            title="Sorry, not enough boons"
            closeModal={props.closeModal}
        >
            <p className="modal__notice">Your current balance of Boons is {props.usersBoon }</p>
            <p className="modal__follow">Please follow the link to
                <a className="modal__link" href="/shop/">get more Boons</a>
            </p>
        </Modalwrapper>
    }

}

export default Modal;
