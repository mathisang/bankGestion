import React from 'react';
import {Route, Switch, Redirect} from 'react-router-dom';
import Profile from "./components/Profile";
import User from "./components/User";

export default function ({}) {
    let statutSetting = 1;

    return (
        <main>
            <Switch>
                {statutSetting === 1 && (
                    <Redirect exact from="/" to="/profile"/>
                )}
                <Route path="/user" component={User}/>
                <Route path="/profile" component={Profile}/>
            </Switch>
        </main>
    )
}