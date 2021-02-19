import React, {Component} from 'react';

class Profile extends Component {
    render() {

        return (
            <div>
                <div className="setting">
                    <div className="headSetting">
                        <span>Ignorer</span>
                    </div>

                    {/*Récupérer utilisateur depuis bdd*/}
                    {/*Select color et update color*/}

                    <div className="boxPosition">
                        <h1>Bienvenue</h1>
                        <p>Personnalisez maintenant vos profils à votre goût.</p>

                        <div className="marginFlex colorProfile">
                            <h2>Mathis</h2>
                            <p>Sélectionnez votre couleur</p>
                            <div className="colorBar">
                                <div className="color blue selected"/>
                                <div className="color red"/>
                                <div className="color green"/>
                                <div className="color yellow"/>
                                <div className="color purple"/>
                                <div className="color new"/>
                            </div>
                        </div>

                        <div className="marginFlex colorProfile">
                            <h2>Abigail</h2>
                            <p>Sélectionnez votre couleur</p>
                            <div className="colorBar">
                                <div className="color blue"/>
                                <div className="color red selected"/>
                                <div className="color green"/>
                                <div className="color yellow"/>
                                <div className="color purple"/>
                                <div className="color new"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Profile;