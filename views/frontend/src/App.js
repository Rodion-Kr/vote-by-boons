import 'core-js';

import React, {Component} from 'react';
import Polls from './components/Polls';
import Header from './components/Header';
import Loader from './components/Loader';
import Modal from './components/Modal';
import Modalwrapper from "./components/Modalwrapper";



class App extends Component {

    constructor(props) {
        super(props);
        this.state = {
            options: null,
            success: null,
            showModal: false,
            usersBoon: null,
            activeButton: true,
            load: null,
            used: null
        };
        this.onClickVote = this.onClickVote.bind(this);
        this.closeModal = this.closeModal.bind(this);
    }

    componentDidMount() {
        setInterval(() => {
            jQuery.ajax({
                method: "POST",
                url: this.props.voteUrl.updatesUrl,
                data: {'poll_id': this.props.voteUrl.pollId, 'nonce': this.props.voteUrl.createNonce},

                success: (response) => {
                    this.setState({options: response.data});
                }
            });
        }, 5000)
    }


    onClickVote(e, value, champion) {

        e.preventDefault();

        this.setState({
                activeButton: false,
                load: champion
            }
        );


        if (!this.props.currentUser) {
            this.setState({
                showModal: true
            })
        }

        jQuery.ajax({
            method: "POST",
            url: window.voteByBoons.voteUrl,
            data: {
                'poll_id': window.voteByBoons.pollId,
                'champion_id': champion,
                'boon_count': value,
                'nonce': window.voteByBoons.voteAction
            },

            success: (response) => {

                if (response.success) {

                    let boons = response.users_boon_count;

                    document.getElementById('quantity').innerHTML = boons;

                    this.setState({
                        options: response.data,
                        success: true,
                        showModal: true,
                        usersBoon: boons,
                        load: null,
                        used: value,
                        activeButton: true
                    });
                } else {
                    let boons = response.users_boon_count;
                    this.setState({
                        success: false,
                        showModal: true,
                        usersBoon: boons,
                        load: null,
                        used: value,
                        activeButton: true
                    });
                }
            }
        })

        e.target.reset();

   };

    closeModal() {
        this.setState({
            showModal: false
        })
    }


    render() {

        if (this.state.options) {

            var startDateInit = this.state.options.startDate;
            startDateInit = startDateInit.replace('-', '/');
            startDateInit = startDateInit.replace('-', '/');

            var fromTime = new Date(startDateInit);
            var toTime = new Date();
            var differenceTravel = toTime.getTime() - fromTime.getTime();
            var seconds = Math.floor((differenceTravel) / (1000));


            var endDateDateInit = this.state.options.endDate;
            endDateDateInit = endDateDateInit.replace('-', '/');
            endDateDateInit = endDateDateInit.replace('-', '/');
            var endTime = new Date(endDateDateInit);
            var toEndTime = new Date();
            var differenceTime = endTime.getTime() - toEndTime.getTime();
            var secondsend = Math.floor((differenceTime) / (1000));


            var active = '';

            if (seconds > 0 && secondsend > 0) {
                active = 'active'; //true
            } else if (seconds > 0 && secondsend < 0) {
                active = 'finished';//end
            } else {
                active = 'not_started';//false
            }
        }


        let Modalswitch = null;
        if (this.props.currentUser) {
            Modalswitch = <Modal
                closeModal={this.closeModal}
                success={this.state.success}
                usersBoon={this.state.usersBoon}
                used={this.state.used}
            />
        } else {
            Modalswitch = <Modalwrapper
                title="Unregister user!"
                closeModal={this.closeModal}
                unregister={"Need to login!"}
            >
            </Modalwrapper>
        }

        return (this.state.options) ? (


            <div className="vote-boons">
                <Header
                    title={this.state.options.name}
                    active={active}
                    seconds={seconds}
                    secondsend={secondsend}
                    startDate={this.state.options.startDate}
                    endDate={this.state.options.endDate}
                    isActive={this.state.options.isActive}/>

                <Polls
                    active={active}
                    options={this.state.options.pollChampions}
                    isActive={this.state.options.isActive}
                    onClickVote={this.onClickVote}
                    activeButton={this.state.activeButton}
                    load={this.state.load}

                />
                {(this.state.showModal) ?
                    Modalswitch : ''}
            </div>
        ) : (
            <div className="vote-boons">
                <Header
                    active={"active"}/>
                <Loader/>
            </div>
        );
    }
}

export default App;