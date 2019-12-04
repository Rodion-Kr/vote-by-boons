import React, {Component} from 'react';
import Statusbar from './Statusbar';


const Header = (props) => {

    return(
        <div className="vote-boons__header">
            <img className="vote-boons__logo" src="/wp-content/plugins/vote-by-boons/views/frontend/img/logo.png" alt="logo"/>
            <h1 className="vote-boons__title">{props.title}</h1>

            {(props.active !== 'active')?
            <Statusbar
                active={props.active}
                seconds={props.seconds}
                secondsend={props.secondsend}
                isActive={props.isActive}
                startDate={props.startDate}
                endDate={props.endDate}/>:''
            }
        </div>
    )

}

export default Header;