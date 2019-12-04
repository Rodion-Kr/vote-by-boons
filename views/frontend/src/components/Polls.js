import React, {Component} from 'react';
import Event from './Event';

const Polls = (props) => {

    function sortByAge(arr) {
        arr.sort((a, b) => a.boonsCount < b.boonsCount ? 1 : -1);
    }

    sortByAge(props.options);

    let heroEvent =  props.options.map((option, key) => <Event
                       key = {option.champion.id}
                        id = {props.id}
                boonsCount = {option.boonsCount}
                     color = {option.color}
            percentagePart = {option.percentagePart}
                  champion = {option.champion}
                 startDate = {props.startDate}
                   endDate = {props.endDate}
                  isActive = {props.isActive}
                   autoKey = {key}
               onClickVote = {props.onClickVote}
                    active = {props.active}
              activeButton = {props.activeButton}
                      load = {props.load}
    />,  );


    return (
        <div className="vote-boons__polls">
            <div className="vote-polls">
                {heroEvent}
            </div>
        </div>
    )
}

export default Polls;
