import React, {Component} from 'react';
import {Redirect} from 'react-router-dom';
import axios from "axios";

class User extends Component {
    constructor(props) {
        super(props);
        this.state = {
            yourName: '',
            hisName: '',
            step: false
        };
    }

    render() {
        if (this.state.step) {
            return <Redirect to = {{ pathname: "/profile" }} />;
        }

        const handleSubmit = (event) => {
            event.preventDefault();

            pushDatabase([{'user': this.state.yourName,'color': '#2X1541'},{'user': this.state.hisName,'color': '#AZ1541'}]);
        }

        const skipNaming = () => {
            pushDatabase([{'user': 'Utilisateur 1','color': '#2X1541'},{'user': 'Utilisateur 2','color': '#AZ1541'}]);
        }

        const pushDatabase = (user) => {
            for (let i = 0; i < 2; i++) {
                let username = user[i];
                axios.post(`http://127.0.0.1:8000/api/users`, {username})
                    .then(res => {
                        this.setState({ step: true });
                    })
            }
        }

        return (
            <div>
                <div className="setting">
                    <div className="headSetting">
                        <span onClick={skipNaming}>Ignorer</span>
                    </div>

                    <div className="whoAreYou">
                        <h1>Qui êtes-vous ?</h1>
                        <p>Nous avons uniquement besoin de vos prénoms.</p>
                        <p>Cela permettra de personnaliser vos dépenses.</p>

                        <form className="boxNaming" id="formName">
                            <label htmlFor="yourName">Votre prénom</label>
                            <input type="text" name="yourName" value={this.state.yourName}
                                   onChange={e => this.setState({yourName: e.target.value})}/>
                            <label htmlFor="hisName">Son prénom</label>
                            <input type="text" name="hisName" value={this.state.hisName}
                                   onChange={e => this.setState({hisName: e.target.value})}/>
                            <div className="bottomSetting">
                                <span onClick={handleSubmit}>Suivant</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        )
    }
}

export default User;