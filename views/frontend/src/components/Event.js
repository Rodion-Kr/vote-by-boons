import React, {Component} from 'react';

class Event extends Component {

    constructor(props) {
        super(props);

        this.state = {value: 1}
    }

    render() {

        let quantity;

        if(this.props.active === 'active' || this.props.active === 'finished'){
            quantity = this.props.boonsCount;
        }else{
            quantity = '0';
        }


        const opacity = (this.props.isActive) ? '' : 'vote-polls__hero-form-opacity';


        let style = {}
        if(this.props.active !== 'not_started') {
            style = {
                background: this.props.color,
                width: this.props.percentagePart + '%'
            }
        }else{
            style = {
                background: this.props.color,
                width: '0'
            }
        }

        let disableStyle = {color: '#444444'}

        if(this.props.active !== 'active'){
             disableStyle = {
                 color: '#999999'
             }
        }

        let herocolor = {}
        if(this.props.active === 'not_started') {
            herocolor = {
                'backgroundImage': 'url(/wp-content/plugins/vote-by-boons/views/frontend/img/line.jpg)',
                'borderRadius': '0 3px 3px 0'
            }
        }


        let onChange = (event) => {
            this.setState({value: event.target.value});
        }

        if(this.props.activeButton && this.props.isActive){
            var position = false;
        }else{
            var position = true;
        }

        let championLogo;

        if(this.props.champion.image){
            championLogo = this.props.champion.image;
        }else{
            championLogo = this.props.champion.clan.logo;
        }

        return (
            <div className="vote-polls__hero">
                <div className="vote-polls__hero-info">
                    <span className="vote-polls__hero-order">{this.props.autoKey + 1}</span>
                    <img className="vote-polls__hero-img" src={championLogo} alt="logo"/>
                    <div className="vote-polls__hero-line">
                        <span className="vote-polls__hero-name">{this.props.champion.name}</span>
                        <p className="vote-polls__hero-color" style={herocolor}>
                            <span className="vote-polls__hero-color-val" style={style}></span>
                        </p>
                    </div>
                </div>
                <p className="vote-polls__hero-value" style={disableStyle}>{quantity}</p>
                <form className={`vote-polls__hero-form ${opacity}`} onSubmit={e => this.props.onClickVote( e, this.state.value, this.props.champion.id) }>
                    <div className="vote-polls__hero-box">
                        <input disabled={!this.props.isActive} onChange={onChange}  className="vote-polls__hero-number" name="vote" type="number"
                               min="0" max="99999" placeholder="0" maxLength="5" step="1" pattern="^[0-9]"/>
                        <button disabled={position} className="vote-polls__hero-submit" value="Vote">Vote</button>
                    </div>
                    {this.props.load === this.props.champion.id && (
                        <p className="vote-polls__loader-box"><img className="vote-polls__loader" src="/wp-content/plugins/vote-by-boons/views/frontend/img/loader.gif" alt="loader"/></p>
                    )}
                </form>
            </div>
        );
    }
}

export default Event;
