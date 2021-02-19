import React, {Component} from 'react';

class Profile extends Component {
    render() {

        return (
            <div>
                <div className="setting">
                    <div className="headSetting">
                        <span>Ignorer</span>
                    </div>

                    <div className="whoAreYou">
                        <h1>Bienvenue</h1>
                        <p>Nous avons uniquement besoin de vos prénoms.</p>
                        <p>Cela permettra de personnaliser vos dépenses.</p>
                    </div>
                </div>
            </div>
        )
    }
}

export default Profile;