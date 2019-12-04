import React from 'react';
import getTimeBoons from '../../functions/getTimeBoons';


const Statusbar = (props) => {

    let setTime = getTimeBoons(props);

    if(props.active === 'not_started'){
        return (
            <div className="vote-boons__voting">
                <img className="vote-boons__voting-img" src="/wp-content/plugins/vote-by-boons/views/frontend/img/flag.png" alt="flag"/>
                <span className="vote-boons__voting-title">Voting will start in</span>
                <span className="vote-boons__voting-days">{setTime[0]} {setTime[1]} {setTime[2]} {setTime[3]}</span>
            </div>)
    }else{
        return (
            <div className="vote-boons__voting">
                <img className="vote-boons__voting-img"
                     src="/wp-content/plugins/vote-by-boons/views/frontend/img/flag_closed.png" alt="flag"/>
                < span className="vote-boons__voting-days">Voting has closed</span>
            </div>
        )
    }
}

export default Statusbar;