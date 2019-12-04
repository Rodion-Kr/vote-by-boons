import React from 'react';

function getTimeBoons(props){


    let d;
    if(Math.abs(Math.trunc(props.seconds/(3600*24))) > 0){
        d = Math.abs(Math.trunc(props.seconds/(3600*24))) + 'd';
    }else{
        d =  '';
    }

    let h, remaining;
    remaining = Math.abs(Math.ceil(props.seconds%(3600*24)));
    if (Math.ceil(remaining/3600) > 0){
        h = Math.trunc(remaining/3600) + 'h';
    }else{
        h = '';
    }

    let m, remainingMin, min;
    remainingMin = remaining%3600;
    min = Math.trunc(remainingMin/60);

    if (min > 0){
        m = min + 'm';
    }else{
        m = '';
    }

    let s, remainingSec, sec;
    remainingSec = remainingMin%60;
    sec =  remainingSec;
    if (sec > 0){
        s = sec + 's';
    }else{
        s = '';
    }

    let arr = [d, h, m, s];

    return arr;
}

export default getTimeBoons;