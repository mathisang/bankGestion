import React from 'react';
import {Route, Switch, Redirect} from 'react-router-dom';
import Profile from "./components/Settings/Profile";
import User from "./components/Settings/User";
import Categories from "./components/Settings/Categories";

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
                <Route path="/categories" component={Categories}/>
            </Switch>
        </main>
    )
}