import React, {Component} from 'react';
import ProfileColor from "./profileColor";
import axios from "axios";
import {Redirect} from "react-router-dom";

class Profile extends Component {
    constructor() {
        super();
        this.state = {
            users: [],
            loading: true,
            step: false
        };
    }

    componentDidMount() {
        this.getUsers();
    }

    getUsers() {
        axios.get(`http://localhost:8000/api/get/users`).then(users => {
            this.setState({users: users.data, loading: false})
        })
    }

    render() {
        if (this.state.step) {
            return <Redirect to = {{ pathname: "/categories" }} />;
        }

        const updateColors = () => {
            // console.log(document.querySelector("#user" + user.id + " .selected").classList[1]);
            this.state.users.map(user => {
                let color = document.querySelector("#user" + user.id + " .selected").classList[1];
                let username = {'id': user.id, 'user': user.name, 'color': color};
                axios.post(`http://127.0.0.1:8000/api/update/users`, {username})
                    .then(res => {
                        this.setState({step: true});
                    })
                }
            )
        }

        return (
            <div>
                <div className="setting">
                    <div className="headSetting">
                        <span>Ignorer</span>
                    </div>

                    <div className="boxPosition">
                        <h1>Bienvenue</h1>
                        <p>Personnalisez maintenant vos profils à votre goût.</p>

                        {this.state.users.map(user =>
                            <ProfileColor key={user.id} user={user}/>
                        )}

                        <div className="bottomSetting">
                            <span onClick={updateColors}>Suivant</span>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Profile;